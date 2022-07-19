<?php

/**
 * Template Name: Cooperation
 */

get_header();
?>

<div class="wrapper-title black inner mb-0">
    <div class="container">
        <h1 class="article-level-1"><?= the_title() ?></h1>
    </div>
</div>

<?php if ( have_rows('cooperation-banner') ) : ?>
<div class="cooperation-banner">
    <div class="container">
        <div class="cooperation-banner-cont">
            <?php while ( have_rows('cooperation-banner') ) : the_row(); ?>
            <?php
            $img_main = get_sub_field('img_main');
            $img_side = get_sub_field('img_side');
            ?>
            <div class="item">
                <div class="item-img">
                    <div class="item-left">
                    <img src="<?= $img_side['sizes']['medium_large'] ?>" alt="">
                    </div>

                    <img src="<?= $img_main['sizes']['medium_large'] ?>" alt="">

                    <div class="item-right">
                    <img src="<?= $img_side['sizes']['medium_large'] ?>" alt="">
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="container">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="content fs-3 mt-5 pt-2 mb-5">
                <?php the_content() ?>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>

<div class="cooperation-opt">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>

            <div class="col-md-10">
                <div class="cooperation-opt-cont">

                    <h3 class="title">ПОДАТЬ ЗАЯВКУ НА ОПТОВЫЙ СЧЕТ</h3>

                    <div class="cooperation-form">
                        <form>
                            <div class="row">

                                <div class="col-md-5">
                                    <div class="p-inp">
                                        <label class="label" name="login" for="">Login</label>
                                        <input type="text">
                                    </div>
                                </div>

                                <div class="col-md-2"></div>

                                <div class="col-md-5">
                                    <div class="p-inp">
                                        <label class="label" name="company" for="">Название компании</label>
                                        <input type="text">
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="p-inp">
                                        <label class="label" name="name" for="">Имя</label>
                                        <input type="text">
                                    </div>
                                </div>

                                <div class="col-md-2"></div>

                                <div class="col-md-5">
                                    <div class="p-inp">
                                        <label class="label" name="address" for="">Адрес</label>
                                        <input type="text">
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="p-inp">
                                        <label class="label" name="lastname" for="">Фамилия</label>
                                        <input type="text">
                                    </div>
                                </div>

                                <div class="col-md-2"></div>

                                <div class="col-md-5">
                                    <div class="p-inp">
                                        <label class="label" name="city" name="login" for="">Город</label>
                                        <input type="text">
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="p-inp">
                                        <label class="label" name="email" for="">Почта</label>
                                        <input type="text">
                                    </div>
                                </div>

                                <div class="col-md-2"></div>

                                <div class="col-md-5">
                                    <div class="p-inp">
                                        <label class="label" name="post" for="">Индекс</label>
                                        <input type="text">
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="p-inp">
                                        <label class="label" name="phone" for="">Телефон</label>
                                        <input type="text">
                                    </div>
                                </div>

                                <div class="col-md-2"></div>

                                <div class="col-md-5">
                                    <div class="p-inp">
                                        <label class="label" name="country" for="">Страна</label>
                                        <input type="text">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="button">
                                        <button class="btn btn-black" type="button">Подать заявку</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>

            <div class="col-md-1"></div>
        </div>
    </div>
</div>

<?php
get_footer();
