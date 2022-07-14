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
                    $args = array('taxonomy' => 'product_cat');
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
            
        </div>
    </div>
</div>

<?php
get_footer();
