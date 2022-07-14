<?php

/*
 * Добавляем шорткод, его можно использовать в содержимом любой статьи или страницы, вставив [misha_custom_login]
 */
add_shortcode( 'misha_custom_login', 'misha_render_login' );
 
function misha_render_login() {
 
	// проверяем, если пользователь уже авторизован, то выводим соответствующее сообщение и ссылку "Выйти"
	if ( is_user_logged_in() ) {
		return sprintf( "Вы уже авторизованы на сайте. <a href='%s'>Выйти</a>.", wp_logout_url() );
	}
 
	// присваиваем содержимое формы переменной и затем возвращаем её, выводить через echo() мы не можем, так как это шорткод
	$return = '<div class="login-form-container"><h2>Войти на сайт</h2>';
 
	// если возникли какие-либо ошибки, отображаем их
	if ( isset( $_REQUEST['errno'] ) ) {
		$error_codes = explode( ',', $_REQUEST['errno'] );
 
		foreach ( $error_codes as $error_code ) {
			switch ( $error_code ) {
				case 'empty_username':
					$return .= '<p class="errno">Вы не забыли указать свой email/имя пользователя?</p>';
					break;
				case 'empty_password':
					$return .= '<p class="errno">Пожалуйста, введите пароль.</p>';
					break;
				case 'invalid_username':
					$return .= '<p class="errno">На сайте не найдено указанного пользователя.</p>';
					break;
				case 'incorrect_password':
					$return .= sprintf( "<p class='errno'>Неверный пароль. <a href='%s'>Забыли</a>?</p>", wp_lostpassword_url() );
					break;
				case 'confirm':
					$return .= '<p class="errno success">Инструкции по сбросу пароля отправлены на ваш email.</p>';
					break;
				case 'changed':
					$return .= '<p class="errno success">Пароль успешно изменён.</p>';
					break;
				case 'expiredkey':
				case 'invalidkey':
					$retun .= '<p class="errno">Недействительный ключ.</p>';
					break;
			}
		}
	}
 
	// используем wp_login_form() для вывода формы (но можете сделать это и на чистом HTML)
	$return .= wp_login_form(
		array(
			'echo' => false, // не выводим, а возвращаем
			'redirect' => site_url('/account/'), // куда редиректить пользователя после входа
		)
	);
 
	$return .= '<a class="forgot-password" href="' . wp_lostpassword_url() . '">Забыли пароль</a></div>';
 
	// и наконец возвращаем всё, что получилось
	return $return;
 
}

/*
 * Редиректы обратно на кастомную форму входа в случае ошибки
 */
add_filter( 'authenticate', 'misha_redirect_at_authenticate', 101, 3 );
 
function misha_redirect_at_authenticate( $user, $username, $password ) {
 
	if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
		if ( is_wp_error( $user ) ) {
			$error_codes = join( ',', $user->get_error_codes() );
 
			$login_url = home_url( '/login/' );
			$login_url = add_query_arg( 'errno', $error_codes, $login_url );
 
			wp_redirect( $login_url );
			exit;
		}
	}
 
	return $user;
}
 
/*
 * Редиректы после выхода с сайта
 */
add_action( 'wp_logout', 'misha_logout_redirect', 5 );
 
function misha_logout_redirect(){
	wp_safe_redirect( site_url( '/login/?logged_out=true' ) );
	exit;
}