<?php

// Вывод рейтинга в звездах в каталог
add_filter('woocommerce_product_get_rating_html', 'your_get_rating_html', 10, 2);

function your_get_rating_html($rating_html, $rating) {
	if ( $rating > 0 ) {
		$title = sprintf( __( 'Оценка %s из 5', 'woocommerce' ), $rating );
	} else {
		$title = 'Еще не оценено';
		$rating = 0;
	}
	$rating_html  = '<div class="star-rating" title="' . $title . '">';
	$rating_html .= '<span style="width:' . ( ( $rating / 5 ) * 100 ) . '%"><strong class="rating">' . $rating . '</strong> ' . __( 'из 5', 'woocommerce' ) . '</span>';
	$rating_html .= '</div>';
	return $rating_html;
}

add_filter( 'woocommerce_single_product_image_thumbnail_html', 'custom_remove_product_link' );
function custom_remove_product_link( $html ) {
  return strip_tags( $html, '<div><img>' );
}

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5); 
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10); 
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20); 
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10); 
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15); 

// Variable
add_filter('woocommerce_product_variation_get_regular_price', 'custom_price', 99, 2 );
add_filter('woocommerce_product_variation_get_price', 'custom_price' , 99, 2 );

// Variations (of a variable product)
add_filter('woocommerce_variation_prices_price', 'custom_variation_price', 99, 3 );
add_filter('woocommerce_variation_prices_regular_price', 'custom_variation_price', 99, 3 );

function custom_price( $price, $product ) {
    // Delete product cached price  (if needed)
    wc_delete_product_transients($product->get_id());

    return $price; // X3 for testing
}

function custom_variation_price( $price, $variation, $product ) {
    // Delete product cached price  (if needed)
    wc_delete_product_transients($variation->get_id());

    return $price; // X3 for testing
}

/**
 * Change number of related products output
 */ 
function woo_related_products_limit() {
  global $product;
	
	$args['posts_per_page'] = 6;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args', 20 );
  function jk_related_products_args( $args ) {
	$args['posts_per_page'] = 3; // 4 related products
	$args['columns'] = 3; // arranged in 2 columns
	return $args;
}

function filter_woocommerce_product_get_image( $image, $_this, $size, $attr, $placeholder ) {
	// ваш код модификации $image
	return $image;
}
add_filter ( 'woocommerce_product_get_image', 'filter_woocommerce_product_get_image', 10, 5);

function getMedia($title) {
	return get_template_directory_uri() . '/assets' . $title;
}

// Variation price

add_filter( 'woocommerce_variable_price_html', 'truemisha_variation_price', 20, 2 );
 
function truemisha_variation_price( $price, $product ) {
 
	$min_regular_price = $product->get_variation_regular_price( 'min', true );
	$min_sale_price = $product->get_variation_sale_price( 'min', true );
	$max_regular_price = $product->get_variation_regular_price( 'max', true );
	$max_sale_price = $product->get_variation_sale_price( 'max', true );
 
	if ( ! ( $min_regular_price == $max_regular_price && $min_sale_price == $max_sale_price ) ) {
		if ( $min_sale_price < $min_regular_price ) {
			$price = sprintf( '<del>%1$s</del><ins>%2$s</ins>', wc_price( $min_regular_price ), wc_price( $min_sale_price ) );
		} else {
			$price = sprintf( '%1$s', wc_price( $min_regular_price ) );
		}
	}
 
	return $price;
 
}


remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );


add_action( 'wp_footer', 'cart_update_qty_script' );
function cart_update_qty_script() {
    if (is_cart()) :
    ?>
    <script>
        jQuery('div.woocommerce').on('change', '.qty', function(){
            jQuery("[name='update_cart']").trigger("click"); 
        });
    </script>
    <?php
    endif;
}

// Add phone number field

function add_review_phone_field_on_comment_form() {
	if (!isset($_GET['replytocom'])) {
		echo '<div class="comment-form-libs">';
		echo '<div class="comment-form-comment comment-form-older uk-margin-top">
		<label for="older">' . __( 'Возраст', 'text-domain' ) . '</label>
		<div><input class="uk-input uk-width-large uk-display-block" type="text" name="older" id="older" required/></div>
		</div>';
		echo '<div class="comment-form-comment comment-form-hairstyle uk-margin-top">
		<label for="hairstyle">' . __( 'Тип волос', 'text-domain' ) . '</label>
		<div><input class="uk-input uk-width-large uk-display-block" type="text" name="hairstyle" id="hairstyle" required/></div>
		</div>';
		echo '<div class="comment-form-comment comment-form-hair uk-margin-top">
		<label for="hair">' . __( 'Длинна волос', 'text-domain' ) . '</label>
		<div><input class="uk-input uk-width-large uk-display-block" type="text" name="hair" id="hair" required/></div>
		</div>';
		echo '</div>';
	}
}
add_action( 'comment_form_logged_in_after', 'add_review_phone_field_on_comment_form' );
add_action( 'comment_form_after_fields', 'add_review_phone_field_on_comment_form' );


// Save phone number
add_action( 'comment_post', 'save_comment_review_phone_field' );
function save_comment_review_phone_field( $comment_id ){
	if( isset( $_POST['older'] ) )
	  update_comment_meta( $comment_id, 'older', esc_attr( $_POST['older'] ) );

	if( isset( $_POST['hair'] ) )
	  update_comment_meta( $comment_id, 'hair', esc_attr( $_POST['hair'] ) );

	if( isset( $_POST['hairstyle'] ) )
	  update_comment_meta( $comment_id, 'hairstyle', esc_attr( $_POST['hairstyle'] ) );
}

function print_review_phone( $id ) {
	$val = get_comment_meta( $id, "phone", true );
	$title = $val ? '<strong class="review-phone">' . $val . '</strong>' : '';
	return $title;
}

add_filter('manage_edit-comments_columns', 'my_add_comments_columns');

function my_add_comments_columns($my_cols) {

    $temp_columns = array(
        'older' => 'Возраст',
        'hair' => 'Длинна волос',
        'hairstyle' => 'Прическа',
    );
    $my_cols = array_slice($my_cols, 0, 3, true) + $temp_columns + array_slice($my_cols, 3, NULL, true);

    return $my_cols;
}

add_action('manage_comments_custom_column', 'my_add_comment_columns_content', 10, 2);

function my_add_comment_columns_content($column, $comment_ID) {
    global $comment;
    switch ($column) :

        case 'older' : {

                echo get_comment_meta($comment_ID, 'older', true);
                break;
            }
		case 'hair' : {

                echo get_comment_meta($comment_ID, 'hair', true);
                break;
            }
		case 'hairstyle' : {

                echo get_comment_meta($comment_ID, 'hairstyle', true);
                break;
            }
    endswitch;
}