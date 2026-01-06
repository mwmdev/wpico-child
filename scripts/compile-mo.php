#!/usr/bin/env php
<?php
/**
 * Simple PO to MO compiler for WordPress translations
 * Usage: php compile-mo.php <input.po> <output.mo>
 *
 * This is a basic implementation that handles simple PO files.
 * For production use, consider using msgfmt from gettext tools.
 */

if ($argc < 3) {
    echo "Usage: php compile-mo.php <input.po> <output.mo>\n";
    exit(1);
}

$poFile = $argv[1];
$moFile = $argv[2];

if (!file_exists($poFile)) {
    echo "Error: PO file not found: $poFile\n";
    exit(1);
}

/**
 * Parse PO file and return array of translations
 */
function parsePo($content) {
    $translations = [];
    $currentMsgid = '';
    $currentMsgstr = '';
    $inMsgid = false;
    $inMsgstr = false;

    $lines = explode("\n", $content);

    foreach ($lines as $line) {
        $line = trim($line);

        // Skip comments
        if (empty($line) || $line[0] === '#') {
            if ($inMsgstr && $currentMsgid !== '') {
                $translations[$currentMsgid] = $currentMsgstr;
            }
            $currentMsgid = '';
            $currentMsgstr = '';
            $inMsgid = false;
            $inMsgstr = false;
            continue;
        }

        // Handle msgid
        if (strpos($line, 'msgid ') === 0) {
            if ($inMsgstr && $currentMsgid !== '') {
                $translations[$currentMsgid] = $currentMsgstr;
            }
            $currentMsgid = parseString(substr($line, 6));
            $currentMsgstr = '';
            $inMsgid = true;
            $inMsgstr = false;
            continue;
        }

        // Handle msgstr
        if (strpos($line, 'msgstr ') === 0) {
            $currentMsgstr = parseString(substr($line, 7));
            $inMsgid = false;
            $inMsgstr = true;
            continue;
        }

        // Handle continuation lines
        if ($line[0] === '"') {
            $parsed = parseString($line);
            if ($inMsgid) {
                $currentMsgid .= $parsed;
            } elseif ($inMsgstr) {
                $currentMsgstr .= $parsed;
            }
        }
    }

    // Don't forget the last entry
    if ($currentMsgid !== '') {
        $translations[$currentMsgid] = $currentMsgstr;
    }

    return $translations;
}

/**
 * Parse a quoted string from PO format
 */
function parseString($str) {
    $str = trim($str);
    if (strlen($str) >= 2 && $str[0] === '"' && substr($str, -1) === '"') {
        $str = substr($str, 1, -1);
    }
    // Handle escape sequences
    $str = str_replace(['\\n', '\\r', '\\t', '\\"', '\\\\'], ["\n", "\r", "\t", '"', '\\'], $str);
    return $str;
}

/**
 * Compile translations to MO format
 */
function compileMo($translations, $outputFile) {
    // Remove empty msgid (header) for now, keep it separate
    $header = isset($translations['']) ? $translations[''] : '';
    unset($translations['']);

    // Sort by original string
    ksort($translations);

    // Re-add header at the beginning
    if ($header) {
        $translations = ['' => $header] + $translations;
    }

    $count = count($translations);
    $originals = array_keys($translations);
    $translatedStrings = array_values($translations);

    // MO file format:
    // - magic number (4 bytes)
    // - version (4 bytes)
    // - number of strings (4 bytes)
    // - offset of original strings table (4 bytes)
    // - offset of translated strings table (4 bytes)
    // - size of hashing table (4 bytes)
    // - offset of hashing table (4 bytes)

    $headerSize = 28;
    $tableSize = $count * 8; // Each entry is 2 x 4 bytes (length, offset)

    // Calculate offsets
    $originalsTableOffset = $headerSize;
    $translationsTableOffset = $headerSize + $tableSize;
    $hashTableOffset = 0; // No hash table
    $hashTableSize = 0;

    // String data starts after both tables
    $stringDataOffset = $headerSize + ($tableSize * 2);

    // Build string data and tables
    $originalTable = '';
    $translationTable = '';
    $stringData = '';
    $currentOffset = $stringDataOffset;

    $origOffsets = [];
    $transOffsets = [];

    // First pass: originals
    foreach ($originals as $original) {
        $len = strlen($original);
        $origOffsets[] = ['len' => $len, 'offset' => $currentOffset];
        $stringData .= $original . "\0";
        $currentOffset += $len + 1;
    }

    // Second pass: translations
    foreach ($translatedStrings as $translation) {
        $len = strlen($translation);
        $transOffsets[] = ['len' => $len, 'offset' => $currentOffset];
        $stringData .= $translation . "\0";
        $currentOffset += $len + 1;
    }

    // Build tables
    foreach ($origOffsets as $entry) {
        $originalTable .= pack('VV', $entry['len'], $entry['offset']);
    }

    foreach ($transOffsets as $entry) {
        $translationTable .= pack('VV', $entry['len'], $entry['offset']);
    }

    // Build header
    $header = pack(
        'V*',
        0x950412de,           // Magic number (little-endian)
        0,                    // Version
        $count,               // Number of strings
        $originalsTableOffset,// Offset of original strings table
        $translationsTableOffset, // Offset of translated strings table
        $hashTableSize,       // Size of hashing table
        $hashTableOffset      // Offset of hashing table
    );

    // Write file
    $moContent = $header . $originalTable . $translationTable . $stringData;

    if (file_put_contents($outputFile, $moContent) === false) {
        return false;
    }

    return true;
}

// Main execution
$content = file_get_contents($poFile);
$translations = parsePo($content);

echo "Found " . count($translations) . " translations\n";

if (compileMo($translations, $moFile)) {
    echo "Successfully compiled $moFile\n";
    exit(0);
} else {
    echo "Error: Failed to write $moFile\n";
    exit(1);
}
