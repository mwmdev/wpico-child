<?php get_header(); ?>

<?php
$img = get_stylesheet_directory_uri() . '/assets/img';
$pdf = get_stylesheet_directory_uri() . '/assets/pdf';

$thematic = array(
    array(
        'title' => __( 'Climate, Energy & Environment', 'c7' ),
        'icon'  => 'temp.svg',
        'photo' => '2ni-f1ojcxolj8q-unsplash.jpg',
        'pdf'   => 'c7-2025-climate,-energy,-the-environment_eng_web.pdf',
    ),
    array(
        'title' => __( 'Economic Justice', 'c7' ),
        'icon'  => 'scale.svg',
        'photo' => 'shelby-murphy-figueroa-lechhhlxywu-unsplash.jpg',
        'pdf'   => 'c7-2025-economic-justice_eng_web-(1).pdf',
    ),
    array(
        'title' => __( 'Humanitarian Action & Peace', 'c7' ),
        'icon'  => 'peace.svg',
        'photo' => 'sunguk-kim-jhqbxsoruxa-unsplash.jpg',
        'pdf'   => 'c7-2025-humanitarian-action-and-peace_eng_web.pdf',
    ),
    array(
        'title' => __( 'Sustainable Development', 'c7' ),
        'icon'  => 'growth.svg',
        'photo' => 'noah-buscher-x8zstuks2pm-unsplash.jpg',
        'pdf'   => 'c7-2025-sustainable-development_eng_web-(1).pdf',
    ),
);

$other = array(
    array(
        'title' => __( 'Debt Policy Paper', 'c7' ),
        'thumb' => 'screenshot-2025-04-29-at-7.45.51-pm.png',
        'pdf'   => 'c7-debtpolicypaper.pdf',
    ),
    array(
        'title' => __( 'Conflict Policy Paper', 'c7' ),
        'thumb' => 'conflict-policy-paper-screenshot-6.png',
        'pdf'   => 'policy-paper---adressing-the-root-causes-of-global-insecurity-through-empowering-youth-engaged-in-conflicts.pdf',
    ),
);

$past = array(
    array(
        'title' => __( '2024 Italy Communiqué', 'c7' ),
        'thumb' => 'screenshot-2024-11-24-at-5.09.53-pm-1732486532.png',
        'url'   => 'https://2024.civil7.org/wpC7/wp-content/uploads/2024/05/C7-Communique_2024.pdf',
    ),
    array(
        'title' => __( '2023 Japan Communiqué', 'c7' ),
        'thumb' => 'screenshot-2024-11-24-at-5.09.37-pm.png',
        'url'   => 'https://2023.civil7.org/wp-content/uploads/2023/04/C7_communique2023_0412.pdf',
    ),
    array(
        'title' => __( '2022 Germany Communiqué', 'c7' ),
        'thumb' => 'screenshot-2024-11-24-at-5.10.53-pm.png',
        'url'   => 'https://2022.civil7.org/wp-content/uploads/2022/05/Civil7-Communique-2022-1.pdf',
    ),
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

    <!-- Intro -->
    <div class="page-content">
        <p><?php esc_html_e( 'Discover additional information, statements and documentation from current and past C7 Summits.', 'c7' ); ?></p>
    </div>

    <!-- Featured Communiqué -->
    <section class="res-featured">
        <div class="res-featured__text">
            <h2><?php esc_html_e( 'The 2025 C7 Communiqué is now available', 'c7' ); ?></h2>
            <p><?php esc_html_e( 'Building a more just, equitable and sustainable world — for everyone.', 'c7' ); ?></p>
            <a class="res-featured__btn" href="<?php echo esc_url( "$pdf/c7-2025-communique-global-justice-together-web.pdf" ); ?>" target="_blank" rel="noopener noreferrer">
                <?php esc_html_e( 'Download the Communiqué', 'c7' ); ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" width="20" height="20" aria-hidden="true">
                    <path d="M6.22 8.72a.75.75 0 0 0 1.06 1.06l5.22-5.22v1.69a.75.75 0 0 0 1.5 0v-3.5a.75.75 0 0 0-.75-.75h-3.5a.75.75 0 0 0 0 1.5h1.69L6.22 8.72Z"/>
                    <path d="M3.5 6.75c0-.69.56-1.25 1.25-1.25H7A.75.75 0 0 0 7 4H4.75A2.75 2.75 0 0 0 2 6.75v4.5A2.75 2.75 0 0 0 4.75 14h4.5A2.75 2.75 0 0 0 12 11.25V9a.75.75 0 0 0-1.5 0v2.25c0 .69-.56 1.25-1.25 1.25h-4.5c-.69 0-1.25-.56-1.25-1.25v-4.5Z"/>
                </svg>
            </a>
        </div>
        <img class="res-featured__cover" src="<?php echo esc_url( "$img/c7-cover-en.png" ); ?>" alt="" width="1220" height="870" loading="lazy"/>
    </section>

    <div class="res-sections">

        <!-- Thematic Priorities -->
        <section class="res-section">
            <h2><?php esc_html_e( 'Thematic Priorities', 'c7' ); ?></h2>
            <div class="res-grid">
                <?php foreach ( $thematic as $item ) : ?>
                    <a class="res-card res-card--thematic" href="<?php echo esc_url( "$pdf/{$item['pdf']}" ); ?>" target="_blank" rel="noopener noreferrer">
                        <div class="res-card__img">
                            <img class="res-card__icon" src="<?php echo esc_url( "$img/{$item['icon']}" ); ?>" alt="" width="40" height="40"/>
                            <span class="res-card__overlay"></span>
                            <img src="<?php echo esc_url( "$img/{$item['photo']}" ); ?>" alt="" loading="lazy"/>
                        </div>
                        <span class="res-card__title"><?php echo esc_html( $item['title'] ); ?></span>
                        <span class="res-card__dl"><?php esc_html_e( 'Download PDF', 'c7' ); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Other Resources -->
        <section class="res-section">
            <h2><?php esc_html_e( 'Other Resources', 'c7' ); ?></h2>
            <div class="res-grid">
                <?php foreach ( $other as $item ) : ?>
                    <a class="res-card" href="<?php echo esc_url( "$pdf/{$item['pdf']}" ); ?>" target="_blank" rel="noopener noreferrer">
                        <div class="res-card__img">
                            <img src="<?php echo esc_url( "$img/{$item['thumb']}" ); ?>" alt="" loading="lazy"/>
                        </div>
                        <span class="res-card__title"><?php echo esc_html( $item['title'] ); ?></span>
                        <span class="res-card__dl"><?php esc_html_e( 'Download PDF', 'c7' ); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Past Communiqués -->
        <section class="res-section">
            <h2><?php esc_html_e( 'Past Communiqués', 'c7' ); ?></h2>
            <div class="res-grid">
                <?php foreach ( $past as $item ) : ?>
                    <a class="res-card" href="<?php echo esc_url( $item['url'] ); ?>" target="_blank" rel="noopener noreferrer">
                        <div class="res-card__img">
                            <img src="<?php echo esc_url( "$img/{$item['thumb']}" ); ?>" alt="" loading="lazy"/>
                        </div>
                        <span class="res-card__title"><?php echo esc_html( $item['title'] ); ?></span>
                        <span class="res-card__dl"><?php esc_html_e( 'Download PDF', 'c7' ); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>

    </div>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
