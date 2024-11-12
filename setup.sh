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
read -p "Theme Name: " THEME_NAME
validate_input "$THEME_NAME" "Theme Name"

read -p "Theme Author: " THEME_AUTHOR
validate_input "$THEME_AUTHOR" "Theme Author"

read -p "Author URI (optional): " AUTHOR_URI
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
read -p "Outer Width (in pixels, e.g., '1600'): " OUTER_WIDTH
validate_input "$OUTER_WIDTH" "Outer Width"

read -p "Inner Width (in pixels, e.g., '1455'): " INNER_WIDTH
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
echo "Theme Slug: $THEME_SLUG"
echo "Theme Description: $THEME_DESCRIPTION"
echo "Theme URI: $THEME_URI"
echo "Theme Author: $THEME_AUTHOR"
echo "Author URI: $AUTHOR_URI"
echo "Primary Font: $PRIMARY_FONT"
echo "Secondary Font: $SECONDARY_FONT"
echo "Primary Color: $PRIMARY_COLOR"
echo "Secondary Color: $SECONDARY_COLOR"
echo "Outer Width: ${OUTER_WIDTH}px"
echo "Inner Width: ${INNER_WIDTH}px"
echo "Pages to create:"
printf '%s\n' "${PAGES[@]}" | sed 's/^[[:space:]]*//'

read -p "Continue? (y/n) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    echo "Setup cancelled"
    exit 1
fi

# Replace placeholders in all files except setup.sh and reset.sh
find . -type f -not -path "./.git/*" -not -name "setup.sh" -not -name "reset.sh" -exec sed -i "s/THEME_NAME/${THEME_NAME}/g" {} +
find . -type f -not -path "./.git/*" -not -name "setup.sh" -not -name "reset.sh" -exec sed -i "s/THEME_SLUG/${THEME_SLUG}/g" {} +
find . -type f -not -path "./.git/*" -not -name "setup.sh" -not -name "reset.sh" -exec sed -i "s/THEME_DESCRIPTION/${THEME_DESCRIPTION}/g" {} +
find . -type f -not -path "./.git/*" -not -name "setup.sh" -not -name "reset.sh" -exec sed -i "s/THEME_AUTHOR/${THEME_AUTHOR}/g" {} +
find . -type f -not -path "./.git/*" -not -name "setup.sh" -not -name "reset.sh" -exec sed -i "s/AUTHOR_URI/${AUTHOR_URI}/g" {} +
find . -type f -not -path "./.git/*" -not -name "setup.sh" -not -name "reset.sh" -exec sed -i "s/THEME_URI/${THEME_URI}/g" {} +
find . -type f -not -path "./.git/*" -not -name "setup.sh" -not -name "reset.sh" -exec sed -i "s/PRIMARY_FONT/${PRIMARY_FONT}/g" {} +
find . -type f -not -path "./.git/*" -not -name "setup.sh" -not -name "reset.sh" -exec sed -i "s/SECONDARY_FONT/${SECONDARY_FONT}/g" {} +
find . -type f -not -path "./.git/*" -not -name "setup.sh" -not -name "reset.sh" -exec sed -i "s/PRIMARY_COLOR/${PRIMARY_COLOR}/g" {} +
find . -type f -not -path "./.git/*" -not -name "setup.sh" -not -name "reset.sh" -exec sed -i "s/SECONDARY_COLOR/${SECONDARY_COLOR}/g" {} +
find . -type f -not -path "./.git/*" -not -name "setup.sh" -not -name "reset.sh" -exec sed -i "s/OUTER_WIDTH/${OUTER_WIDTH}/g" {} +
find . -type f -not -path "./.git/*" -not -name "setup.sh" -not -name "reset.sh" -exec sed -i "s/INNER_WIDTH/${INNER_WIDTH}/g" {} +

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
chmod +x start.sh reset.sh

echo -e "\nSetup completed successfully!"
echo "You can now start development with: ./start.sh"