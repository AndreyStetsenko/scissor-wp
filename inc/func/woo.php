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