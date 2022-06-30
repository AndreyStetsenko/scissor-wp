<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

defined( 'ABSPATH' ) || exit;

if ( $cross_sells ) : ?>

<section class="ppage-combination">
		<div class="wrapper">
				<div class="container">
						<div class="row items">

						<?php
						$heading = apply_filters( 'woocommerce_product_cross_sells_products_heading', __( 'You may be interested in&hellip;', 'woocommerce' ) );

						if ( $heading ) :
							?>
							<div class="col-12">
									<span class="ppage-combination--title"><?php echo esc_html( $heading ); ?></span>
							</div>
						<?php endif; ?>

						<?php woocommerce_product_loop_start(); ?>

							<?php foreach ( $cross_sells as $cross_sell ) : ?>

								<?php
									$post_object = get_post( $cross_sell->get_id() );

									setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

									wc_get_template_part( 'content', 'product' );
								?>

								<!-- <div class="col-md-4 product-first item">
										<a href="#" class="item-img">
												<img src="../assets/images/Barber.jpeg" alt="">
										</a>
										<div class="item-body">
												<h4 class="item-title">Light Hold Hair Pomade</h4>
												<div class="item-reviews">
														<div class="stars">
																<i class="fa-solid fa-star"></i>
																<i class="fa-solid fa-star"></i>
																<i class="fa-solid fa-star"></i>
																<i class="fa-regular fa-star"></i>
																<i class="fa-regular fa-star"></i>
														</div>
														<span class="item-reviews-title">129 reviews</span>
												</div>
												<span class="item-price">290 UAH</span>
												<div class="item-btn">
														<a href="#" class="btn btn-black">Добавить в коризну</a>
												</div>
										</div>
								</div> -->

							<?php endforeach; ?>

						<?php woocommerce_product_loop_end(); ?>

							</div>
					</div>
			</div>
	</section>
	<?php
endif;

wp_reset_postdata();
