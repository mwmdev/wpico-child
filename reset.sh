#!/bin/bash

# Default values
DEFAULT_THEME_NAME="THEME_NAME"
DEFAULT_THEME_SLUG="THEME_SLUG"
DEFAULT_AUTHOR="Author: "
DEFAULT_AUTHOR_URI="Author URI: "
DEFAULT_DESCRIPTION="A child theme of wpico"
DEFAULT_PRIMARY_FONT="Geologica"
DEFAULT_SECONDARY_FONT="Asap Condensed"
DEFAULT_OUTER_WIDTH="1600"
DEFAULT_INNER_WIDTH="1455"

echo "This will reset all customized values to their defaults."
read -p "Continue? (y/n) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    echo "Reset cancelled"
    exit 1
fi

# Reset theme information in all files
find . -type f -not -path "./.git/*" -not -name "reset.sh" -exec sed -i "s/[A-Za-z0-9 -]\+Theme/${DEFAULT_THEME_NAME}/g" {} +
find . -type f -not -path "./.git/*" -not -name "reset.sh" -exec sed -i "s/[a-z0-9-]\+-scripts/${DEFAULT_THEME_SLUG}-scripts/g" {} +
find . -type f -not -path "./.git/*" -not -name "reset.sh" -exec sed -i "s/[a-z0-9-]\+-fonts/${DEFAULT_THEME_SLUG}-fonts/g" {} +
find . -type f -not -path "./.git/*" -not -name "reset.sh" -exec sed -i "s/[a-z0-9-]\+_enqueue/${DEFAULT_THEME_SLUG}_enqueue/g" {} +

# Reset style.css
if [ -f "style.css" ]; then
    sed -i "s/Author: .*/Author: /g" style.css
    sed -i "s|Author URI: .*|Author URI: |g" style.css
    sed -i "s/Text Domain: .*/Text Domain: ${DEFAULT_THEME_SLUG}/g" style.css
fi

# Reset package.json
if [ -f "package.json" ]; then
    sed -i "s|\"name\": \".*\"|\"name\": \"${DEFAULT_THEME_SLUG}\"|g" package.json
    sed -i "s|\"description\": \".*\"|\"description\": \"${DEFAULT_DESCRIPTION}\"|g" package.json
fi

# Reset typography.scss with default fonts
if [ -f "assets/sass/abstracts/_typography.scss" ]; then
    sed -i "s/\$main-font: \"[^\"]*\"/\$main-font: \"${DEFAULT_PRIMARY_FONT}\"/g" assets/sass/abstracts/_typography.scss
    sed -i "s/\$secondary-font: \"[^\"]*\"/\$secondary-font: \"${DEFAULT_SECONDARY_FONT}\"/g" assets/sass/abstracts/_typography.scss
fi

# Reset functions.php Google Fonts
if [ -f "functions.php" ]; then
    sed -i "s|family=[^&]*&family=[^&]*|family=${DEFAULT_PRIMARY_FONT}&family=${DEFAULT_SECONDARY_FONT}|g" functions.php
fi

# Reset sizes.scss with default widths
if [ -f "assets/sass/abstracts/_sizes.scss" ]; then
    sed -i "s/\$outer-width: [0-9]\+px/\$outer-width: ${DEFAULT_OUTER_WIDTH}px/g" assets/sass/abstracts/_sizes.scss
    sed -i "s/\$inner-width: [0-9]\+px/\$inner-width: ${DEFAULT_INNER_WIDTH}px/g" assets/sass/abstracts/_sizes.scss
fi

echo -e "\nReset completed successfully!"
echo "All values have been restored to their defaults." 