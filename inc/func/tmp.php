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

// Перенаправление со стандартных страниц входа, например, с http://yoursite.com/wp-login.php
 
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

function true_add_ajax_comment(){
    global $wpdb;
    $comment_post_ID = isset($_POST['comment_post_ID']) ? (int) $_POST['comment_post_ID'] : 0;
 
    $post = get_post($comment_post_ID);
 
    if ( empty($post->comment_status) ) {
        do_action('comment_id_not_found', $comment_post_ID);
        exit;
    }
 
    $status = get_post_status($post);
 
    $status_obj = get_post_status_object($status);
 
    /*
     * различные проверки комментария
     */
    if ( !comments_open($comment_post_ID) ) {
        do_action('comment_closed', $comment_post_ID);
        wp_die( __('Sorry, comments are closed for this item.') );
    } elseif ( 'trash' == $status ) {
        do_action('comment_on_trash', $comment_post_ID);
        exit;
    } elseif ( !$status_obj->public && !$status_obj->private ) {
        do_action('comment_on_draft', $comment_post_ID);
        exit;
    } elseif ( post_password_required($comment_post_ID) ) {
        do_action('comment_on_password_protected', $comment_post_ID);
        exit;
    } else {
        do_action('pre_comment_on_post', $comment_post_ID);
    }
 
    $comment_author       = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
    $comment_author_email = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
    $comment_author_url   = ( isset($_POST['url']) )     ? trim($_POST['url']) : null;
    $comment_content      = ( isset($_POST['comment']) ) ? trim($_POST['comment']) : null;
 
    /* 
     * проверяем, залогинен ли пользователь
     */
    $user = wp_get_current_user();
    if ( $user->exists() ) {
        if ( empty( $user->display_name ) )
            $user->display_name=$user->user_login;
        $comment_author       = $wpdb->escape($user->display_name);
        $comment_author_email = $wpdb->escape($user->user_email);
        $comment_author_url   = $wpdb->escape($user->user_url);
        $user_ID = get_current_user_id();
        if ( current_user_can('unfiltered_html') ) {
            if ( wp_create_nonce('unfiltered-html-comment_' . $comment_post_ID) != $_POST['_wp_unfiltered_html_comment'] ) {
                kses_remove_filters(); // start with a clean slate
                kses_init_filters(); // set up the filters
            }
        }
    } else {
        if ( get_option('comment_registration') || 'private' == $status )
            wp_die( 'Вы должны зарегистрироваться или войти, чтобы оставлять комментарии.' );
    }
 
    $comment_type = '';
 
    /* 
     * проверяем, заполнил ли пользователь все необходимые поля
     */
    if ( get_option('require_name_email') && !$user->exists() ) {
        if ( 6 > strlen($comment_author_email) || '' == $comment_author )
            wp_die( 'Ошибка: заполните необходимые поля (Имя, Email).' );
        elseif ( !is_email($comment_author_email))
            wp_die( 'Ошибка: введенный вами email некорректный.' );
    }
 
    if ( '' == trim($comment_content) ||  '<p><br></p>' == $comment_content )
        wp_die( 'Вы забыли про комментарий.' );
 
    /* 
     * добавляем новый коммент и сразу же обращаемся к нему
     */
    $comment_parent = isset($_POST['comment_parent']) ? absint($_POST['comment_parent']) : 0;
    $commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');
    $comment_id = wp_new_comment( $commentdata );
    $comment = get_comment($comment_id);
 
    /*
     * выставляем кукисы
     */
    do_action('set_comment_cookies', $comment, $user);
 
    /*
     * вложенность комментариев
     */
    $comment_depth = 1;
    while($comment_parent){
        $comment_depth++;
        $parent_comment = get_comment($comment_parent);
        $comment_parent = $parent_comment->comment_parent;
    }
 
    $GLOBALS['comment'] = $comment;
    $GLOBALS['comment_depth'] = $comment_depth;
    /*
     * ниже идет шаблон нового комментария, вы можете настроить его для себя,
     * а можете воспользоваться функцией(которая скорее всего уже есть в теме) для его вывода
     */
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <div id="comment-<?php comment_ID(); ?>">
            <div class="comment-author vcard">
                <?php echo get_avatar( $comment, 40 ); ?>
                <cite class="fn"><?php echo get_comment_author_link(); ?></cite>
            </div>
            <?php if ( $comment->comment_approved == '0' ) : ?>
                <em class="comment-awaiting-moderation">Комментарий отправлен на проверку</em>
                <br />
            <?php endif; ?>
            <div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                <?php printf('%1$s в %2$s', get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link('ред.', ' ' );  ?>
            </div>
            <div class="comment-body"><?php comment_text(); ?></div>
        </div>
    </li>
    <?php
    die();
}
 
add_action('wp_ajax_ajaxcomments', 'true_add_ajax_comment'); // wp_ajax_{значение параметра action}
add_action('wp_ajax_nopriv_ajaxcomments', 'true_add_ajax_comment'); // wp_ajax_nopriv_{значение параметра action}