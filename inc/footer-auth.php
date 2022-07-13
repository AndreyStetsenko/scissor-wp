<?php if ( !is_user_logged_in() && !is_page('login') && !is_page('register') ) : ?>
    <div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formModalLogin" data-type="authorization" data-auth="auth" name="form" action="<?php echo home_url(); ?>/login/" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLoginLabel">Авторизация</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="alert" style="display: none"></div>

                        <div class="form-lots">
                            <div class="form-floating mb-2">
                                <input type="username" class="form-control" id="username" name="username" placeholder="Логин" required>
                                <label for="username">Логин</label>
                            </div>

                            <div class="form-floating">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Пароль" required>
                                <label for="password">Пароль</label>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalRegister">Регистрация</button>
                        <button type="submit" class="btn btn-black">Авторизация</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Register -->
    <div class="modal fade" id="modalRegister" tabindex="-1" aria-labelledby="modalRegisterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formModalRegister" data-type="registration" data-auth="auth" name="form" action="<?php echo home_url(); ?>/register/" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRegisterLabel">Регистрация</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="alert" style="display: none"></div>

                        <div class="form-lots">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" name="username" placeholder="Логин" required>
                                <label for="username">Имя пользователя</label>
                            </div>

                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" name="email" placeholder="Email" required>
                                <label for="email">Email</label>
                            </div>

                            <div class="form-floating mb-2">
                                <input type="password" class="form-control" name="password" placeholder="Пароль" required>
                                <label for="password">Пароль</label>
                            </div>

                            <div class="form-floating">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Пароль" required>
                                <label for="password_confirmation">Повторите пароль</label>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalLogin">Авторизация</button>
                        <button type="submit" class="btn btn-black">Регистрация</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>