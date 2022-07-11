<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Scissor
 */

get_header();
?>

<?php if ( have_posts() ) : ?>

<div class="wrapper-title black inner mt-4">
    <div class="container">
        <h1 class="article-level-1">
			<?php
			/* translators: %s: search query. */
			printf( esc_html__( 'Search Results for: %s', 'scissor' ), get_search_query() );
			?>	
		</h1>
    </div>
</div>

<section class="products-list-min">

    <div class="wrapper">
        <div class="container">
            <div class="row items">

				<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'search' );

					endwhile;

					the_posts_navigation();
				?>

            </div>
        </div>
    </div>
</section>

<?php endif; ?>

<?php
get_footer();
