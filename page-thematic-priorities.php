<?php get_header(); ?>

<?php
$img = get_stylesheet_directory_uri() . '/assets/img';
$pdf = get_stylesheet_directory_uri() . '/assets/pdf';

$groups = array(
    array(
        'id'    => 'multilateralism',
        'icon'  => 'peace.svg',
        'photo' => 'alexey-komissarov-5ouvabiz9uc-unsplash.jpg',
    ),
    array(
        'id'    => 'civic-space',
        'icon'  => 'espace-civique.svg',
        'photo' => 'sunguk-kim-jhqbxsoruxa-unsplash.jpg',
    ),
    array(
        'id'    => 'development-cooperation',
        'icon'  => 'financement.svg',
        'photo' => 'shelby-murphy-figueroa-lechhhlxywu-unsplash.jpg',
    ),
    array(
        'id'    => 'economic-justice',
        'icon'  => 'justice-economique.svg',
        'photo' => 'kane-reinholdtsen-letdkk7whqk-unsplash.jpg',
    ),
    array(
        'id'    => 'gender-equality',
        'icon'  => 'gender.svg',
        'photo' => 'nicole-logan-5yiqn5wzl5k-unsplash.jpg',
    ),
    array(
        'id'    => 'humanitarian-aid',
        'icon'  => 'enjeux-humanitaires.svg',
        'photo' => 'noah-buscher-x8zstuks2pm-unsplash.jpg',
    ),
    array(
        'id'    => 'climate-environment',
        'icon'  => 'climat.svg',
        'photo' => '2ni-f1ojcxolj8q-unsplash.jpg',
    ),
    array(
        'id'    => 'health',
        'icon'  => 'sante.svg',
        'photo' => 'mountain.jpg',
    ),
);
?>

<main class="page-inner">
    <?php while ( have_posts() ) : the_post(); ?>

    <?php $hero_img = get_the_post_thumbnail_url( null, 'full' ) ?: get_stylesheet_directory_uri() . '/assets/img/bandeau-thematiques.png'; ?>
    <section class="page-hero">
        <div class="page-hero__overlay" style="background-image:url(<?php echo esc_url( $hero_img ); ?>)"></div>
        <svg class="page-hero__shape" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 843 684" fill="none" preserveAspectRatio="none">
            <path d="M0 248.425V684H330.588C585.325 489.116 757.645 251.98 842.03 0H180.004C136 87.5834 75.8202 171.278 0 248.425Z" fill="url(#pageHeroGrad)" fill-opacity="0.75" style="mix-blend-mode:multiply"/>
            <path d="M0 248.425V684H330.588C585.325 489.116 757.645 251.98 842.03 0H180.004C136 87.5834 75.8202 171.278 0 248.425Z" fill="#19199F" fill-opacity="0.25" style="mix-blend-mode:overlay"/>
            <defs>
                <linearGradient id="pageHeroGrad" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#5555B5"/>
                    <stop offset="1" stop-color="#FF9E1B"/>
                </linearGradient>
            </defs>
        </svg>
        <h1><?php the_title(); ?></h1>
        <div class="page-hero__blur"></div>
    </section>

    <div class="page-content tp-intro">
        <?php
        // Output only the intro paragraph (content before the first <h2>)
        $content = apply_filters( 'the_content', get_the_content() );
        $parts = preg_split( '/<h2[\s>]/i', $content, 2 );
        echo $parts[0];
        ?>
    </div>

    <div class="tp-groups">
        <?php
        // Split content into sections by <h2> tags
        $sections = preg_split( '/(<h2[^>]*>.*?<\/h2>)/is', $content, -1, PREG_SPLIT_DELIM_CAPTURE );
        $current_group = 0;

        for ( $i = 1; $i < count( $sections ); $i += 2 ) {
            $heading_html = $sections[$i];
            $body_html    = isset( $sections[$i + 1] ) ? $sections[$i + 1] : '';

            // Working group section
            if ( $current_group >= count( $groups ) ) continue;
            $g = $groups[ $current_group ];
            ?>
            <section class="tp-group" id="<?php echo esc_attr( $g['id'] ); ?>">
                <div class="tp-group__photo">
                    <img src="<?php echo esc_url( "$img/{$g['photo']}" ); ?>" alt="" loading="lazy"/>
                </div>
                <div class="tp-group__content">
                    <img class="tp-group__icon" src="<?php echo esc_url( "$img/{$g['icon']}" ); ?>" alt="" width="48" height="48"/>
                    <?php echo $heading_html; ?>
                    <div class="tp-group__body">
                        <?php echo $body_html; ?>
                    </div>
                </div>
            </section>
            <?php
            $current_group++;
        }
        ?>
    </div>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
