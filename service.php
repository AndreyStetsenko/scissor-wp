<?php

/**
 * Template Name: Service
 */

get_header();
?>

<div class="services">
    <div class="services-wrap">

    <?php if( have_rows('p-services') ): ?>
        <?php while( have_rows('p-services') ) : the_row(); ?>
        <?php
        $title = get_sub_field('title');
        $content = get_sub_field('content');
        ?>

        <div class="item">
            <h3 class="title"><?= $title ?></h3>

            <div class="item-body">
               <div class="container">
                    <div class="content">
                        <p>
                            <?= $content ?>
                        </p>
                    </div>
               </div>
            </div>
        </div>

        <?php endwhile; ?>
    <?php endif; ?>
        
    </div>
</div>

<?php
get_footer();
