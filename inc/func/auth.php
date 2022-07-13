<?php

// Создаём событие обработки Ajax в WordPress теме.
add_action( 'wp_ajax_nopriv_wplb_ajax_request', 'wplb_ajax_request' );
add_action( 'wp_ajax_wplb_ajax_request', 'wplb_ajax_request' );

// Описываем саму функцию.
function wplb_ajax_request() {

    // $result[ 'status' ] = false;
    // echo json_encode( $_REQUEST );

    // Перемененная $_REQUEST содержит все данные заполненных форм.
    if ( isset( $_REQUEST ) ) {

        // Проверяем nonce, а в случае если что-то пошло не так, то прерываем выполнение функции.
        if ( !wp_verify_nonce( $_REQUEST[ 'security' ], 'wplb-nonce' ) ) {
            wp_die( 'Базовая защита не пройдена' );
        }

        // Введём переменную, которая будет содержать массив с результатом отработки события.
        $result = array( 'status' => false, 'content' => false );
        
        // Создаём массив который содержит значения полей заполненной формы.
        // parse_str( $_REQUEST[ 'content' ], $creds );
        
        switch ( $_REQUEST[ 'type' ] ) {
            case 'registration':
                /**
                 * Заполнена форма регистрации.
                 */
                // Пробуем создать объект с пользователем.
                $username = username_exists( $_POST['content']['username'] );
                $email = email_exists( $_POST['content']['email'] );
                // Проверяем, а может быть уже есть такой пользователь
                if ( $username == false && $email == false ) {
                    // Пользователя не существует.
                    // Создаём массив с данными для регистрации нового пользователя.
                    $user_data = array(
                        'user_login' => $_POST['content']['username'], // Логин.
                        'user_email' => $_POST['content']['email'], // Email.
                        'user_pass' => $_POST['content']['password'], // Пароль.
                        'display_name' => $_POST['content']['username'], // Отображаемое имя.
                        'role' => 'subscriber' // Роль.
                    );
                    // Добавляем пользователя в базу данных.
                    $user = wp_insert_user( $user_data );
                    // Проверка на ошибки.
                    if ( is_wp_error( $user ) ) {
                        // Невозможно создать пользователя, записываем результат в массив.
                        $result[ 'status' ] = false;
                        $result[ 'content' ] = $user->get_error_message();
                    } else {
                        // Создаём массив для авторизации.
                        $creds = array(
                            'user_login' => $_POST['content']['username'], // Логин пользователя.
                            'user_password' => $_POST['content']['password'], // Пароль пользователя.
                            'remember' => true // Запоминаем.
                        );
                        // Пробуем авторизовать пользователя.
                        $signon = wp_signon( $creds, false );
                        if ( is_wp_error( $signon ) ) {
                            // Авторизовать не получилось.
                            $result[ 'status' ] = false;
                            $result[ 'content' ] = $signon->get_error_message();
                        } else {
                            // Авторизация успешна, устанавливаем необходимые куки.
                            wp_clear_auth_cookie();
                            clean_user_cache( $signon->ID );
                            wp_set_current_user( $signon->ID );
                            wp_set_auth_cookie( $signon->ID );
                            update_user_caches( $signon );
                            // Записываем результаты в массив.
                            $result[ 'status' ] = true;
                        }
                    }
                } else {
                    
                    // Такой пользователь уже существует, регистрация не возможна, записываем данные в массив.
                    $result[ 'status' ] = false;
                    $result[ 'content' ] = esc_html__( 'Пользователь уже существует', 'wplb_ajax_lesson' );
                }
                break;
            case 'authorization':
                /**
                 * Заполнена форма авторизации.
                 */
            
                // Создаём массив для авторизации
                $creds = array(
                    'user_login' => $_POST['content']['username'], // Логин пользователя
                    'user_password' => $_POST['content']['password'], // Пароль пользователя
                    'remember' => true // Запоминаем
                );
            
                // Пробуем авторизовать пользователя.
                $signon = wp_signon( $creds, false );
            
                if ( is_wp_error( $signon ) ) {
            
                    // Авторизовать не получилось
                    $result[ 'status' ] = false;
                    $result[ 'content' ] = $signon->get_error_message();
            
                } else {
            
                    // Авторизация успешна, устанавливаем необходимые куки.
                    wp_clear_auth_cookie();
                    clean_user_cache( $signon->ID );
                    wp_set_current_user( $signon->ID );
                    wp_set_auth_cookie( $signon->ID );
                    update_user_caches( $signon );
            
                    // Записываем результаты в массив.
                    $result[ 'status' ] = true;
                }
            
            break;
        }

        // Конвертируем массив с результатами обработки и передаем его обратно как строку в JSON формате.
        echo json_encode( $result );

    }

    // Заканчиваем работу Ajax.
    wp_die();
}