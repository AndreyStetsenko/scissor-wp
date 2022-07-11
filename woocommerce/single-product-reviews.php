<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.3.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() ) {
	return;
}

?>

<div id="reviews" class="woocommerce-Reviews">
	<div id="comments">
		<h2 class="woocommerce-Reviews-title">
			<?php
			$count = $product->get_review_count();
			?>
		</h2>

		<div class="comments-header">
			<div class="comments-header--main">
				<div class="rate">
					<span class="title">Рейтинг</span>
					<div class="stars">
					<?php wc_get_template( 'single-product/rating.php' ); ?>
					</div>
				</div>
				<span class="description">Based on <?= $count ?> reviews</span>
			</div>
			<div class="comments-header--btn">
				<a href="#review_form_wrapper" class="btn btn-black">Написать отзыв</a>
			</div>
		</div>

		<ol class="commentlist">
		<?php
			wp_list_comments( array(
				'callback'      => 'bootstrap_comment_callback',
			 ));
			
			function bootstrap_comment_callback( $comment, $args, $depth ){
					$GLOBALS['comment'] = $comment; 
					$meta = get_comment_meta($comment->comment_ID);
					// var_dump($meta); ?>

				<li>
					<div class="comment-item" id="li-comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
						<div class="comment-item--user">
							<div class="comment-item--main">
								<div class="name">
									<span class="username"><?= get_comment_author() ?></span>
									<div class="rate">
										<?php echo wc_get_rating_html( $meta['rating'][0] ); // WPCS: XSS ok. ?>
									</div>
								</div>
								<span class="metas">

									<?php if ( $meta['older'] ) : ?>
										<div class="metas-item">
											<span class="metas-first">Возраст</span>
											<span class="metas-second"><?= $meta['older'][0] ?></span>
										</div>
									<?php endif; ?>

									<?php if ( $meta['hairstyle'] ) : ?>
										<div class="metas-item">
											<span class="metas-first">Тип волос</span>
											<span class="metas-second"><?= $meta['hairstyle'][0] ?></span>
										</div>
									<?php endif; ?>

									<?php if ( $meta['hair'] ) : ?>
										<div class="metas-item">
											<span class="metas-first">Длинна волос</span>
											<span class="metas-second"><?= $meta['hair'][0] ?></span>
										</div>
									<?php endif; ?>

								</span>
							</div>
							<div class="comment-item--avatar">
								<img src="<?= get_avatar_url( $comment, $args['avatar_size'] ); ?>" alt="">
							</div>
						</div>
						<div class="comment-item--body">
							<div class="description">
								<p>
								<?php comment_text(); ?>
								</p>
							</div>
						</div>
						<div class="comment-item--actions">
							<?php edit_comment_link( __( 'Edit' ) ); ?>

							<?php
							comment_reply_link( array_merge( $args, array(
								'add_below' => 'div-comment',
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
							) ) );  
							?>
						</div>
					</div>
				</li>
			<?php
			}
		?>
		</ol>

		<?php if ( have_comments() && false ) : ?>
			<ol class="commentlist">
				<?php  wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
				
				<?php
				$comments = array(
					'post_id' => $product->get_id(),
				);
				$comments_arr = get_comments( $comments );

				foreach ($comments_arr as $item) :
					$meta = get_comment_meta($item->comment_ID);
					$ava = get_avatar_url($item->user_id);
					// var_dump($item); ?>

					<?php if ( $item->comment_approved == 1 ) : ?>			
						<div class="comment-item" id="li-comment-<?= $item->comment_ID ?>">
							<div class="comment-item--user">
								<div class="comment-item--main">
									<div class="name">
										<span class="username"><?= $item->comment_author ?></span>
										<div class="rate">
											<?php echo wc_get_rating_html( $meta['rating'][0] ); // WPCS: XSS ok. ?>
										</div>
									</div>
									<span class="metas">

									<?php if ( $meta['older'] ) : ?>
										<div class="metas-item">
											<span class="metas-first">Возраст</span>
											<span class="metas-second"><?= $meta['older'][0] ?></span>
										</div>
									<?php endif; ?>

									<?php if ( $meta['hairstyle'] ) : ?>
										<div class="metas-item">
											<span class="metas-first">Тип волос</span>
											<span class="metas-second"><?= $meta['hairstyle'][0] ?></span>
										</div>
									<?php endif; ?>

									<?php if ( $meta['hair'] ) : ?>
										<div class="metas-item">
											<span class="metas-first">Длинна волос</span>
											<span class="metas-second"><?= $meta['hair'][0] ?></span>
										</div>
									<?php endif; ?>

									</span>
								</div>
								<div class="comment-item--avatar">
									<img src="<?= $ava ?>" alt="">
								</div>
							</div>
							<div class="comment-item--body">
								<div class="description">
									<p>
										<?= $item->comment_content ?>
									</p>
								</div>
							</div>
						</div>

						<?php foreach ($comments_arr as $parent) : ?>
							<?php if ( $parent->comment_ID == $item->comment_parent ) : ?>
								<div class="comment-item" id="li-comment-<?= $parent->comment_ID ?>">
									<div class="comment-item--user">
										<div class="comment-item--main">
											<div class="name">
												<span class="username"><?= $parent->comment_author ?></span>
												<div class="rate">
													<?php echo wc_get_rating_html( $meta['rating'][0] ); // WPCS: XSS ok. ?>
												</div>
											</div>
											<span class="metas">

											<?php if ( $meta['older'] ) : ?>
												<div class="metas-item">
													<span class="metas-first">Возраст</span>
													<span class="metas-second"><?= $meta['older'][0] ?></span>
												</div>
											<?php endif; ?>

											<?php if ( $meta['hairstyle'] ) : ?>
												<div class="metas-item">
													<span class="metas-first">Тип волос</span>
													<span class="metas-second"><?= $meta['hairstyle'][0] ?></span>
												</div>
											<?php endif; ?>

											<?php if ( $meta['hair'] ) : ?>
												<div class="metas-item">
													<span class="metas-first">Длинна волос</span>
													<span class="metas-second"><?= $meta['hair'][0] ?></span>
												</div>
											<?php endif; ?>

											</span>
										</div>
										<div class="comment-item--avatar">
											<img src="<?= $ava ?>" alt="">
										</div>
									</div>
									<div class="comment-item--body">
										<div class="description">
											<p>
												<?= $parent->comment_content ?>
											</p>
										</div>
									</div>

									<?php get_comment_reply_link( [ 'reply_text' => "ответить на комментарий", 'depth' => 5 ], $item->comment_ID, $item->comment_post_ID ); ?>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>

					<?php endif; ?>

				<?php
				endforeach;
				?>
			</ol>

			<?php
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links(
					apply_filters(
						'woocommerce_comment_pagination_args',
						array(
							'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
							'next_text' => is_rtl() ? '&larr;' : '&rarr;',
							'type'      => 'list',
						)
					)
				);
				echo '</nav>';
			endif;
			?>
		<?php else : ?>
			<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'woocommerce' ); ?></p>
		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
		<?php if (get_user_meta(get_current_user_id())['verification'][0] === 'on') : ?>
			<div id="review_form_wrapper">
				<div id="review_form">
					<?php
					$commenter    = wp_get_current_commenter();
					$comment_form = array(
						/* translators: %s is product title */
						'title_reply'         => have_comments() ? esc_html__( 'Add a review', 'woocommerce' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'woocommerce' ), get_the_title() ),
						/* translators: %s is product title */
						'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'woocommerce' ),
						'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
						'title_reply_after'   => '</span>',
						'comment_notes_after' => '',
						'label_submit'        => esc_html__( 'Submit', 'woocommerce' ),
						'logged_in_as'        => '',
						'comment_field'       => '',
					);

					$name_email_required = (bool) get_option( 'require_name_email', 1 );
					$fields              = array(
						'author' => array(
							'label'    => __( 'Name', 'woocommerce' ),
							'type'     => 'text',
							'value'    => $commenter['comment_author'],
							'required' => $name_email_required,
						),
						'email'  => array(
							'label'    => __( 'Email', 'woocommerce' ),
							'type'     => 'email',
							'value'    => $commenter['comment_author_email'],
							'required' => $name_email_required,
						),
					);

					$comment_form['fields'] = array();

					foreach ( $fields as $key => $field ) {
						$field_html  = '<p class="comment-form-' . esc_attr( $key ) . '">';
						$field_html .= '<label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] );

						if ( $field['required'] ) {
							$field_html .= '&nbsp;<span class="required">*</span>';
						}

						$field_html .= '</label><input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . ' /></p>';

						$comment_form['fields'][ $key ] = $field_html;
					}

					$account_page_url = wc_get_page_permalink( 'myaccount' );
					if ( $account_page_url ) {
						/* translators: %s opening and closing link tags respectively */
						$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'woocommerce' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
					}

					if ( wc_review_ratings_enabled() ) {
						$comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'woocommerce' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" required>
							<option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
							<option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
							<option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
							<option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
							<option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
							<option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
						</select></div>';
					}

					$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
					?>
				</div>
			</div>
		<?php else : ?>
			<div id="review_form_wrapper">
				<div id="review_form">
					<div id="respond" class="comment-respond">
						<span id="reply-title" class="comment-reply-title">Подтвердите аккаунт, прежде чем оставлять отзывы</span>
					</div>
				</div>
			</div>
		<?php endif; ?>
	<?php else : ?>
		<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>
	<?php endif; ?>

	<div class="clear"></div>
</div>
