<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$attachment_ids 	 = $product->get_gallery_image_ids();
$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	)
);


?>

<div class="ppage-slider">

		<div class="swiper ppage-slider-main">
				<?php
				if ( $attachment_ids ) :
					echo '<div class="swiper-wrapper">';
					foreach ( $attachment_ids as $attachment_id ) {
							$full_src = wp_get_attachment_image_src( $attachment_id, 'full' );
							echo '<div class="swiper-slide">';
							echo "<img src='" . $full_src[0] . "'>";
							echo '</div>';
					}
					echo '</div>';
					
					echo '<div class="swiper-button-prev"><i class="fa fa-chevron-left"></i></div>';
					echo '<div class="swiper-button-next"><i class="fa fa-chevron-right"></i></div>';
				else :
					echo '<div class="swiper-wrapper">';
					$html  = '<div class="swiper-slide">';
					$html .= wc_get_gallery_image_html( $post_thumbnail_id, true );
					$html .= '</div>';
					echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
					echo '</div>';
				endif;
				?>	
		</div>

		<div class="swiper ppage-slider-thumbs">
				<div class="swiper-wrapper">
					<?php
					foreach ( $attachment_ids as $attachment_id ) {
							$full_src = wp_get_attachment_image_src( $attachment_id, 'full' );
							echo '<div class="swiper-slide">';
							echo "<img src='" . $full_src[0] . "'>";
							echo '</div>';
					}
					?>
				</div>
		</div>

</div>