<?php

/**
 * Template Name: Contacts
 */

get_header();
?>

<div class="wrapper-title black inner">
    <div class="container">
        <h1 class="article-level-1"><?= the_title() ?></h1>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <div class="col-md-7">
            <p>
                СВЯЖИТЕСЬ С НАМИ<br>
            </p>
            <p>
                ЕСЛИ ВАМ НЕОБХОДИМО СВЯЗАТЬСЯ С НАМИ, ПОЖАЛУЙСТА, СВЯЖИТЕСЬ С НАШИМ ОТДЕЛОМ ОБСЛУЖИВАНИЯ КЛИЕНТОВ СЛЕДУЮЩИМИ СПОСОБАМИ.
            </p>
            <div class="socials-large mb-3">
                <a class="item" href="#" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                <a class="item" href="#" target="_blank"><i class="fa-brands fa-instagram"></i></a>
            </div>
            <p>
                АДРЕСС<br>
                УЛИЦА ЕВРОПЕЙСКАЯ 72А<br>
                КРЕМЕНЧУГ<br>
                ПОЛТАВСКАЯ ОБЛАСТЬУКРАИНА39601
            </p>
            <p>
                EMAIL<br>
                SCISSORHANDSTM@GMAIL.COM
            </p>
            <p>
                PHONE<br>
                +380689214865
            </p>
            <p>
                ЕСЛИ ВАС ИНТЕРЕСУЕТ НАША ПОЛИТИКА ВОЗВРАТА, НАЖМИТЕ ЗДЕСЬ. 
            </p>
        </div>
        <div class="col-md-5">
            <div class="form-feedback">
                <span class="title">Отправить нам письмо</span>

                <form action="">
                    <div class="mb-3">
                        <label for="name" class="form-label">Имя</label>
                        <input type="text" class="form-control" id="name">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Почта</label>
                        <input type="text" class="form-control" id="email">
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Сообщение</label>
                        <textarea type="text" class="form-control" id="message" rows="5"></textarea>
                    </div>

                    <button class="btn btn-black">Отправить</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
