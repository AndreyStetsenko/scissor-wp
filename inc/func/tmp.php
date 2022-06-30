<?php

// Post link prev/next

function cwp_filter_next_post_link($link) { 
  $link = str_replace("rel=", 'class="item-link" rel=', $link); 
	return $link; 
} 
add_filter('next_post_link', 'cwp_filter_next_post_link'); 

function cwp_filter_previous_post_link($link) { 
	$link = str_replace("rel=", 'class="item-link" rel=', $link); 
	return $link; 
} 
add_filter('previous_post_link', 'cwp_filter_previous_post_link');

// Загрузка SVG

add_filter( 'upload_mimes', 'svg_upload_allow' );

# Добавляет SVG в список разрешенных для загрузки файлов.
function svg_upload_allow( $mimes ) {
	$mimes['svg']  = 'image/svg+xml';

	return $mimes;
}

add_filter( 'wp_check_filetype_and_ext', 'fix_svg_mime_type', 10, 5 );

# Исправление MIME типа для SVG файлов.
function fix_svg_mime_type( $data, $file, $filename, $mimes, $real_mime = '' ){

	// WP 5.1 +
	if( version_compare( $GLOBALS['wp_version'], '5.1.0', '>=' ) )
		$dosvg = in_array( $real_mime, [ 'image/svg', 'image/svg+xml' ] );
	else
		$dosvg = ( '.svg' === strtolower( substr($filename, -4) ) );

	// mime тип был обнулен, поправим его
	// а также проверим право пользователя
	if( $dosvg ){

		// разрешим
		if( current_user_can('manage_options') ){

			$data['ext']  = 'svg';
			$data['type'] = 'image/svg+xml';
		}
		// запретим
		else {
			$data['ext'] = $type_and_ext['type'] = false;
		}

	}

	return $data;
}

// Custom Logo
add_filter( 'get_custom_logo', 'change_logo_class' );

function change_logo_class( $html ) {

    $html = str_replace( 'custom-logo-link', 'main-nav--logo', $html );

    return $html;
}

/**
 * Menu
 */

function wpb_custom_new_menu() {
  register_nav_menus(
    array(
      'nav-head-main' => __( 'Navigation Head Main' )
    )
  );
}
add_action( 'init', 'wpb_custom_new_menu' );