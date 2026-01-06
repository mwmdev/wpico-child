#!/usr/bin/env node
/**
 * Simple PO to MO compiler for WordPress translations
 * Usage: node compile-mo.js <input.po> <output.mo>
 *
 * This is a basic implementation that handles simple PO files.
 * For production use, consider using msgfmt from gettext tools.
 */

const fs = require('fs');
const path = require('path');

if (process.argv.length < 4) {
    console.log('Usage: node compile-mo.js <input.po> <output.mo>');
    process.exit(1);
}

const poFile = process.argv[2];
const moFile = process.argv[3];

if (!fs.existsSync(poFile)) {
    console.error(`Error: PO file not found: ${poFile}`);
    process.exit(1);
}

/**
 * Parse a quoted string from PO format
 */
function parseString(str) {
    str = str.trim();
    if (str.length >= 2 && str[0] === '"' && str[str.length - 1] === '"') {
        str = str.slice(1, -1);
    }
    // Handle escape sequences
    str = str.replace(/\\n/g, '\n')
             .replace(/\\r/g, '\r')
             .replace(/\\t/g, '\t')
             .replace(/\\"/g, '"')
             .replace(/\\\\/g, '\\');
    return str;
}

/**
 * Parse PO file and return object of translations
 */
function parsePo(content) {
    const translations = {};
    let currentMsgid = '';
    let currentMsgstr = '';
    let inMsgid = false;
    let inMsgstr = false;

    const lines = content.split('\n');

    for (const rawLine of lines) {
        const line = rawLine.trim();

        // Skip comments or empty lines
        if (line === '' || line[0] === '#') {
            if (inMsgstr && currentMsgid !== '') {
                translations[currentMsgid] = currentMsgstr;
            }
            currentMsgid = '';
            currentMsgstr = '';
            inMsgid = false;
            inMsgstr = false;
            continue;
        }

        // Handle msgid
        if (line.startsWith('msgid ')) {
            if (inMsgstr && currentMsgid !== '') {
                translations[currentMsgid] = currentMsgstr;
            }
            currentMsgid = parseString(line.slice(6));
            currentMsgstr = '';
            inMsgid = true;
            inMsgstr = false;
            continue;
        }

        // Handle msgstr
        if (line.startsWith('msgstr ')) {
            currentMsgstr = parseString(line.slice(7));
            inMsgid = false;
            inMsgstr = true;
            continue;
        }

        // Handle continuation lines
        if (line[0] === '"') {
            const parsed = parseString(line);
            if (inMsgid) {
                currentMsgid += parsed;
            } else if (inMsgstr) {
                currentMsgstr += parsed;
            }
        }
    }

    // Don't forget the last entry
    if (currentMsgid !== '' || (inMsgstr && currentMsgstr !== '')) {
        translations[currentMsgid] = currentMsgstr;
    }

    return translations;
}

/**
 * Compile translations to MO format
 */
function compileMo(translations, outputFile) {
    // Extract header (empty msgid)
    const header = translations[''] || '';
    delete translations[''];

    // Sort originals alphabetically (required for binary search in MO format)
    const originals = Object.keys(translations).sort();

    // Re-add header at the beginning (empty string should come first)
    if (header) {
        originals.unshift('');
        translations[''] = header;
    }

    const count = originals.length;

    // MO file format constants
    const MAGIC = 0x950412de;
    const HEADER_SIZE = 28;
    const TABLE_ENTRY_SIZE = 8; // 2 x 4 bytes (length, offset)

    // Calculate offsets
    const tableSize = count * TABLE_ENTRY_SIZE;
    const originalsTableOffset = HEADER_SIZE;
    const translationsTableOffset = HEADER_SIZE + tableSize;
    const stringDataOffset = HEADER_SIZE + (tableSize * 2);

    // Build string data and offsets
    let currentOffset = stringDataOffset;
    const origOffsets = [];
    const transOffsets = [];
    let stringData = Buffer.alloc(0);

    // Process originals
    for (const original of originals) {
        const buf = Buffer.from(original, 'utf8');
        origOffsets.push({ len: buf.length, offset: currentOffset });
        stringData = Buffer.concat([stringData, buf, Buffer.from([0])]);
        currentOffset += buf.length + 1;
    }

    // Process translations
    for (const original of originals) {
        const translation = translations[original];
        const buf = Buffer.from(translation, 'utf8');
        transOffsets.push({ len: buf.length, offset: currentOffset });
        stringData = Buffer.concat([stringData, buf, Buffer.from([0])]);
        currentOffset += buf.length + 1;
    }

    // Build MO file
    const moBuffer = Buffer.alloc(HEADER_SIZE + (tableSize * 2) + stringData.length);
    let offset = 0;

    // Write header
    moBuffer.writeUInt32LE(MAGIC, offset); offset += 4;         // Magic number
    moBuffer.writeUInt32LE(0, offset); offset += 4;             // Version
    moBuffer.writeUInt32LE(count, offset); offset += 4;         // Number of strings
    moBuffer.writeUInt32LE(originalsTableOffset, offset); offset += 4;    // Offset of originals table
    moBuffer.writeUInt32LE(translationsTableOffset, offset); offset += 4; // Offset of translations table
    moBuffer.writeUInt32LE(0, offset); offset += 4;             // Hash table size
    moBuffer.writeUInt32LE(0, offset); offset += 4;             // Hash table offset

    // Write originals table
    for (const entry of origOffsets) {
        moBuffer.writeUInt32LE(entry.len, offset); offset += 4;
        moBuffer.writeUInt32LE(entry.offset, offset); offset += 4;
    }

    // Write translations table
    for (const entry of transOffsets) {
        moBuffer.writeUInt32LE(entry.len, offset); offset += 4;
        moBuffer.writeUInt32LE(entry.offset, offset); offset += 4;
    }

    // Write string data
    stringData.copy(moBuffer, offset);

    // Write to file
    fs.writeFileSync(outputFile, moBuffer);
    return true;
}

// Main execution
const content = fs.readFileSync(poFile, 'utf8');
const translations = parsePo(content);

console.log(`Found ${Object.keys(translations).length} translations`);

try {
    compileMo(translations, moFile);
    console.log(`Successfully compiled ${moFile}`);
    process.exit(0);
} catch (err) {
    console.error(`Error: Failed to write ${moFile}:`, err.message);
    process.exit(1);
}
