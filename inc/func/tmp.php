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

function my_flag_only_language_switcher() {
    $languages = apply_filters( 'wpml_active_languages', NULL, array( 'skip_missing' => 0 ) );
 
    if( !empty( $languages ) ) {
        foreach( $languages as $language ){
            $native_name = $language['active'] ? strtoupper( $language['code'] ) : $language['code'];
 
            if( !$language['active'] ) {
				echo '<li><a href="' . esc_url( $language['url'] ) . '">';
				echo esc_html( $native_name ) . ' ';
				echo '</a></li>';
			}
        }
    }
}

// User Fields Profile

// когда пользователь сам редактирует свой профиль
add_action( 'show_user_profile', 'true_show_profile_fields' );

// когда чей-то профиль редактируется админом например
add_action( 'edit_user_profile', 'true_show_profile_fields' );
 
function true_show_profile_fields( $user ) {
 
	// выводим заголовок для наших полей
 	echo '<h3>Подтвержденный пользователь</h3>';
 
	// поля в профиле находятся в рамметке таблиц <table>
 	echo '<table class="form-table">';
 
 	// добавляем поле город
	$verification = get_the_author_meta( 'verification', $user->ID );

	$status = '';

	$verification == 'on' ? $status = 'checked' : $status = '';

 	echo '<tr>
 	<td><label><input name="verification" ' . $status . ' type="checkbox" /> Подтвержденный</label></td>
	</tr>';
 
 	echo '</table>';
 
}

// когда пользователь сам редактирует свой профиль
add_action( 'personal_options_update', 'true_save_profile_fields' );
// когда чей-то профиль редактируется админом например
add_action( 'edit_user_profile_update', 'true_save_profile_fields' );
 
function true_save_profile_fields( $user_id ) {
 
	update_user_meta( $user_id, 'verification', sanitize_text_field( $_POST[ 'verification' ] ) );
 
}

// Перенаправление со страниц входа, например, с http://yoursite.com/wp-login.php
 
function custom_login() {
	echo header("Location: " . get_bloginfo( 'url' ) . "/login");
 }
  
 add_action('login_head', 'custom_login');
  
 function login_link_url( $url ) {
	$url = get_bloginfo( 'url' ) . "/login";
	return $url;
	}
 add_filter( 'login_url', 'login_link_url', 10, 2 );

//  Перенаправления на страницу регистрации

 function register_link_url( $url ) {
	if ( ! is_user_logged_in() ) {
	   if ( get_option('users_can_register') )
	  $url = '<li><a href="' . get_bloginfo( 'url' ) . "/register" . '">' . __('Register', 'yourtheme') . '</a></li>';
		else  $url = '';
	} else { 
		  $url = '<li><a href="' . admin_url() . '">' . __('Site Admin', 'yourtheme') . '</a></li>';
	}
	return $url;
  }
  add_filter( 'register', 'register_link_url', 10, 2 );

// Comments

function collectiveray_enable_threaded_comments(){

    if (!is_admin()) {

        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1))

            wp_enqueue_script('comment-reply');

        }

}
 
//ВЫВОДИМ РЕЙТИНГ В ОПУБЛИКОВАННОМ КОММЕНТАРИИ
function comm_rating_display_rating( $comment_text ) {
	if ( $rating = get_comment_meta( get_comment_ID(), 'rating', true ) ) {
		$stars = '<div class="com_star">';

		for ( $i = 1; $i <= $rating; $i++ ) {
			$stars .= '<span class="dashicons dashicons-star-filled"></span>';
		}

		$stars .= '</div>';
		$comment_text = $comment_text . $stars;

		return $comment_text;
	}
}

//ПОДСЧЕТ ОБЩЕЙ ОЦЕНКИ.
function comm_rating_get_average_ratings( $id ) {
    $comments = get_approved_comments( $id );
    if ( $comments ) {
        $i = 0;
        $total = 0;
        foreach( $comments as $comment ){
            $rate = get_comment_meta( $comment->comment_ID, 'rating', true );
            if( isset( $rate ) && '' !== $rate ) {
                $i++;
                $total += $rate;
            }
        }
 
        if ( 0 === $i ) {
            return false;
        } else {
            return round( $total / $i, 1 );
        }
    } else {
        return false;
    }
}
 
// ВЫВОД ОЦЕНКИ ПЕРЕД ПОСТОМ
function comm_rating_display_average_rating() {
	global $post;

	$stars   = '';
	$average = comm_rating_get_average_ratings( $post->ID );

	for ( $i = 1; $i <= $average + 1; $i++ ) {
		$width = intval( $i - $average > 0 ? 20 - ( ( $i - $average ) * 20 ) : 20 );

		if ( 0 === $width ) {
			continue;
		}

		$stars .= '<span style="overflow:hidden; width:' . $width . 'px" class="dashicons dashicons-star-filled"></span>';

		if ( $i - $average > 0 ) {
			$stars .= '<span style="overflow:hidden; position:relative; left:-' . $width .'px;" class="dashicons dashicons-star-empty"></span>';
		}
	}

	$custom_content  = '<div class="all_com_pr">Оценка: ' . $average .' ' . $stars .'</div>';

	echo $custom_content;
}