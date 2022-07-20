<?php

/**
 * Template Name: Wholesale
 */

get_header();
?>

<div class="wrapper-title black">
    <div class="container">
        <h2 class="article-level-1">Оптовая продукция</h2>
    </div>
</div>

<div class="wholesale">
    <div class="container">
        <div class="wholesale-head">

            <div class="dropdown btn-filter" id="dropFilter">
                <button class="btn btn-black dropdown-toggle" type="button" id="dropFilterMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    Фильтр
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropFilterMenu">
                    <?php
                    $args = array(
                        'taxonomy'    => 'product_cat',
                        'orderby'     => 'id', // здесь по какому полю сортировать
                        'hide_empty'  => false, // скрывать категории без товаров или нет
                        'parent'      => 0 // id родительской категории
                    );
                    $categories = get_categories( $args );

                    
                    
                    foreach( $categories as $item_cat ) {
                        echo '<li><a class="dropdown-item item" 
                                        href="' . $item_cat->slug . '" 
                                        data-id="' . $item_cat->cat_ID . '">' . $item_cat->name . '</a></li>';
                    }
                    ?>
                </ul>
            </div>

        </div>
        <div class="row items wholesale-wrap mt-3" id="filterResult">

        <?php

				$args = array(
					'post_type' => 'product',
					'post_status' => 'publish',
					'posts_per_page' => 6,
					'meta_key' => 'total_sales',
					'orderby' => 'meta_value_num',
					'paged' => $paged,
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
					
					<div class="col-md-3 product-first item product-opt">
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

<?php
get_footer();
