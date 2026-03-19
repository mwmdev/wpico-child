<?php get_header(); ?>

<main class="front-page">

    <?php
    $img = get_stylesheet_directory_uri() . '/assets/img';
    $pdf = get_stylesheet_directory_uri() . '/assets/pdf';
    $priorities_url = get_permalink( get_page_by_path( c7_page_path( 'thematic-priorities' ) ) );
    $what_url       = get_permalink( get_page_by_path( c7_page_path( 'what-is-c7' ) ) );
    $news_url       = get_permalink( get_page_by_path( c7_page_path( 'news' ) ) );
    $events_url     = get_permalink( get_page_by_path( c7_page_path( 'events-calendar' ) ) );
    $resources_url  = get_permalink( get_page_by_path( c7_page_path( 'resources' ) ) );
    ?>

    <!-- Hero -->
    <section class="hero">
        <div class="hero__overlay"></div>
        <svg class="hero__shape" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 843 684" fill="none" preserveAspectRatio="none">
            <path d="M0 248.425V684H330.588C585.325 489.116 757.645 251.98 842.03 0H180.004C136 87.5834 75.8202 171.278 0 248.425Z" fill="url(#heroGrad)" fill-opacity="0.75" style="mix-blend-mode:multiply"/>
            <path d="M0 248.425V684H330.588C585.325 489.116 757.645 251.98 842.03 0H180.004C136 87.5834 75.8202 171.278 0 248.425Z" fill="#19199F" fill-opacity="0.25" style="mix-blend-mode:overlay"/>
            <defs>
                <linearGradient id="heroGrad" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#5555B5"/>
                    <stop offset="1" stop-color="#FF9E1B"/>
                </linearGradient>
            </defs>
        </svg>
        <img class="hero__halo" src="<?php echo esc_url( "$img/halo.svg" ); ?>" alt="" loading="eager"/>
        <h1><?php esc_html_e( 'Together for change', 'c7' ); ?></h1>
        <div class="hero__blur"></div>
        <img class="hero__cover" src="<?php echo esc_url( "$img/visuel-communique.png" ); ?>" alt="" width="1220" height="870" loading="eager"/>
    </section>

    <!-- Communiqué CTA (white card overlapping hero) -->
    <section class="communique">
        <p class="communique__intro">
            <?php esc_html_e( 'The Civil Society 7 (C7) is an official G7 engagement group representing civil society interests and developing recommendations to be escalated into G7 Summit decisions.', 'c7' ); ?>
        </p>
        <a class="communique__link" href="<?php echo esc_url( $what_url ); ?>">
            <?php esc_html_e( 'Defining tomorrow, today.', 'c7' ); ?>
        </a>
    </section>

    <!-- Communiqué banner -->
    <section class="communique-banner">
        <div class="communique-banner__content">
            <h2><?php esc_html_e( 'The 2026 C7 Communique is now available', 'c7' ); ?></h2>
            <p><?php esc_html_e( 'Together for change', 'c7' ); ?></p>
            <a class="communique-banner__btn" href="<?php echo esc_url( "$pdf/c7-2025-communique-global-justice-together-web.pdf" ); ?>" target="_blank" rel="noopener noreferrer">
                <?php esc_html_e( 'Read the Communique', 'c7' ); ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" width="20" height="20" aria-hidden="true">
                    <path d="M6.22 8.72a.75.75 0 0 0 1.06 1.06l5.22-5.22v1.69a.75.75 0 0 0 1.5 0v-3.5a.75.75 0 0 0-.75-.75h-3.5a.75.75 0 0 0 0 1.5h1.69L6.22 8.72Z"/>
                    <path d="M3.5 6.75c0-.69.56-1.25 1.25-1.25H7A.75.75 0 0 0 7 4H4.75A2.75 2.75 0 0 0 2 6.75v4.5A2.75 2.75 0 0 0 4.75 14h4.5A2.75 2.75 0 0 0 12 11.25V9a.75.75 0 0 0-1.5 0v2.25c0 .69-.56 1.25-1.25 1.25h-4.5c-.69 0-1.25-.56-1.25-1.25v-4.5Z"/>
                </svg>
            </a>
        </div>
        <img class="communique-banner__cover" src="<?php echo esc_url( "$img/visuel-communique.png" ); ?>" alt="" width="1220" height="870" loading="lazy"/>
    </section>

    <!-- About / Defining tomorrow -->
    <section class="about">
        <svg class="about__shape" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1440 1403.53" width="100%">
            <defs>
                <linearGradient id="aboutGrad" x1="352.58" y1="1248.48" x2="894.14" y2="455.81" gradientUnits="userSpaceOnUse">
                    <stop offset="0" stop-color="#5555B5"/>
                    <stop offset="1" stop-color="#FF9E1B"/>
                </linearGradient>
            </defs>
            <path fill="url(#aboutGrad)" d="M1455.74,652.67v412.78c-132.31,28.87-271.57,44.28-415.33,44.28-406.48,0-776.95-123.18-1056.13-325.36V47.13c110.37,384.57,541.33,671.43,1056.13,671.43,147.14,0,287.43-23.43,415.33-65.88Z"/>
        </svg>
        <div class="about__inner">
            <h2><?php esc_html_e( 'Defining tomorrow, today.', 'c7' ); ?></h2>
            <p><?php esc_html_e( "Through a thoughtful balancing of the French G7 presidency objectives and international civil society concerns, we've curated a list of thematic priorities and established dedicated working groups to tackle them.", 'c7' ); ?></p>
            <a href="<?php echo esc_url( $priorities_url ); ?>">
                <?php esc_html_e( 'Read more about our working groups', 'c7' ); ?>
            </a>
        </div>
    </section>

    <!-- Working Group Cards -->
    <section class="priorities">
        <div class="priorities__grid">
            <a class="priorities__card" href="<?php echo esc_url( $priorities_url . '#climat' ); ?>">
                <img src="<?php echo esc_url( "$img/climat.svg" ); ?>" alt="" width="50" height="50"/>
                <span><?php esc_html_e( 'Climate', 'c7' ); ?></span>
            </a>
            <a class="priorities__card" href="<?php echo esc_url( $priorities_url . '#financement' ); ?>">
                <img src="<?php echo esc_url( "$img/financement.svg" ); ?>" alt="" width="50" height="50"/>
                <span><?php esc_html_e( 'Financing', 'c7' ); ?></span>
            </a>
            <a class="priorities__card" href="<?php echo esc_url( $priorities_url . '#espace-civique' ); ?>">
                <img src="<?php echo esc_url( "$img/espace-civique.svg" ); ?>" alt="" width="50" height="50"/>
                <span><?php esc_html_e( 'Civic Space', 'c7' ); ?></span>
            </a>
            <a class="priorities__card" href="<?php echo esc_url( $priorities_url . '#sante' ); ?>">
                <img src="<?php echo esc_url( "$img/sante.svg" ); ?>" alt="" width="50" height="50"/>
                <span><?php esc_html_e( 'Health', 'c7' ); ?></span>
            </a>
        </div>
    </section>

    <!-- Info Grid (News / Events / Resources) -->
    <section class="info-grid">
        <div class="info-grid__cards">
            <div class="info-grid__card">
                <h3><?php esc_html_e( 'Keep up with our news', 'c7' ); ?></h3>
                <p><?php esc_html_e( 'Join the conversation and help shape the future of global governance.', 'c7' ); ?></p>
                <a href="<?php echo esc_url( $news_url ); ?>">
                    <?php esc_html_e( 'Read our news updates', 'c7' ); ?>
                </a>
            </div>
            <div class="info-grid__card">
                <h3><?php esc_html_e( 'Participate in C7 events', 'c7' ); ?></h3>
                <p><?php esc_html_e( 'Discover the thematic priorities that guide our work and advocacy.', 'c7' ); ?></p>
                <a href="<?php echo esc_url( $events_url ); ?>">
                    <?php esc_html_e( "See our events' calendar", 'c7' ); ?>
                </a>
            </div>
            <div class="info-grid__card">
                <h3><?php esc_html_e( 'Explore our resources', 'c7' ); ?></h3>
                <p><?php esc_html_e( 'Learn more about the Civil Society 7 and our mission to promote global justice.', 'c7' ); ?></p>
                <a href="<?php echo esc_url( $resources_url ); ?>">
                    <?php esc_html_e( 'Discover our resources', 'c7' ); ?>
                </a>
            </div>
        </div>
        <img class="info-grid__bg" src="<?php echo esc_url( "$img/bandeau-basdepage.png" ); ?>" alt="" loading="lazy"/>
        <svg class="info-grid__shape" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 843 684" fill="none" preserveAspectRatio="none">
            <path d="M0 248.425V684H330.588C585.325 489.116 757.645 251.98 842.03 0H180.004C136 87.5834 75.8202 171.278 0 248.425Z" fill="url(#infoGrad)" fill-opacity="0.75" style="mix-blend-mode:multiply"/>
            <defs>
                <linearGradient id="infoGrad" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#5555B5"/>
                    <stop offset="1" stop-color="#FF9E1B"/>
                </linearGradient>
            </defs>
        </svg>
    </section>

</main>

<?php get_footer(); ?>
