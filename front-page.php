<?php

/**
 * Template Name: Home
 */

get_header();
?>

<?php
if( have_rows('page_home_top_banner') ):
    while( have_rows('page_home_top_banner') ) : the_row(); 

    $text = get_sub_field('text');
    $img_src = get_sub_field('img');
    ?>

    <div class="banner-head img-parallax" data-speed="-1" style="background-image: url(<?= $img_src ?>)">
        <div class="container">
            <div class="banner-head-contain">
                <h2 class="banner-head-title"><?= $text ?></h2>
            </div>
        </div>
    </div>

    <?php
    endwhile;
endif;
?>

<?php if( have_rows('home_sales') ): ?>
    <?php while( have_rows('home_sales') ) : the_row(); ?>
    <?php
    $title = get_sub_field('title');
    $subtitle = get_sub_field('subtitle');
    $img_src = get_sub_field('img');
    ?>
    <div class="complect-save">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="complect-save-cont">
                        <h2 class="title"><?= $title ?></h2>
                        <span class="caption"><?= $subtitle ?></span>
                        <div class="link">
                            <a href="#" class="btn btn-black">Подробно</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="complect-save-img">
                        <img src="<?= $img_src ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
<?php endif; ?>

<?php $images_with_text_title = get_field('images_with_text_title') ?>
<?php if ( $images_with_text_title ) : ?>
<div class="wrapper-title black">
    <div class="container">
        <h2 class="article-level-1"><?= $images_with_text_title ?></h2>
    </div>
</div>
<?php endif; ?>

<section class="banner-like">
    <div class="items">
    <?php
    if( have_rows('images_with_text') ):
        while( have_rows('images_with_text') ) : the_row(); 

        $text = get_sub_field('text');
        $img_src = get_sub_field('img');
        ?>
        <div class="item" style="background-image: url(<?= $img_src ?>)">
            <span class="item-title"><?= $text ?></span>
        </div>
        <?php
    endwhile;
endif;
?>
    </div>
</section>

<section class="products-list-min">
    <?php $home_top_products_title = get_field('home_top_products_title') ?>
    <?php if ( $home_top_products_title ) : ?>
    <h2 class="products-list-min-title article-level-1">
        <span class="ico-promo-star mx-2"></span>
        <?= $home_top_products_title ?>
        <span class="ico-promo-star mx-2"></span>
    </h2>
    <?php endif; ?>

    <?php

    $home_top_products = get_field('home_top_products');

    if( $home_top_products ): ?>
    <div class="wrapper">
        <div class="container">
            <div class="row items">
            <?php foreach( $home_top_products as $post): // Переменная должна быть названа обязательно $post (IMPORTANT) ?>
                <?php setup_postdata($post); 
                $item = get_post_meta( $post->ID ); 
                $product = wc_get_product( $post->ID );

                $price = $product->get_price_html();
                $sku = $product->get_sku();
                $stock = $product->get_stock_quantity(); 
                $title = $product->get_name(); 
                $reviews = $product->get_review_count(); 
                $rating_count = $product->get_rating_count();
                $average = $product->get_average_rating();
                $img = $product->get_image();
                $link = $product->get_permalink();
                // var_dump($item);
                ?>
                <div class="col-md-4 product-first item">
                    <a href="<?php the_permalink(); ?>" class="item-img">
                        <?= $img ?>
                    </a>
                    <div class="item-body">
                        <h4 class="item-title"><?php the_title(); ?></h4>
                        <div class="item-reviews">
                            <div class="stars">
                                <?php echo wc_get_rating_html( $average ); // WPCS: XSS ok. ?>
                            </div>
                            <span class="item-reviews-title"><?= $reviews ?> reviews</span>
                        </div>
                        <span class="item-price"><?= $price; ?></span>
                        <div class="item-btn mt-2">
                            <a href="<?= $link ?>" class="btn btn-black">Добавить в коризну</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
        <?php wp_reset_postdata(); // ВАЖНО - сбросьте значение $post object чтобы избежать ошибок в дальнейшем коде ?>
    <?php endif; ?>
</section>

<?php if( have_rows('hands_banner_products') ): ?>
    <?php while( have_rows('hands_banner_products') ) : the_row(); ?>
    <?php
    $link = get_sub_field('link');
    $img_src = get_sub_field('img');
    ?>
    <section class="hands-product">
        <a href="<?= $link ?>" class="hands-product-img">
            <img src="<?= $img_src ?>" alt="">
        </a>
    </section>
    <?php endwhile; ?>
<?php endif; ?>

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

<?php if( have_rows('home_mission') ): ?>
    <?php while( have_rows('home_mission') ) : the_row(); ?>
    <?php
    $title = get_sub_field('title');
    $content = get_sub_field('content');
    $img_src = get_sub_field('img');
    ?>
    <section class="banner-mission">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="title"><?= $title ?></h2>

                    <p class="content">
                        <?= $content ?>
                    </p>

                    <?php if ( have_rows('button') ) : ?>
                        <?php while ( have_rows('button') ) : the_row(); ?>
                        <div class="banner-mission-link">
                            <a href="<?= get_sub_field('link') ?>" class="btn btn-black"><?= get_sub_field('name') ?></a>
                        </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <div class="logo">
                        <img src="<?= $img_src ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endwhile; ?>
<?php endif; ?>

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
