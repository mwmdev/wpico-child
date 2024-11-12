#!/bin/bash

# Function to convert string to slug
slugify() {
    echo "$1" | iconv -t ascii//TRANSLIT | sed -E 's/[^a-zA-Z0-9]+/-/g' | sed -E 's/^-+|-+$//g' | tr A-Z a-z
}

# Function to validate input is not empty
validate_input() {
    local input=$1
    local field=$2
    if [ -z "$input" ]; then
        echo "Error: $field cannot be empty"
        exit 1
    fi
}

# Function to validate hex color
validate_color() {
    local color=$1
    local field=$2
    if [[ ! $color =~ ^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$ ]]; then
        echo "Error: $field must be a valid hex color (e.g., #ff0000)"
        exit 1
    fi
}

# Get theme information
read -p "Theme Name (e.g., 'My Theme'): " THEME_NAME
validate_input "$THEME_NAME" "Theme Name"

read -p "Theme Author (e.g., 'John Doe'): " THEME_AUTHOR
validate_input "$THEME_AUTHOR" "Theme Author"

read -p "Author URI : " AUTHOR_URI
validate_input "$AUTHOR_URI" "Author URI"

read -p "Theme Description: " THEME_DESCRIPTION
validate_input "$THEME_DESCRIPTION" "Theme Description"

read -p "Theme URI: " THEME_URI
validate_input "$THEME_URI" "Theme URI"

# Get font information
read -p "Primary Font (Google Font name, e.g., 'Geologica'): " PRIMARY_FONT
validate_input "$PRIMARY_FONT" "Primary Font"

read -p "Secondary Font (Google Font name, e.g., 'Asap Condensed'): " SECONDARY_FONT
validate_input "$SECONDARY_FONT" "Secondary Font"

# Get color information
read -p "Primary Color (hex, e.g., '#007bff'): " PRIMARY_COLOR
validate_input "$PRIMARY_COLOR" "Primary Color"
validate_color "$PRIMARY_COLOR" "Primary Color"

read -p "Secondary Color (hex, e.g., '#6c757d'): " SECONDARY_COLOR
validate_input "$SECONDARY_COLOR" "Secondary Color"
validate_color "$SECONDARY_COLOR" "Secondary Color"

# Get width information
read -p "Outer Width (e.g., '1600px'): " OUTER_WIDTH
validate_input "$OUTER_WIDTH" "Outer Width"

read -p "Inner Width (e.g., '1200px'): " INNER_WIDTH
validate_input "$INNER_WIDTH" "Inner Width"

# Get pages to create (comma-separated)
read -p "Pages to create (comma-separated, e.g., 'Home, About, Contact'): " PAGES_INPUT
IFS=',' read -ra PAGES <<< "$PAGES_INPUT"
PAGES=("${PAGES[@]/#/$(echo -e '\n')}")  # Trim whitespace from each element

# Generate theme slug from theme name
THEME_SLUG=$(slugify "$THEME_NAME")

# Confirm the values
echo -e "\nPlease confirm these values:"
echo "Theme Name: $THEME_NAME"
echo "Theme Author: $THEME_AUTHOR"
echo "Author URI: $AUTHOR_URI"
echo "Theme Description: $THEME_DESCRIPTION"
echo "Theme URI: $THEME_URI"
echo "Theme Slug: $THEME_SLUG"
echo "Primary Font: $PRIMARY_FONT"
echo "Secondary Font: $SECONDARY_FONT"
echo "Primary Color: $PRIMARY_COLOR"
echo "Secondary Color: $SECONDARY_COLOR"
echo "Outer Width: ${OUTER_WIDTH}"
echo "Inner Width: ${INNER_WIDTH}"
echo "Pages to create:"
printf '%s\n' "${PAGES[@]}" | sed 's/^[[:space:]]*//'

read -p "Continue? (y/n) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    echo "Setup cancelled"
    exit 1
fi

# Update style.css
if [ -f "style.css" ]; then
    echo "Processing style.css..."
    sed -i "s/Theme Name: .*/Theme Name: ${THEME_NAME}/g" style.css
    sed -i "s|Theme URI: .*|Theme URI: ${THEME_URI}|g" style.css
    sed -i "s/Description: .*/Description: ${THEME_DESCRIPTION}/g" style.css
    sed -i "s/Author: .*/Author: ${THEME_AUTHOR}/g" style.css
    sed -i "s|Author URI: .*|Author URI: ${AUTHOR_URI}|g" style.css
    sed -i "s/Text Domain: .*/Text Domain: ${THEME_SLUG}/g" style.css
fi

# Update package.json
if [ -f "package.json" ]; then
    echo "Processing package.json..."
    sed -i "s|\"name\": \".*\"|\"name\": \"${THEME_SLUG}\"|g" package.json
    sed -i "s|\"description\": \".*\"|\"description\": \"${THEME_DESCRIPTION}\"|g" package.json
fi

# Update functions.php
if [ -f "functions.php" ]; then
    echo "Processing functions.php..."
    sed -i "s/THEME_SLUG/${THEME_SLUG}/g" functions.php
    sed -i "s/THEME_NAME/${THEME_NAME}/g" functions.php
    sed -i "s/PRIMARY_FONT/${PRIMARY_FONT}/g" functions.php
    sed -i "s/SECONDARY_FONT/${SECONDARY_FONT}/g" functions.php
fi

# Update typography.scss
if [ -f "assets/sass/abstracts/_typography.scss" ]; then
    echo "Processing _typography.scss..."
    sed -i "s/PRIMARY_FONT/${PRIMARY_FONT}/g" assets/sass/abstracts/_typography.scss
    sed -i "s/SECONDARY_FONT/${SECONDARY_FONT}/g" assets/sass/abstracts/_typography.scss
fi

# Update colors.scss
if [ -f "assets/sass/abstracts/_colors.scss" ]; then
    echo "Processing _colors.scss..."
    sed -i "s/PRIMARY_COLOR/${PRIMARY_COLOR}/g" assets/sass/abstracts/_colors.scss
    sed -i "s/SECONDARY_COLOR/${SECONDARY_COLOR}/g" assets/sass/abstracts/_colors.scss
fi

# Update sizes.scss
if [ -f "assets/sass/abstracts/_sizes.scss" ]; then
    echo "Processing _sizes.scss..."
    sed -i "s/OUTER_WIDTH/${OUTER_WIDTH}/g" assets/sass/abstracts/_sizes.scss
    sed -i "s/INNER_WIDTH/${INNER_WIDTH}/g" assets/sass/abstracts/_sizes.scss
fi

# Create WordPress pages
if [ ${#PAGES[@]} -gt 0 ]; then
    echo -e "\nCreating WordPress pages..."
    for page in "${PAGES[@]}"; do
        # Trim whitespace
        page=$(echo "$page" | sed -e 's/^[[:space:]]*//' -e 's/[[:space:]]*$//')
        if [ ! -z "$page" ]; then
            wp post create --post_type=page --post_status=publish --post_title="$page"
            if [ $? -eq 0 ]; then
                echo "Created page: $page"
            else
                echo "Failed to create page: $page"
            fi
        fi
    done
fi

# Make scripts executable
echo "Making scripts executable..."
chmod +x start.sh reset.sh

# Run npm install
echo "Running npm install..."
npm install

echo -e "\nSetup completed successfully!"
echo "You can now start development with: ./start.sh"