<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<section class="ppage">
		<div class="ppage-cont">
				<div class="container">
						<div class="row">
								<div class="col-md-6">

										<?php
										/**
										 * Hook: woocommerce_before_single_product_summary.
										 *
										 * @hooked woocommerce_show_product_sale_flash - 10
										 * @hooked woocommerce_show_product_images - 20
										 */
										do_action( 'woocommerce_before_single_product_summary' );
										?>

								</div>
								<div class="col-md-6">
										<div class="ppage-info">
												
												<?php if (get_field( 'product_subtitle' )) : ?>
												<h1 class="info-title"><?= the_field( 'product_subtitle' ); ?></h1>
												<?php endif; ?>
												<h3 class="info-subtitle"><?php the_title(); ?></h3>

												<div class="info-rate">
 
														<?php wc_get_template( 'single-product/rating.php' ); ?>
														
												</div>

												<div class="tab-content" id="nav-tabContent">
														<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">

																<div class="info-cont">
																		<?php the_content(); ?>
																</div>

																<?php
																$rows = get_field('product_description_pictures');
																if( $rows ) {
																		echo '<div class="info-advantages">';
																		foreach( $rows as $row ) {
																				$image = $row['img'];
																				echo '<div class="item">';
																						echo '<div class="item-icon">';
																						echo '<img src="' . $image . '" alt="">';
																						echo '</div>';
																						echo '<div class="item-title">';
																						echo $row['title'];
																						echo '</div>';
																				echo '</div>';
																		}
																		echo '</div>';
																}
																?>

														</div>
														<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
																<div class="info-cont">
																		<p>
																				<?= the_field( 'product_instruction' ); ?>
																		</p>
																</div>
														</div>
														<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
																<div class="info-cont">
																		<p>
																				<?= the_field( 'product_ingridients' ); ?>
																		</p>
																</div>
														</div>
														<div class="tab-pane fade" id="nav-bio" role="tabpanel" aria-labelledby="nav-bio-tab" tabindex="0">
																<div class="info-cont">
																		<p>
																				<?= the_field( 'product_bio' ); ?>
																		</p>
																</div>
														</div>
												</div>

												<nav>
														<div class="nav nav-tabs info-tabs" id="nav-tab" role="tablist">
																<button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Описание</button>
																<?php if (get_field( 'product_instruction' )) : ?>
																<button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Инструкция</button>
																<?php endif; ?>
																<?php if (get_field( 'product_ingridients' )) : ?>
																<button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Ингридиенты</button>
																<?php endif; ?>
																<?php if (get_field( 'product_bio' )) : ?>
																<button class="nav-link" id="nav-bio-tab" data-bs-toggle="tab" data-bs-target="#nav-bio" type="button" role="tab" aria-controls="nav-bio" aria-selected="false">Био</button>
																<?php endif; ?>
														</div>
												</nav>

												<?php do_action( 'woocommerce_single_product_summary' ); ?>

										</div>
								</div>
						</div>
				</div>
		</div>
</section>

<?php 
// woocommerce_cross_sell_display() 

if ( !function_exists( 'woocommerce_cross_sell_display' ) ) { 
	require_once '/library/woo-config.php'; 
} 

// The posts per page. 
$posts_per_page = 3; 

// The columns. 
$columns = 3; 

// The orderby. 
$orderby = 'rand'; 

// NOTICE! Understand what this does before running. 
$result = woocommerce_cross_sell_display($posts_per_page, $columns, $orderby);

?>