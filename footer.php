<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Scissor
 */

?>

</div>

<footer class="footer" id="footer">
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <ul class="footer-nav">
                        <li><a href="#">О нас</a></li>
                        <li><a href="#">Контакты</a></li>
                        <li><a href="#">Сервис</a></li>
                        <li><a href="#">Договор офферты</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <div class="footer-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                </div>
                <div class="col-md-4">
                <?php if( have_rows('social_networks', 'options') ): ?>
                    <ul class="footer-social">
                    <?php while( have_rows('social_networks', 'options') ): the_row(); ?>
                        <li>
                            <a href="<?php the_sub_field('link'); ?>">
                                <i class="<?php the_sub_field('icon'); ?>"></i>
                            </a>
                        </li>
                    <?php endwhile; ?>
                    </ul>
                <?php endif; ?>
                </div>
                <div class="col-12">
                    <div class="footer-cr">
                        <span class="footer-copyright">
                            <?= date('Y') ?> <?= get_bloginfo() ?> TM | All Rights Reserved
                        </span>

                        <span class="footer-contacts">
                            <?= pll__( 'Contact us', 'scissor' ) ?>: 
                            <?php if( have_rows('contacts', 'options') ): ?>
                                <?php while( have_rows('contacts', 'options') ): the_row(); ?>
                                    <?php if ( get_sub_field('title') == 'Email' ): ?>
                                        <?= the_sub_field('link'); ?>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php require get_template_directory() . '/inc/footer-auth.php'; ?>

<?php wp_footer(); ?>

<script>
	$('.variable_inp').on('click', function() {
		var attr = $(this).attr('data-id');
		console.log(attr);
		$('#pa_volume option:contains("' + attr + '")').prop('selected', true);

		$('#pa_volume').change();
	});
</script>

</body>
</html>
