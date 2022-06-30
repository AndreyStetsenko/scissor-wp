<?php
/**
 * Scissor functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Scissor
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function scissor_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Scissor, use a find and replace
		* to change 'scissor' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'scissor', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'scissor' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'scissor_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'scissor_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function scissor_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'scissor_content_width', 640 );
}
add_action( 'after_setup_theme', 'scissor_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function scissor_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'scissor' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'scissor' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'scissor_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function scissor_scripts() {
	// wp_enqueue_style( 'scissor-style', get_stylesheet_uri(), array(), _S_VERSION );
	// wp_style_add_data( 'scissor-style', 'rtl', 'replace' );

	wp_enqueue_style( 'scissor-style', get_template_directory_uri() . '/assets/javascript/build/style.css', array(), _S_VERSION );
	// wp_enqueue_style( 'scissor-fontawesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css', array(), _S_VERSION );

	wp_enqueue_script( 'scissor-jquery', get_template_directory_uri() . '/assets/vendor/jquery-3.5.1/jquery-3.5.1.min.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'scissor-jqueryui', get_template_directory_uri() . '/assets/vendor/jqueryui-1.12.1/jquery-ui.min.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'scissor-product', get_template_directory_uri() . '/assets/javascript/build/product.bundle.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'scissor_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

function rudr_instagram_api_curl_connect( $api_url ){
	$connection_c = curl_init(); // initializing
	curl_setopt( $connection_c, CURLOPT_URL, $api_url ); // API URL to connect
	curl_setopt( $connection_c, CURLOPT_RETURNTRANSFER, 1 ); // return the result, do not print
	curl_setopt( $connection_c, CURLOPT_TIMEOUT, 20 );
	$json_return = curl_exec( $connection_c ); // connect and get json data
	curl_close( $connection_c ); // close connection
	return json_decode( $json_return ); // decode and return
}