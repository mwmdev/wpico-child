<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load theme textdomain for translations
 */
function c7_load_textdomain() {
    load_theme_textdomain('c7', get_stylesheet_directory() . '/languages');
}
add_action('after_setup_theme', 'c7_load_textdomain');

/**
 * Enqueue parent style and child style
 */
function c7_enqueue_styles() {

    wp_enqueue_style('c7-styles',
        get_stylesheet_directory_uri() . '/assets/css/style.min.css',
        array('pico'),  // Add parent-style as dependency
        filemtime(get_stylesheet_directory() . '/assets/css/style.min.css')
    );

    wp_enqueue_script('c7-scripts',
        get_stylesheet_directory_uri() . '/assets/js/scripts.min.js',
        array('jquery'),
        filemtime(get_stylesheet_directory() . '/assets/js/scripts.min.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'c7_enqueue_styles'); 

/**
 * Add preconnect for Google Fonts.
 */
function c7_preconnect_google_fonts() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
}
add_action('wp_head', 'c7_preconnect_google_fonts', 7);

/**
 * Enqueue Google Fonts
 */
function c7_enqueue_fonts() {
    wp_enqueue_style('c7-fonts',
        'https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'c7_enqueue_fonts');