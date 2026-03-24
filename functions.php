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

add_action('after_setup_theme', function() {
    add_theme_support( 'post-thumbnails' );
});

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
 * Enqueue fonts: Adobe Typekit (CoconPro) + Google Fonts (Open Sans)
 */
function c7_enqueue_fonts() {
    wp_enqueue_style('c7-typekit',
        'https://use.typekit.net/ptw5jvq.css',
        array(),
        null
    );
    wp_enqueue_style('c7-fonts',
        'https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'c7_enqueue_fonts');

/**
 * Bilingual support (EN/FR)
 *
 * French pages live under a "fr" parent page, so /fr/slug/ = French.
 * Language detection checks page ancestry. Locale switching loads fr_FR.mo.
 */

function c7_get_lang() {
    static $lang = null;
    if ( $lang !== null ) return $lang;

    if ( ! is_page() ) {
        $lang = 'en';
        return $lang;
    }

    $fr_page = get_page_by_path( 'fr' );
    if ( ! $fr_page ) {
        $lang = 'en';
        return $lang;
    }

    $current_id = get_queried_object_id();
    $lang = ( $current_id === $fr_page->ID || in_array( $fr_page->ID, get_post_ancestors( $current_id ) ) )
        ? 'fr' : 'en';
    return $lang;
}

function c7_slug_map() {
    return array(
        'what-is-c7'          => 'quest-ce-que-le-c7',
        'thematic-priorities'  => 'priorites-thematiques',
        'steering-committee'   => 'comite-directeur',
        'events-calendar'      => 'calendrier-des-evenements',
        'news'                 => 'nouvelles',
        'resources'            => 'ressources',
        'contact'              => 'contact',
    );
}

function c7_page_path( $en_slug ) {
    if ( c7_get_lang() === 'fr' ) {
        $map = c7_slug_map();
        $fr_slug = isset( $map[ $en_slug ] ) ? $map[ $en_slug ] : $en_slug;
        return 'fr/' . $fr_slug;
    }
    return $en_slug;
}

function c7_get_translation_url() {
    if ( ! is_page() ) return home_url( '/' );

    $current = get_queried_object();
    if ( ! $current ) return home_url( '/' );

    $map = c7_slug_map();
    $reverse = array_flip( $map );

    if ( c7_get_lang() === 'fr' ) {
        $fr_page = get_page_by_path( 'fr' );
        if ( $fr_page && $current->ID === $fr_page->ID ) return home_url( '/' );
        $fr_slug = $current->post_name;
        $en_slug = isset( $reverse[ $fr_slug ] ) ? $reverse[ $fr_slug ] : $fr_slug;
        $en_page = get_page_by_path( $en_slug );
        return $en_page ? get_permalink( $en_page ) : home_url( '/' );
    }

    $en_slug = $current->post_name;
    $fr_slug = isset( $map[ $en_slug ] ) ? $map[ $en_slug ] : $en_slug;
    $fr_page = get_page_by_path( 'fr/' . $fr_slug );
    return $fr_page ? get_permalink( $fr_page ) : home_url( '/fr/' );
}

function c7_switch_locale() {
    if ( c7_get_lang() === 'fr' ) {
        switch_to_locale( 'fr_FR' );
    }
}
add_action( 'template_redirect', 'c7_switch_locale' );

function c7_french_page_template( $template ) {
    if ( ! is_page() || c7_get_lang() !== 'fr' ) return $template;

    $slug = get_queried_object()->post_name;
    $reverse = array_flip( c7_slug_map() );
    if ( isset( $reverse[ $slug ] ) ) {
        $en_template = get_stylesheet_directory() . '/page-' . $reverse[ $slug ] . '.php';
        if ( file_exists( $en_template ) ) return $en_template;
    }
    return $template;
}
add_filter( 'template_include', 'c7_french_page_template' );

function c7_body_class_lang( $classes ) {
    $classes[] = 'lang-' . c7_get_lang();
    return $classes;
}
add_filter( 'body_class', 'c7_body_class_lang' );