<?php get_header(); ?>

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

    <!-- Intro -->
    <?php
    $content = apply_filters( 'the_content', get_the_content() );
    $parts   = preg_split( '/<h3[\s>]/i', $content, 2 );
    ?>
    <div class="page-content">
        <?php echo $parts[0]; ?>
    </div>

    <!-- Article list -->
    <div class="news-list">
        <?php
        $img = get_stylesheet_directory_uri() . '/assets/img';

        // Split content into h3 sections
        $sections = preg_split( '/(<h3[^>]*>.*?<\/h3>)/is', $content, -1, PREG_SPLIT_DELIM_CAPTURE );

        for ( $i = 1; $i < count( $sections ); $i += 2 ) {
            $heading_html = $sections[$i];
            $body_html    = isset( $sections[$i + 1] ) ? trim( $sections[$i + 1] ) : '';
            $title        = strip_tags( $heading_html );

            // Extract date from first <strong> in body
            $date = '';
            if ( preg_match( '/<strong>(.*?)<\/strong>/i', $body_html, $dm ) ) {
                $date = strip_tags( $dm[1] );
            }

            // Remove the date paragraph from body for the excerpt
            $excerpt = preg_replace( '/<p>\s*<strong>.*?<\/strong>.*?<\/p>/is', '', $body_html, 1 );
            $excerpt = trim( $excerpt );
            ?>
            <article class="news-item">
                <div class="news-item__img">
                    <img src="<?php echo esc_url( "$img/civildefaultbg.png" ); ?>" alt="" loading="lazy"/>
                </div>
                <h2 class="news-item__title"><?php echo esc_html( $title ); ?></h2>
                <?php if ( $date ) : ?>
                    <span class="news-item__date"><?php echo esc_html( $date ); ?></span>
                <?php endif; ?>
                <div class="news-item__excerpt">
                    <?php echo $excerpt; ?>
                </div>
            </article>
            <?php
        }
        ?>
    </div>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
