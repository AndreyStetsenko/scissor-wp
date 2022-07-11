<?php
/*
Template Name: Register
*/
 
require_once(ABSPATH . WPINC . '/registration.php');

global $wpdb, $user_ID;

// Проверяем, вошел ли уже пользователь в систему
if ($user_ID) {

   //Залогиненного пользователя перенаправляем на главную страницу.
   header( 'Location:' . home_url() );
} else {
	$errors = array();
 
	if( $_POST ) {
 
		// Убедитесь, что имя пользователя присутствует и еще не используется
		$username = $wpdb->escape($_REQUEST['username']);
		if ( strpos($username, ' ') !== false ) { 
		    $errors['username'] = "Извините, в именах пользователей нельзя использовать пробелы";
		}

        // если поле с именем пользователя пустое
		if(empty($username)) { 
			$errors['username'] = "Пожалуйста введите имя пользователя";
		} elseif ( username_exists( $username ) ) {

            // если такой пользователь уже зарегистрирован
			$errors['username'] = "Имя пользователя уже существует, попробуйте другое";
		}
 
		// Проверяем, есть ли email и действителен ли он
		$email = $wpdb->escape($_REQUEST['email']);

		if ( !is_email( $email ) ) { 
			$errors['email'] = "Пожалуйста, введите действительный email";
		} elseif( email_exists( $email ) ) {
			$errors['email'] = "Такой email уже зарегистрирован";
		}
 
		// Проверка пароля на валидность
		if (0 === preg_match("/.{6,}/", $_POST['password'])){
		  $errors['password'] = "Пароль должен состоять не менее, чем из шести символов.";
		}
 
		// Проверка повторного ввода пароля
		if (0 !== strcmp($_POST['password'], $_POST['password_confirmation'])){
		  $errors['password_confirmation'] = "Пароли не совпадают";
		}
 
		// Проверить согласие с условиями обслуживания 
		if ($_POST['terms'] != "Yes"){
			$errors['terms'] = "Вы должны согласиться с Условиями использования";
		}
        
        // если ошибок нет
		if (0 === count($errors)) {
 
			$password = $_POST['password'];
 
			$new_user_id = wp_create_user( $username, $password, $email );
 
			// Здесь вы можете делать все, что угодно, например, отправлять электронное письмо пользователю и т. д. 
 
			$success = 1;
 
			header( 'Location:' . get_bloginfo('url') . '/login/?success=1&u=' . $username );
 
		} else {
			$message = '<div class="alert alert-danger">Есть ошибки в заполнении формы</div>';
		}
	}
}
?>

<?php get_header(); ?>

<main class="form-signin w-100 m-auto mt-5">

    <div id="message"><?= isset( $message ) ? $message  : '' ?></div>

    <form id="wp_signup_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
        <h1 class="h3 mb-3 fw-normal">Регистрация</h1>

        <div class="form-lots">
            <div class="form-floating <?= isset( $errors['username'] ) ? 'error'  : '' ?>">
                <input type="text" class="form-control" id="username" name="username" placeholder="Логин" value="<?= isset( $_REQUEST['username'] ) ? $_REQUEST['username']  : '' ?>">
                <label for="username">Имя пользователя</label>
                <!-- <span class="error"><?= isset( $errors['username'] ) ? $errors['username']  : '' ?></span> -->
            </div>

            <div class="form-floating <?= isset( $errors['email'] ) ? 'error'  : '' ?>">
                <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?= isset( $_REQUEST['email'] ) ? $_REQUEST['email']  : '' ?>">
                <label for="email">Email</label>
                <!-- <span class="error"><?= isset( $errors['email'] ) ? $errors['email']  : '' ?></span> -->
            </div>

            <div class="form-floating <?= isset( $errors['password'] ) ? 'error'  : '' ?>">
                <input type="password" class="form-control" id="password" name="password" placeholder="Пароль" value="<?= isset( $_REQUEST['password'] ) ? $_REQUEST['password']  : '' ?>">
                <label for="password">Пароль</label>
                <!-- <span class="error"><?= isset( $errors['password'] ) ? $errors['password']  : '' ?></span> -->
            </div>

            <div class="form-floating <?= isset( $errors['password_confirmation'] ) ? 'error'  : '' ?>">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Пароль" value="<?= isset( $_REQUEST['password_confirmation'] ) ? $_REQUEST['password_confirmation']  : '' ?>">
                <label for="password_confirmation">Повторите пароль</label>
                <!-- <span class="error"><?= isset( $errors['password_confirmation'] ) ? $errors['password_confirmation']  : '' ?></span> -->
            </div>
        </div>

        <div class="checkbox mb-3">
            <label>
                <input name="terms" id="terms" type="checkbox" value="Yes">
                Я согласен(-на) с условиями предоставления услуг
            </label>
            <!-- <span class="error"><?= isset( $errors['terms'] ) ? $errors['terms']  : '' ?></span>  -->
        </div>

        <button class="w-100 btn btn-black" id="submit" name="submit" type="submit">Регистрация</button>
    </form>

    <div class="d-flex justify-content-between mt-3">
        <a href="<?= home_url(); ?>/lost-password">Забыли пароль</a>
        <a href="<?= home_url(); ?>/login">Авторизация</a>
    </div>
</main>

<?php
get_footer();