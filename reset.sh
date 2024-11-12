#!/bin/bash

# Default values
DEFAULT_THEME_NAME="THEME_NAME"
DEFAULT_THEME_SLUG="THEME_SLUG"
DEFAULT_THEME_DESCRIPTION="THEME_DESCRIPTION"
DEFAULT_THEME_URI="THEME_URI"
DEFAULT_THEME_AUTHOR="THEME_AUTHOR"
DEFAULT_AUTHOR_URI="AUTHOR_URI"
DEFAULT_PRIMARY_FONT="PRIMARY_FONT"
DEFAULT_SECONDARY_FONT="SECONDARY_FONT"
DEFAULT_PRIMARY_COLOR="PRIMARY_COLOR"
DEFAULT_SECONDARY_COLOR="SECONDARY_COLOR"
DEFAULT_OUTER_WIDTH="OUTER_WIDTH"
DEFAULT_INNER_WIDTH="INNER_WIDTH"

echo "This will reset all customized values to their defaults."
read -p "Continue? (y/n) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    echo "Reset cancelled"
    exit 1
fi

# Reset style.css
if [ -f "style.css" ]; then
    sed -i "s/Theme Name: .*/Theme Name: ${DEFAULT_THEME_NAME}/g" style.css
    sed -i "s/Theme URI: .*/Theme URI: ${DEFAULT_THEME_URI}/g" style.css
    sed -i "s/Description: .*/Description: ${DEFAULT_THEME_DESCRIPTION}/g" style.css
    sed -i "s/Author: .*/Author: ${DEFAULT_THEME_AUTHOR}/g" style.css
    sed -i "s|Author URI: .*|Author URI: ${DEFAULT_AUTHOR_URI}|g" style.css
    sed -i "s/Text Domain: .*/Text Domain: ${DEFAULT_THEME_SLUG}/g" style.css
fi

# Reset package.json
if [ -f "package.json" ]; then
    sed -i "s|\"name\": \".*\"|\"name\": \"${DEFAULT_THEME_SLUG}\"|g" package.json
    sed -i "s|\"description\": \".*\"|\"description\": \"${DEFAULT_THEME_DESCRIPTION}\"|g" package.json
fi

# Reset functions.php
if [ -f "functions.php" ]; then
    sed -i "s/[a-zA-Z0-9_-]\+_enqueue_style/${DEFAULT_THEME_SLUG}_enqueue_style/g" functions.php
    sed -i "s/[a-zA-Z0-9_-]\+_enqueue_styles/${DEFAULT_THEME_SLUG}_enqueue_styles/g" functions.php
    sed -i "s/[a-zA-Z0-9_-]\+-styles/${DEFAULT_THEME_SLUG}-styles/g" functions.php
    sed -i "s/[a-zA-Z0-9_-]\+_enqueue_script/${DEFAULT_THEME_SLUG}_enqueue_script/g" functions.php
    sed -i "s/[a-zA-Z0-9_-]\+_enqueue_scripts/${DEFAULT_THEME_SLUG}_enqueue_scripts/g" functions.php
    sed -i "s/[a-zA-Z0-9_-]\+-scripts/${DEFAULT_THEME_SLUG}-scripts/g" functions.php
    sed -i "s/[a-zA-Z0-9_-]\+_enqueue_fonts/${DEFAULT_THEME_SLUG}_enqueue_fonts/g" functions.php
    sed -i "s/[a-zA-Z0-9_-]\+_preconnect_google_fonts/${DEFAULT_THEME_SLUG}_preconnect_google_fonts/g" functions.php
    sed -i "s/[a-zA-Z0-9_-]\+-fonts/${DEFAULT_THEME_SLUG}-fonts/g" functions.php
    sed -i "s|https://fonts.googleapis.com/css2?family=.*&display=swap|https://fonts.googleapis.com/css2?family=${DEFAULT_PRIMARY_FONT}&family=${DEFAULT_SECONDARY_FONT}&display=swap|g" functions.php

fi

# Reset typography.scss
if [ -f "assets/sass/abstracts/_typography.scss" ]; then
    sed -i "s/\"[^\"]*\", sans-serif/\"${DEFAULT_PRIMARY_FONT}\", sans-serif/g" assets/sass/abstracts/_typography.scss
    sed -i "s/\"[^\"]*\", serif/\"${DEFAULT_SECONDARY_FONT}\", serif/g" assets/sass/abstracts/_typography.scss
fi

# Reset colors.scss
if [ -f "assets/sass/abstracts/_colors.scss" ]; then
    sed -i "s/\$primary-color: #[0-9A-Fa-f]\{3,6\}/\$primary-color: ${DEFAULT_PRIMARY_COLOR}/g" assets/sass/abstracts/_colors.scss
    sed -i "s/\$secondary-color: #[0-9A-Fa-f]\{3,6\}/\$secondary-color: ${DEFAULT_SECONDARY_COLOR}/g" assets/sass/abstracts/_colors.scss
fi

# Reset sizes.scss
if [ -f "assets/sass/abstracts/_sizes.scss" ]; then
    sed -i "s/\$outer-width: [0-9]\+/\$outer-width: ${DEFAULT_OUTER_WIDTH}/g" assets/sass/abstracts/_sizes.scss
    sed -i "s/\$inner-width: [0-9]\+/\$inner-width: ${DEFAULT_INNER_WIDTH}/g" assets/sass/abstracts/_sizes.scss
fi

echo -e "\nReset completed successfully!"
echo "All values have been restored to their defaults."