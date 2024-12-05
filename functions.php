<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue parent style and child style
 */
function vfs_enqueue_styles() {
    
    wp_enqueue_style('vfs-styles',
        get_stylesheet_directory_uri() . '/assets/css/style.min.css',
        array('pico'),  // Add parent-style as dependency
        filemtime(get_stylesheet_directory() . '/assets/css/style.min.css')
    );
    
    wp_enqueue_script('vfs-scripts',
        get_stylesheet_directory_uri() . '/assets/js/scripts.min.js',
        array('jquery'),
        filemtime(get_stylesheet_directory() . '/assets/js/scripts.min.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'vfs_enqueue_styles'); 

/**
 * Add preconnect for Google Fonts.
 */
function vfs_preconnect_google_fonts() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
}
add_action('wp_head', 'vfs_preconnect_google_fonts', 7);

/**
 * Enqueue Google Fonts
 */
function vfs_enqueue_fonts() {
    wp_enqueue_style('vfs-fonts', 
        'https://fonts.googleapis.com/css2?family=Montserrat&family=Raleway&display=swap',
        array(), 
        null
    );
}
add_action('wp_enqueue_scripts', 'vfs_enqueue_fonts');