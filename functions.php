<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue parent style and child style
 */
function THEME_SLUG_enqueue_styles() {
    THEME_SLUG_enqueue_style('THEME_SLUG-styles',
        get_stylesheet_directory_uri() . '/assets/css/style.min.css',
        array('THEME_SLUG-styles'),
        filemtime(get_stylesheet_directory() . '/assets/css/style.min.css')
    );
    
    THEME_SLUG_enqueue_script('THEME_SLUG-scripts',
        get_stylesheet_directory_uri() . '/assets/js/scripts.min.js',
        array('jquery'),
        filemtime(get_stylesheet_directory() . '/assets/js/scripts.min.js'),
        true
    );
}
add_action('THEME_SLUG_enqueue_scripts', 'THEME_SLUG_enqueue_styles'); 

/**
 * Add preconnect for Google Fonts.
 */
function THEME_SLUG_preconnect_google_fonts() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
}
add_action('wp_head', 'THEME_SLUG_preconnect_google_fonts', 7);

/**
 * Enqueue Google Fonts
 */
function THEME_SLUG_enqueue_fonts() {
    THEME_SLUG_enqueue_style('THEME_SLUG-fonts', 
        'https://fonts.googleapis.com/css2?family=PRIMARY_FONT&family=SECONDARY_FONT',
        array(), 
        null
    );
}
add_action('THEME_SLUG_enqueue_scripts', 'THEME_SLUG_enqueue_fonts');