<?php 
/*
Template Name: Login
*/
 
if ($_POST) {
 
	global $wpdb;
 
	// Проверяем все поля ввода перед запросом SQL
	$username = $wpdb->escape($_REQUEST['username']);
	$password = $wpdb->escape($_REQUEST['password']);
	$remember = $wpdb->escape($_REQUEST['rememberme']);
 
	if($remember) $remember = "true";
	else $remember = "false";
 
	$login_data = array();
	$login_data['user_login'] = $username;
	$login_data['user_password'] = $password;
	$login_data['remember'] = $remember;
 
	$user_verify = wp_signon( $login_data, false ); 
 
	if ( is_wp_error($user_verify) ){

	   // Передаем параметр error для использования его потом в скрипте
	   header("Location: " . home_url() . "/login?error=true");        
	 } else {	
	   echo "<script>window.location='". home_url() ."'</script>";
	   exit();
	 }
 
}

get_header();
?>
<main class="form-signin w-100 m-auto mt-5">

    <div class="alert alert-danger" id="message" style="display: none;"></div>

    <form id="login" name="form" action="<?php echo home_url(); ?>/login/" method="post">
        <h1 class="h3 mb-3 fw-normal">Авторизация</h1>

        <div class="form-lots">
            <div class="form-floating">
                <input type="username" class="form-control" id="username" name="username" placeholder="Логин">
                <label for="username">Логин</label>
            </div>

            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Пароль">
                <label for="password">Пароль</label>
            </div>
        </div>

        <!-- <div class="checkbox mb-3">
        <label>
            <input type="checkbox" value="remember-me"> Remember me
        </label>
        </div> -->
        <button class="w-100 btn btn-black" id="submit" name="submit" type="submit">Авторизация</button>
    </form>

    <div class="d-flex justify-content-between mt-3">
        <a href="<?= home_url(); ?>/lost-password">Забыли пароль</a>
        <a href="<?= home_url(); ?>/register">Регистрация</a>
    </div>
</main>

<script>
  let message = document.getElementById('message');
  
  if(location.search.indexOf('error')>-1){	
	message.innerHTML='Неверные учетные данные';
	message.innerHTML+='<br>Введите заново или перейдите на страницу <a href="<?php echo home_url(); ?>/register">регистрации</a>';
    message.style.display = 'block';
  }
</script>

<?php
get_footer();