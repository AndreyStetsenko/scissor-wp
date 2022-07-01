<?php

/**
 * Template Name: Home
 */

get_header();

$page_home_top_banner = get_field('page_home_top_banner');
?>

<div class="banner-head img-parallax" data-speed="-1" style="background-image: url(<?= getMedia('/images/shamp1.png') ?>)">
    <div class="container">
        <div class="banner-head-contain">
            <h2 class="banner-head-title">New shampoo Rocket</h2>
        </div>
    </div>
</div>

<div class="complect-save">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="complect-save-cont">
                    <h2 class="title">Save 20%</h2>
                    <span class="caption">комплекты</span>
                    <div class="link">
                        <a href="#" class="btn btn-black">Подробно</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="complect-save-img">
                    <img src="<?= getMedia('/images/aboutus.png') ?>" alt="">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper-title black">
    <div class="container">
        <h2 class="article-level-1">За что нас любят?</h2>
    </div>
</div>

<section class="banner-like">
    <div class="items">
        <div class="item" style="background-image: url(<?= getMedia('/images/распаковка.png') ?>)">
            <span class="item-title">Невероятная распаковка</span>
        </div>
        <div class="item" style="background-image: url(<?= getMedia('/images/аромат.png') ?>)">
            <span class="item-title">Екстримальные ароматы</span>
        </div>
        <div class="item" style="background-image: url(<?= getMedia('/images/фото.png') ?>)">
            <span class="item-title">Новый стиль - новая жизнь</span>
        </div>
        <div class="item" style="background-image: url(<?= getMedia('/images/вселенная.png') ?>)">
            <span class="item-title">Большой выбор</span>
        </div>
    </div>
</section>

<section class="products-list-min">
    <h2 class="products-list-min-title article-level-1">
        <span class="ico-promo-star mx-2"></span>
        Best Sellers
        <span class="ico-promo-star mx-2"></span>
    </h2>

    <div class="wrapper">
        <div class="container">
            <div class="row items">

            <?php

            $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => 6,
                'meta_key' => 'total_sales',
                'orderby' => 'meta_value_num',
            );

            $loop = new WP_Query( $args );
            if ( $loop->have_posts() ): while ( $loop->have_posts() ): $loop->the_post();

                global $product;

                $price = $product->get_price_html();
                $sku = $product->get_sku();
                $stock = $product->get_stock_quantity(); 
                $title = $product->get_name(); 
                $reviews = $product->get_review_count(); 
                $rating_count = $product->get_rating_count();
                $average = $product->get_average_rating();
                $img = $product->get_image();
                $link = $product->get_permalink();
                ?>
                
                <div class="col-md-4 product-first item">
                        <a href="<?= $link ?>" class="item-img">
                                <?= $img ?>
                        </a>
                        <div class="item-body">
                                <h4 class="item-title"><?= $title ?></h4>
                                <div class="item-reviews">
                                    <div class="stars">
                                            <?php echo wc_get_rating_html( $average, $rating_count ); // WPCS: XSS ok. ?>
                                    </div>
                                        <span class="item-reviews-title"><?= $reviews ?> reviews</span>
                                </div>
                                <span class="item-price"><?= $price ?></span>
                                <div class="item-btn mt-2">
                                        <a href="<?= $link ?>" class="btn btn-black">Добавить в коризну</a>
                                </div>
                        </div>
                </div>

            <?php endwhile; endif; wp_reset_postdata();
            ?>

            </div>
        </div>
    </div>
</section>

<div class="wrapper-title black">
    <div class="container">
        <h2 class="article-level-1">Scissor hands product</h2>
    </div>
</div>

<section class="hands-product">
    <div class="container">
        <div class="hands-product-img">
            <img src="<?= getMedia('/images/allproduct 1.png') ?>" alt="">
        </div>
    </div>
</section>

<div class="wrapper-title black">
    <div class="container">
        <h2 class="article-level-1">Категории</h2>
    </div>
</div>

<section class="home-categories">
    <div class="home-categories-wrap">
        <div class="container">
            <div class="home-categories-cont">
                <div class="item">
                    <div class="item-img">
                        <a href="#">
                            <img src="<?= getMedia('/images/Untitled-8.png') ?>" alt="">
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="item-img">
                        <a href="#">
                            <img src="<?= getMedia('/images/Untitled-7.png') ?>" alt="">
                        </a>
                    </div>
                </div>
                <div class="item">
                    <div class="item-img">
                        <a href="#">
                            <img src="<?= getMedia('/images/Untitled-6.png') ?>" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="banner-mission">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2 class="title">Mission</h2>

                <p class="content">
                    Рождённый и развивающийся в период войны бренд Scissor hands является носителем уникального опыта. Он несет в себе темную глубинную энергию,которая конвертирована в наши продукты. Scissor Hands это энергичный бренд в мире мужского груминга, созданный экстремальными людьми целью которых создание продуктов рассказывающие истории впитанные из вне и передающие сопутствующий этой истории стиль и силу. Наша цель поднять вас на новую ступень эволюции и оставить яркий след в вашей жизни до ее конца.
                </p>

                <div class="banner-mission-link">
                    <a href="#" class="btn btn-black">Подробно</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="logo">
                    <img src="<?= getMedia('/images/logo-scissor.png') ?>" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="insta-posts">
    <div class="container">
        <span class="insta-posts-title">Follow us on instagram #scissorhandstm</span>

        <div class="insta-posts-contain">

        <?php
        getInstaPosts(6, 'IGQVJYX2dsaEhqZA0dhbnczVE5iYjUtSFhkc0lLUFFiOHRBNF91cnVCMUNUZAXp0dDE2ZAmZAMRFlQVGotcnFvVDc2Rm45dXNYUFpvZAWNhNFlaRFBHR0JkMXNMeGtPMHJ4RS1Nd1ZAHYTlkeTlVRjJJYXNTLQZDZD');
        ?>

        </div>
    </div>
</section>

<?php
get_footer();
