<?php get_header(); ?>

<main class="page-inner">
    <?php while ( have_posts() ) : the_post(); ?>

    <section class="page-hero">
        <div class="page-hero__overlay"></div>
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

    <article class="page-content">
        <?php the_content(); ?>
    </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
