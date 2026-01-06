# WordPress Child Theme Generator

A powerful WordPress child theme generator based on the [wpico theme](https://github.com/mwmdev/wpico), featuring SASS processing, JavaScript bundling, live reload capabilities, and automated setup.

## Features

- SASS/SCSS compilation with source maps
- JavaScript minification and bundling
- Live reload for PHP, CSS, and JavaScript changes
- Google Fonts integration
- Fluid typography and spacing
- Modular SASS architecture
- Automated theme setup and configuration
- WordPress page creation automation
- Development environment with Nix

## Prerequisites

- Node.js and npm
- WordPress installation with [wpico theme](https://github.com/mwmdev/wpico)
- Nix package manager (optional but recommended)

## Quick Start

1. Clone this repository into your WordPress themes directory:
   ```bash
   cd wp-content/themes/
   git clone https://github.com/mwmdev/wpico-child.git
   ```

2. Run the setup script:
   ```bash
   ./setup.sh
   ```
   The script will prompt for:
   - Theme Name
   - Theme Author
   - Theme Description
   - Author URI
   - Theme URI
   - Primary Font (Google Font)
   - Secondary Font (Google Font)
   - Primary Color (hex)
   - Secondary Color (hex)
   - Outer Width (pixels)
   - Inner Width (pixels)
   - Pages to create (comma-separated)

3. Start development:
   ```bash
   ./start.sh
   ```

## Directory Structure

```
theme-name/
├── assets/
│   ├── css/
│   │   └── style.min.css (generated)
│   ├── js/
│   │   ├── src/
│   │   │   └── scripts.js
│   │   └── scripts.min.js (generated)
│   └── sass/
│       ├── abstracts/
│       │   ├── _colors.scss
│       │   ├── _icons.scss
│       │   ├── _sizes.scss
│       │   └── _typography.scss
│       ├── components/
│       │   ├── _buttons.scss
│       │   ├── _list.scss
│       │   ├── _navigation.scss
│       │   └── _search.scss
│       ├── layout/
│       │   ├── _footer.scss
│       │   ├── _header.scss
│       │   └── _main.scss
│       └── style.scss
├── inc/
├── functions.php
├── style.css
├── gulpfile.js
├── package.json
├── shell.nix
├── setup.sh
├── start.sh
└── reset.sh
```

## Development Scripts

- `setup.sh`: Initial theme configuration
- `start.sh`: Starts WordPress server and development environment
- `reset.sh`: Resets theme to default values
- `npm start`: Starts Gulp tasks only
- `npm run build`: Builds production assets

## SASS Structure

- **abstracts/**: Variables, mixins, and utility functions
  - `_colors.scss`: Color variables and palette
  - `_icons.scss`: SVG icons as data URLs
  - `_sizes.scss`: Spacing, breakpoints, and fluid typography
  - `_typography.scss`: Font settings and text utilities

- **components/**: Reusable UI components
  - `_buttons.scss`: Button styles
  - `_list.scss`: List and grid layouts
  - `_navigation.scss`: Navigation menus
  - `_search.scss`: Search form and results

- **layout/**: Major layout sections
  - `_footer.scss`: Footer styles
  - `_header.scss`: Header styles
  - `_main.scss`: Main content area styles

## Development Environment

Using Nix provides a consistent development environment with:
- Node.js 20
- npm
- Gulp CLI
- PHP 8.2
- Composer
- WP-CLI

## Available Commands

- `wp`: WordPress CLI
- `gulp`: Task runner
- `npm`: Package manager
- `composer`: PHP package manager

## Customization

1. Colors: Edit `assets/sass/abstracts/_colors.scss`
2. Typography: Edit `assets/sass/abstracts/_typography.scss`
3. Layout: Edit `assets/sass/abstracts/_sizes.scss`
4. Components: Add new files in `assets/sass/components/`

## License

MIT License - see LICENSE file for details