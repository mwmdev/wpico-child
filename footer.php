    <footer class="site-footer">
        <div class="site-footer__inner">
            <div class="site-footer__about">
                <a class="site-footer__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/C7-LOGO-BLANC.svg' ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
                </a>
                <p><?php esc_html_e( "Coordination SUD is the national coordination of French international solidarity organizations. It brings together more than 180 NGOs working in the fields of emergency, development, environmental protection, human rights, and advocacy.", 'c7' ); ?></p>
            </div>
            <nav class="site-footer__nav">
                <ul>
                    <li><a href="https://www.coordinationsud.org/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Coordination SUD', 'c7' ); ?></a></li>
                    <li><a href="<?php echo esc_url( get_permalink( get_page_by_path( c7_page_path( 'contact' ) ) ) ); ?>"><?php esc_html_e( 'Contact', 'c7' ); ?></a></li>
                </ul>
            </nav>
            <div class="site-footer__social">
                <a href="https://twitter.com/civil7official" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Visit X Profile', 'c7' ); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
                        <path fill="currentColor" d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/>
                    </svg>
                </a>
                <a href="https://www.linkedin.com/company/civil7-2024-italy/" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Visit LinkedIn Profile', 'c7' ); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
                        <path fill="currentColor" d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                </a>
            </div>
        </div>
        <?php wp_footer(); ?>
    </footer>
    </body>
</html>
