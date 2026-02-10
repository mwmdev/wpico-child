<?php get_header(); ?>

<?php
$img = get_stylesheet_directory_uri() . '/assets/img';
$pdf = get_stylesheet_directory_uri() . '/assets/pdf';
$prefix = c7_get_lang() === 'fr' ? 'fr/' : '';

$groups = array(
    array(
        'id'    => 'climate-energy-and-environment',
        'icon'  => 'temp.svg',
        'photo' => '2ni-f1ojcxolj8q-unsplash.jpg',
        'pdf'   => 'c7-2025-climate,-energy,-the-environment_eng_web.pdf',
    ),
    array(
        'id'    => 'economic-justice',
        'icon'  => 'scale.svg',
        'photo' => 'shelby-murphy-figueroa-lechhhlxywu-unsplash.jpg',
        'pdf'   => 'c7-2025-economic-justice_eng_web-(1).pdf',
    ),
    array(
        'id'    => 'humanitarian-action-and-peace',
        'icon'  => 'peace.svg',
        'photo' => 'sunguk-kim-jhqbxsoruxa-unsplash.jpg',
        'pdf'   => 'c7-2025-humanitarian-action-and-peace_eng_web.pdf',
    ),
    array(
        'id'    => 'sustainable-development',
        'icon'  => 'growth.svg',
        'photo' => 'noah-buscher-x8zstuks2pm-unsplash.jpg',
        'pdf'   => 'c7-2025-sustainable-development_eng_web-(1).pdf',
    ),
);

$cross_cutting = array(
    array( 'icon' => 'vote.svg',   'label' => __( 'Democracy & Civic Space', 'c7' ) ),
    array( 'icon' => 'gender.svg', 'label' => __( 'Gender Equality', 'c7' ) ),
    array( 'icon' => 'tech.svg',   'label' => __( 'Evolving Technology', 'c7' ) ),
);
?>

<main class="page-inner">
    <?php while ( have_posts() ) : the_post(); ?>

    <?php $hero_img = get_the_post_thumbnail_url( null, 'full' ); ?>
    <section class="page-hero">
        <div class="page-hero__overlay"<?php if ( $hero_img ) echo ' style="background-image:url(' . esc_url( $hero_img ) . ')"'; ?>></div>
        <svg class="page-hero__shape" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 843 684" fill="none" preserveAspectRatio="none">
            <path d="M0 248.425V684H330.588C585.325 489.116 757.645 251.98 842.03 0H180.004C136 87.5834 75.8202 171.278 0 248.425Z" fill="url(#pageHeroGrad)" fill-opacity="0.75" style="mix-blend-mode:multiply"/>
            <path d="M0 248.425V684H330.588C585.325 489.116 757.645 251.98 842.03 0H180.004C136 87.5834 75.8202 171.278 0 248.425Z" fill="#05213C" fill-opacity="0.25" style="mix-blend-mode:overlay"/>
            <defs>
                <linearGradient id="pageHeroGrad" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#009CDE"/>
                    <stop offset="1" stop-color="#84CC62"/>
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

            // Check if this is the cross-cutting themes section
            if ( stripos( $heading_html, 'Cross-cutting' ) !== false || stripos( $heading_html, 'transversaux' ) !== false ) {
                // Render cross-cutting themes
                ?>
                <section class="tp-cross">
                    <h2><?php echo strip_tags( $heading_html ); ?></h2>
                    <?php foreach ( $cross_cutting as $theme ) : ?>
                        <div class="tp-cross__item">
                            <img src="<?php echo esc_url( "$img/{$theme['icon']}" ); ?>" alt="" width="48" height="48"/>
                            <span><?php echo esc_html( $theme['label'] ); ?></span>
                        </div>
                    <?php endforeach; ?>
                </section>
                <?php
                continue;
            }

            // Working group section
            if ( $current_group >= count( $groups ) ) continue;
            $g = $groups[ $current_group ];

            // Separate the "Download PDF" link from body content
            $body_clean = preg_replace( '/<p>\s*<a[^>]*\.pdf[^>]*>.*?<\/a>\s*<\/p>/is', '', $body_html );
            ?>
            <section class="tp-group" id="<?php echo esc_attr( $g['id'] ); ?>">
                <div class="tp-group__photo">
                    <img src="<?php echo esc_url( "$img/{$g['photo']}" ); ?>" alt="" loading="lazy"/>
                </div>
                <div class="tp-group__content">
                    <img class="tp-group__icon" src="<?php echo esc_url( "$img/{$g['icon']}" ); ?>" alt="" width="48" height="48"/>
                    <?php echo $heading_html; ?>
                    <a class="tp-group__pdf" href="<?php echo esc_url( "$pdf/{$g['pdf']}" ); ?>" target="_blank" rel="noopener noreferrer">
                        <?php esc_html_e( 'Download PDF', 'c7' ); ?>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20" height="20" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                    </a>
                    <div class="tp-group__body">
                        <?php echo $body_clean; ?>
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
