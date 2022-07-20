<?php

// Создаём событие обработки Ajax в WordPress теме.
add_action( 'wp_ajax_nopriv_ajax_filter_opt', 'ajax_filter_opt' );
add_action( 'wp_ajax_ajax_filter_opt', 'ajax_filter_opt' );

// Описываем саму функцию.
function ajax_filter_opt() {

    // echo json_encode( get_term_by('id', $_POST['catID'], 'product_cat', 'ARRAY_A')['slug'] );

    $cat_slug = get_term_by('id', $_REQUEST['catID'], 'product_cat', 'ARRAY_A')['slug'];

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 10,
        'product_cat'    => $cat_slug
    );

    $loop = new WP_Query( $args );

    while ( $loop->have_posts() ) : $loop->the_post();
        global $product;

        $product = wc_get_product( get_the_ID() );
        $price = $product->get_price_html();
        $sku = $product->get_sku();
        $stock = $product->get_stock_quantity(); 
        $title = $product->get_name(); 
        $reviews = $product->get_review_count(); 
        $rating_count = $product->get_rating_count();
        $average = $product->get_average_rating();
        $img = $product->get_image();
        $link = $product->get_permalink();
        $stars = wc_get_rating_html( $average );

        $results[] = array(
            'id' => get_the_ID(),
            'price' => $price,
            'sku' => $sku,
            'stock' => $stock,
            'title' => $title,
            'reviews' => $reviews,
            'rating_count' => $rating_count,
            'average' => $average,
            'img' => $img,
            'link' => $link,
            'stars' => $stars
        );
    endwhile;

    wp_send_json( $results );

    // wp_reset_query();

    // ===

    // $search_term = isset( $_GET[ 'term' ] ) ? $_GET[ 'term' ] : '';
 
	// $posts = get_posts( array(
	// 	'posts_per_page' => 20,
	// 	'post_type' => 'product',
	// 	'product_cat' => $_POST['data']['catID']
	// ) );
 
	// $results = array();
 
	// if( $posts ) {
 
	// 	foreach( $posts as $post ) {
 
	// 		$results[] = array(
	// 			'id' => $post->ID,
	// 			'value' => $post->post_title,
	// 			'url' => get_permalink( $post->ID )
	// 		);
 
	// 	}
 
	// }
 
	// wp_send_json( $results );

    // Заканчиваем работу Ajax.
    wp_die();
}