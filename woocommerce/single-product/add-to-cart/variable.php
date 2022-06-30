<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 6.1.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>
	<?php else : ?>
		<div class="info-params">
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>
							<div class="p-inp">
								<label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>" class="label"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></label>
							<?php
								if( count($available_variations) > 0 ){

									$output = '<div class="p-inp-group">';
							
									foreach( $available_variations as $variation ){
											$option_value = array();
							
											foreach( $variation['attributes'] as $attribute => $term_slug ){
													$taxonomy = str_replace( 'attribute_', '', $attribute );
													$attribute_name = get_taxonomy( $taxonomy )->labels->singular_name; // Attribute name
													$term_name = get_term_by( 'slug', $term_slug, $taxonomy )->name; // Attribute value term name
							
													$option_value[] = $term_name;
											}
											$option_value = implode( ' | ', $option_value );
							
											$output .= '<div class="item">';
											$output .= '<input type="radio" name="mas" value="'.$option_value.'" id="'.$variation['variation_id'].'">';
											$output .= '<label class="variable_inp" data-price="' . $variation['display_price'] . '" data-id="'.$variation['attributes']['attribute_pa_volume'].'" for="'.$variation['variation_id'].'">'.$option_value.'</label>';
											$output .= '</div>';
											// var_dump($variation);
							
									}
									$output .= '
											</div>';
							
									echo $output;
								}

								echo '</div>';
							?>
				<?php endforeach; ?>

				<?php
				/**
				 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
				 *
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );
				?>

				<div class="p-inp">
						<label for="price" class="label">Цена</label>

						<input data-input="price" type="text" name="price" id="price" value="<?php echo $product->get_price(); ?>" disabled>
				</div>

<table class="variations d-none" cellspacing="0">
			<tbody>
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>
					<tr>
						<th class="label"><label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></label></th>
						<td class="value">
							<?php
								wc_dropdown_variation_attribute_options(
									array(
										'options'   => $options,
										'attribute' => $attribute_name,
										'product'   => $product,
									)
								);
								echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';
							?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

				</div>
		<?php do_action( 'woocommerce_after_variations_table' ); ?>

		<div class="info-actions">
			<button type="submit" class="single_add_to_cart_button btn btn-black"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

			<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

			<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
			<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
			<input type="hidden" name="variation_id" class="variation_id" value="0" />
		</div>

			<?php
				/**
				 * Hook: woocommerce_before_single_variation.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * Hook: woocommerce_after_single_variation.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
	<?php endif; ?>
	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
