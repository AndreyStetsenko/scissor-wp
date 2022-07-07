<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Scissor
 */

global $woocommerce;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

	<header class="header" id="header">

        <?php
        $promo_banner = get_field('promo_banner', 'options');
        if( $promo_banner ) {
            echo '<div class="promo-banner">';
            echo '<div class="container">';
            echo '<div class="promo-banner--cont">';
            foreach( $promo_banner as $item ) {
                $row = '<span>';
                $row .= $item['title'];
                $row .= '</span>';

                echo $row;
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>

        <div class="main-nav" id="navbar">
            <div class="container-fluid">

                <button class="main-nav--toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="main-nav--logomob">
                    <?php
                        the_custom_logo();
                    ?>
                </div>

                <div class="main-nav--cont navbar-collapse collapse" id="navbarSupportedContent">
                    <div class="main-nav--nav">
                        <?php
                        wp_nav_menu(
                        	array(
                        		'menu_id'           => 'nav-head-main',
                                'container'         => 'ul',
                                'menu_class'   => 'nav-list'
                        	)
                        );
                        ?>
                    </div>

                    <?php
                        the_custom_logo();
                    ?>

                    <div class="main-nav--nav">
                        <ul class="nav-list">
                            <li>
                                <form action="" class="header-search">
                                    <div class="header-search--input" id="containerSearchHeader">
                                        <input type="text" placeholder="Пошук..." id="inputSearchHeader">
                                        <div class="close" id="closeSearchHeader">
                                            <i class="fa-solid fa-xmark"></i>
                                        </div>
                                    </div>
                                    <button class="btn btn-search" id="btnSearchHeader" data-expended="false"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </form>
                            </li>
                            <li>
                                <div class="dropdown dropdown-lang">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="currLang" data-bs-toggle="dropdown" aria-expanded="false">
                                        <?= apply_filters( 'wpml_current_language', NULL ) ?>
                                    </a>

                                    <ul class="dropdown-menu" aria-labelledby="currLang">
                                        <?= my_flag_only_language_switcher() ?>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#"><i class="fa-regular fa-user me-1"></i> <?php esc_html_e('Аккаунт', 'scissor'); ?></a>
                            </li>
                            <li><a href="<?= wc_get_cart_url() ?>">Корзина (<?= WC()->cart->get_cart_contents_count(); ?>)</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>