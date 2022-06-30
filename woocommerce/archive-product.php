<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>

<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
<div class="wrapper-title black inner">
    <div class="container">
        <h1 class="article-level-1"><?php woocommerce_page_title(); ?></h1>
    </div>
</div>
<?php endif; ?>

<div class="ppage-head mb-2">
	<div class="container">
		<?php
		/**
		 * Hook: woocommerce_before_main_content.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 * @hooked WC_Structured_Data::generate_website_data() - 30
		 */
		do_action( 'woocommerce_before_main_content' );
		?>
	</div>
</div>

<div class="ppage-head">
	<header class="woocommerce-products-header">
		<div class="container">	

			<?php
			/**
			 * Hook: woocommerce_archive_description.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
			?>
		</div>
	</header>
</div>

<?php if ( woocommerce_product_loop() ) : ?>

<div class="container">
	<?php
	/**
		 * Hook: woocommerce_before_shop_loop.
		 *
		 * @hooked woocommerce_output_all_notices - 10
		 * @hooked woocommerce_result_count - 20
		 * @hooked woocommerce_catalog_ordering - 30
		 */
		do_action( 'woocommerce_before_shop_loop' );
	?>
</div>

<section class="products-list-min">

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

<div class="container">
<?php

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
else :
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
endif;

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' ); ?>
</div>
<?php
get_footer( 'shop' );
