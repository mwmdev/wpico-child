<?php get_header(); ?>

<main class="page-inner">
    <?php while ( have_posts() ) : the_post(); ?>

    <?php $hero_img = get_the_post_thumbnail_url( null, 'full' ); ?>
    <section class="page-hero">
        <div class="page-hero__overlay"<?php if ( $hero_img ) echo ' style="background-image:url(' . esc_url( $hero_img ) . ')"'; ?>></div>
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

    <?php
    $content = apply_filters( 'the_content', get_the_content() );

    // Split at the event-list div to separate intro from events
    $parts = preg_split( '/(<div class="event-list">)/i', $content, 2, PREG_SPLIT_DELIM_CAPTURE );
    $intro  = isset( $parts[0] ) ? trim( $parts[0] ) : '';
    $events = ( isset( $parts[1] ) && isset( $parts[2] ) ) ? $parts[1] . $parts[2] : '';
    ?>

    <?php if ( $intro ) : ?>
    <div class="page-content">
        <?php echo $intro; ?>
    </div>
    <?php endif; ?>

    <div class="events-wrap">
        <?php echo $events; ?>
    </div>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
