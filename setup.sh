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
        echo "Warning: $field is empty"
        return 1
    fi
    return 0
}

# Function to validate hex color
validate_color() {
    local color=$1
    local field=$2
    if [ -z "$color" ]; then
        echo "Warning: $field is empty"
        return 1
    elif [[ ! $color =~ ^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$ ]]; then
        echo "Error: $field must be a valid hex color (e.g., #ff0000)"
        exit 1
    fi
}

# Get theme information
read -p "Theme Name (e.g., 'My Theme'): " THEME_NAME
if ! validate_input "$THEME_NAME" "Theme Name"; then
    echo "Theme Name is required"
    exit 1
fi

read -p "Theme Author (e.g., 'John Doe'): " THEME_AUTHOR
read -p "Author URI: " AUTHOR_URI
read -p "Theme Description: " THEME_DESCRIPTION
read -p "Theme URI: " THEME_URI

# Get font information
read -p "Primary Font (Google Font name, e.g., 'Geologica'): " PRIMARY_FONT
read -p "Secondary Font (Google Font name, e.g., 'Asap Condensed'): " SECONDARY_FONT

# Get color information
read -p "Primary Color (hex, e.g., '#007bff'): " PRIMARY_COLOR
if [ ! -z "$PRIMARY_COLOR" ]; then
    validate_color "$PRIMARY_COLOR" "Primary Color"
fi

read -p "Secondary Color (hex, e.g., '#6c757d'): " SECONDARY_COLOR
if [ ! -z "$SECONDARY_COLOR" ]; then
    validate_color "$SECONDARY_COLOR" "Secondary Color"
fi

# Get width information
read -p "Outer Width (e.g., '1600px'): " OUTER_WIDTH
read -p "Inner Width (e.g., '1200px'): " INNER_WIDTH

# Get pages to create (comma-separated)
read -p "Pages to create (comma-separated, e.g., 'Home, About, Contact'): " PAGES_INPUT
if [ ! -z "$PAGES_INPUT" ]; then
    IFS=',' read -ra PAGES <<< "$PAGES_INPUT"
    PAGES=("${PAGES[@]/#/$(echo -e '\n')}")  # Trim whitespace from each element
fi

# Generate theme slug from theme name
THEME_SLUG=$(slugify "$THEME_NAME")

# Confirm the values
echo -e "\nPlease confirm these values:"
echo "Theme Name: $THEME_NAME"
echo "Theme Author: ${THEME_AUTHOR:-Not set}"
echo "Author URI: ${AUTHOR_URI:-Not set}"
echo "Theme Description: ${THEME_DESCRIPTION:-Not set}"
echo "Theme URI: ${THEME_URI:-Not set}"
echo "Theme Slug: $THEME_SLUG"
echo "Primary Font: ${PRIMARY_FONT:-Not set}"
echo "Secondary Font: ${SECONDARY_FONT:-Not set}"
echo "Primary Color: ${PRIMARY_COLOR:-Not set}"
echo "Secondary Color: ${SECONDARY_COLOR:-Not set}"
echo "Outer Width: ${OUTER_WIDTH:-Not set}"
echo "Inner Width: ${INNER_WIDTH:-Not set}"
if [ ! -z "$PAGES_INPUT" ]; then
    echo "Pages to create:"
    printf '%s\n' "${PAGES[@]}" | sed 's/^[[:space:]]*//'
else
    echo "Pages to create: None"
fi

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
    [ ! -z "$THEME_URI" ] && sed -i "s|Theme URI: .*|Theme URI: ${THEME_URI}|g" style.css
    [ ! -z "$THEME_DESCRIPTION" ] && sed -i "s/Description: .*/Description: ${THEME_DESCRIPTION}/g" style.css
    [ ! -z "$THEME_AUTHOR" ] && sed -i "s/Author: .*/Author: ${THEME_AUTHOR}/g" style.css
    [ ! -z "$AUTHOR_URI" ] && sed -i "s|Author URI: .*|Author URI: ${AUTHOR_URI}|g" style.css
    sed -i "s/Text Domain: .*/Text Domain: ${THEME_SLUG}/g" style.css
fi

# Update package.json
if [ -f "package.json" ]; then
    echo "Processing package.json..."
    sed -i "s|\"name\": \".*\"|\"name\": \"${THEME_SLUG}\"|g" package.json
    [ ! -z "$THEME_DESCRIPTION" ] && sed -i "s|\"description\": \".*\"|\"description\": \"${THEME_DESCRIPTION}\"|g" package.json
fi

# Update functions.php
if [ -f "functions.php" ]; then
    echo "Processing functions.php..."
    sed -i "s/THEME_SLUG/${THEME_SLUG}/g" functions.php
    sed -i "s/THEME_NAME/${THEME_NAME}/g" functions.php
    [ ! -z "$PRIMARY_FONT" ] && sed -i "s/PRIMARY_FONT/${PRIMARY_FONT}/g" functions.php
    [ ! -z "$SECONDARY_FONT" ] && sed -i "s/SECONDARY_FONT/${SECONDARY_FONT}/g" functions.php
fi

# Update typography.scss
if [ -f "assets/sass/abstracts/_typography.scss" ]; then
    echo "Processing _typography.scss..."
    [ ! -z "$PRIMARY_FONT" ] && sed -i "s/PRIMARY_FONT/${PRIMARY_FONT}/g" assets/sass/abstracts/_typography.scss
    [ ! -z "$SECONDARY_FONT" ] && sed -i "s/SECONDARY_FONT/${SECONDARY_FONT}/g" assets/sass/abstracts/_typography.scss
fi

# Update colors.scss
if [ -f "assets/sass/abstracts/_colors.scss" ]; then
    echo "Processing _colors.scss..."
    [ ! -z "$PRIMARY_COLOR" ] && sed -i "s/PRIMARY_COLOR/${PRIMARY_COLOR}/g" assets/sass/abstracts/_colors.scss
    [ ! -z "$SECONDARY_COLOR" ] && sed -i "s/SECONDARY_COLOR/${SECONDARY_COLOR}/g" assets/sass/abstracts/_colors.scss
fi

# Update sizes.scss
if [ -f "assets/sass/abstracts/_sizes.scss" ]; then
    echo "Processing _sizes.scss..."
    [ ! -z "$OUTER_WIDTH" ] && sed -i "s/OUTER_WIDTH/${OUTER_WIDTH}/g" assets/sass/abstracts/_sizes.scss
    [ ! -z "$INNER_WIDTH" ] && sed -i "s/INNER_WIDTH/${INNER_WIDTH}/g" assets/sass/abstracts/_sizes.scss
fi

# Create WordPress pages
if [ ! -z "$PAGES_INPUT" ] && [ ${#PAGES[@]} -gt 0 ]; then
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