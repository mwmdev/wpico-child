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


/* Display videos by series */
add_filter('the_content', 'display_videos');
function display_videos($content) {
    $afficher_videos = get_field('afficher_videos');
    if ($afficher_videos) {
        $args = array(
            'post_type' => 'video',
            'tax_query' => array(
                array(
                    'taxonomy' => 'thematique',
                    'field' => 'term_id',
                    'terms' => $afficher_videos,
                ),
            ),
        );
        $videos = new WP_Query($args);
        if ($videos->have_posts()) {
            $series = array();
            while ($videos->have_posts()) {
                $videos->the_post();
                $serie = get_field('serie');
                if (!in_array($serie->term_id, $series)) {
                    $series[] = $serie->term_id;
                }
            }   
            foreach ($series as $serie_id) {
                $serie_name = get_term($serie_id)->name;
                error_log($serie_name);
                $content .= '<h2>' . $serie_name . '</h2>';
                $content .= '<section class="list">';
                while ($videos->have_posts()) {
                    $videos->the_post();
                    $serie = get_field('serie');
                    if ($serie->term_id == $serie_id) {
                        $video = get_field('video');
                        $video_url = $video['url'];
                        $extract = get_field('extrait');
                        $tags = get_field('mots_cles');
                        $content .= '<article>';
                        $content .= '<video src="' . $video_url . '" controls></video>';
                        $content .= '<header>';
                        $content .= '<h3>' . get_the_title() . '</h3>';
                        $content .= '</header>';
                        $content .= '<p>' . $extract . '</p>';
                        $content .= '<footer>';
                        if ($tags) {
                            $content .= '<div class="tags">' . $tags . '</div>';
                        }
                        $content .= '</footer>';
                        $content .= '</article>';

                    }
                }
                $content .= '</section>';
            }
        } else {
            $content .= '<p>Aucune vidéo trouvée</p>';
        }
        wp_reset_postdata();
    }
    return $content;
}

/* Display ressources */
add_filter('the_content', 'display_ressources');
function display_ressources($content) {
    $afficher_ressources = get_field('afficher_videos');
    if ($afficher_ressources) {
        error_log(print_r($afficher_ressources, true));
        $content .= '<h2>Ressources</h2>';
        $args = array(
            'post_type' => 'ressource',
            'tax_query' => array(
                array(
                    'taxonomy' => 'thematique',
                    'field' => 'term_id',
                    'terms' => $afficher_ressources,
                ),
            ),
        );
        $ressources = new WP_Query($args);
        if ($ressources->have_posts()) {
            $content .= '<section class="list ressources">';
            while ($ressources->have_posts()) {
                $ressources->the_post();
                $fichiers = get_field('fichiers');
                if ($fichiers) {
                    $fichier = $fichiers[0]['fichier'];
                    $cover_image = get_post_thumbnail_id($fichier['ID']);
                }
                $content .= '<article>';
                $content .= '<header>';
                $content .= '<img src="' . $cover_image . '" alt="Cover image">';
                $content .= '<h3>' . get_the_title() . '</h3>';
                $content .= '</header>';
                $content .= '<footer>';
                /* Authors */
                $authors = get_field('auteurs');
                if ($authors) {
                    $content .= '<div class="authors">' . $authors . '</div>';
                }
                /* Year, Place and pages */
                $year = get_field('date');
                $place = get_field('lieu_publication');
                $pages = get_field('nb_pages');
                if ($year || $place || $pages) {
                    $content .= '<p>' . $year . ' - ' . $place . ' - ' . $pages . ' pages</p>';
                }
                /* Tags */
                $tags = get_field('mots_cles');
                if ($tags) {
                    $content .= '<div class="tags">';
                    foreach ($tags as $tag) {
                        $content .= '<span class="tag">#' . $tag -> name . '</span>';
                    }
                    $content .= '</div>';
                }
                $content .= '</footer>';
                $content .= '</article>';
            }
            $content .= '</section>';
        } else {
            $content .= '<p>Aucune ressource trouvée</p>';
        }
        wp_reset_postdata();
    }
    return $content;
}   


/* On admin post list ressource, add a column "thematique",  before the date */
add_filter('manage_video_posts_columns', 'add_thematique_column');
add_filter('manage_ressource_posts_columns', 'add_thematique_column');
function add_thematique_column($columns) {
    $columns = array_slice($columns, 0, 2) + array('thematique' => 'Thématique') + array_slice($columns, 2);
    return $columns;
}

add_action('manage_video_posts_custom_column', 'display_thematique_column', 10, 2);
add_action('manage_ressource_posts_custom_column', 'display_thematique_column', 10, 2);
function display_thematique_column($column, $post_id) {
    if ($column == 'thematique') {
        echo get_the_term_list($post_id, 'thematique', '', ', ');
    }
}


/* Add content to the page with slug "reperes-chronologiques" , using the the_content filter */
add_filter('the_content', 'add_content_to_reperes_chronologiques');
function add_content_to_reperes_chronologiques($content) {
    if (is_page('reperes-chronologiques')) {
        $args = array(
            'post_type' => 'etape',
            'posts_per_page' => -1,
        );  
        $etapes = new WP_Query($args);
        if ($etapes->have_posts()) {
            $content .= '<section class="timeline-container">';
            while ($etapes->have_posts()) {
                $etapes->the_post();
                $year = get_field('annee');
                $type = get_field('type');
                if ( $type == 'national') {
                    $type = 'left';
                } else if ( $type == 'vallee') {
                    $type = 'right';
                }
                $content .= '<article class="' . $type . '">';
                $content .= '<h3><strong>' . $year . '</strong> ' . get_the_title() . '</h3>';
                $content .= '<p>' . get_the_content() . '</p>';
                $content .= '</article>';
            }
            $content .= '</section>';
        }
    }
    return $content;
}