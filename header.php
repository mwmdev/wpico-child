<!doctype html>
<html <?php language_attributes(); ?> >
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
    <div class="container">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <h1><?php bloginfo( 'name' ); ?></h1>
        </a>
        <small><?php bloginfo( 'description' ); ?></small>
        <input id="nav-toggle" type="checkbox" />
        <label for="nav-toggle">
            <span class="nav-toggle-btn"></span>
        </label>
        <nav>
            <label for="nav-toggle"></label>
			<?php wp_nav_menu( array( 'menu' => 'Principal' ) ); ?>
        </nav>

        <section id="search">
            <label for="search-toggle"></label>
            <input type="checkbox" role="button" id="search-toggle" />
            <div class="overlay">
                <label for="search-toggle"></label>
                <form role="search" method="GET" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <input name="s" type="search" placeholder="Rechercher" />
                    <button type="submit" >Ok</button>
                </form>
            </div>
        </section>

    </div>
</header>
