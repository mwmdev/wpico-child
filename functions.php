<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load theme textdomain for translations
 */
function wpico_child_load_textdomain() {
    load_theme_textdomain('wpico-child', get_stylesheet_directory() . '/languages');
}
add_action('after_setup_theme', 'wpico_child_load_textdomain');

/**
 * Enqueue parent style and child style
 */
function wpico_enqueue_styles() {

    wp_enqueue_style('wpico-styles',
        get_stylesheet_directory_uri() . '/assets/css/style.min.css',
        array('pico'),  // Add parent-style as dependency
        filemtime(get_stylesheet_directory() . '/assets/css/style.min.css')
    );

    wp_enqueue_script('wpico-scripts',
        get_stylesheet_directory_uri() . '/assets/js/scripts.min.js',
        array('jquery'),
        filemtime(get_stylesheet_directory() . '/assets/js/scripts.min.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'wpico_enqueue_styles'); 

/**
 * Add preconnect for Google Fonts.
 */
function wpico_preconnect_google_fonts() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
}
add_action('wp_head', 'wpico_preconnect_google_fonts', 7);

/**
 * Enqueue Google Fonts
 */
function wpico_enqueue_fonts() {
    wp_enqueue_style('wpico-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat&family=Raleway&display=swap',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'wpico_enqueue_fonts');