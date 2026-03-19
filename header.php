<!doctype html>
<html <?php language_attributes(); ?> >
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

    <div class="top-banner">
        <div class="container">
            <span><?php esc_html_e( 'Together for global justice', 'c7' ); ?></span>
            <a href="https://pub-6aff04384c4245dbace9b1db0d5e61fb.r2.dev/c7-2025-communique-global-justice-together-web.pdf" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Download the Communique - Opens in a new tab', 'c7' ); ?>">
                <span><?php esc_html_e( 'Read the communique', 'c7' ); ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" width="16" height="16" aria-hidden="true"><path d="M6.22 8.72a.75.75 0 0 0 1.06 1.06l5.22-5.22v1.69a.75.75 0 0 0 1.5 0v-3.5a.75.75 0 0 0-.75-.75h-3.5a.75.75 0 0 0 0 1.5h1.69L6.22 8.72Z"/><path d="M3.5 6.75c0-.69.56-1.25 1.25-1.25H7A.75.75 0 0 0 7 4H4.75A2.75 2.75 0 0 0 2 6.75v4.5A2.75 2.75 0 0 0 4.75 14h4.5A2.75 2.75 0 0 0 12 11.25V9a.75.75 0 0 0-1.5 0v2.25c0 .69-.56 1.25-1.25 1.25h-4.5c-.69 0-1.25-.56-1.25-1.25v-4.5Z"/></svg>
            </a>
        </div>
    </div>

    <header class="site-header">
        <div class="container">
            <a class="site-header__logo" href="<?php echo esc_url( home_url( c7_get_lang() === 'fr' ? '/fr/' : '/' ) ); ?>">
                <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/LOGO-COULEUR.svg' ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
            </a>

            <input id="nav-toggle" type="checkbox" />
            <label for="nav-toggle">
                <span class="nav-toggle-btn"></span>
            </label>

            <nav>
                <label for="nav-toggle"></label>
                <?php wp_nav_menu( array( 'menu' => c7_get_lang() === 'fr' ? 'Principal FR' : 'Principal' ) ); ?>

                <div class="nav-extras">
                    <a href="<?php echo esc_url( c7_get_translation_url() ); ?>"><?php echo c7_get_lang() === 'fr' ? 'English' : 'Français'; ?></a>
                    <a href="https://twitter.com/civil7official" target="_blank" rel="noopener" aria-label="X (Twitter)">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="https://www.linkedin.com/company/civil7-2024-italy/" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                </div>
            </nav>

            <section id="search">
                <label for="search-toggle"></label>
                <input type="checkbox" role="button" id="search-toggle" />
                <div class="overlay">
                    <label for="search-toggle"></label>
                    <form role="search" method="GET" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <input name="s" type="search" placeholder="<?php esc_attr_e( 'Search', 'c7' ); ?>" />
                        <button type="submit"><?php esc_html_e( 'Ok', 'c7' ); ?></button>
                    </form>
                </div>
            </section>
        </div>
    </header>
