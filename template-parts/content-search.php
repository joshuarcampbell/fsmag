<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Editorial_Mag
 */

$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'fsmag-normal-image', true);

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('equalheight archive-image'); ?>>
	<?php if( has_post_thumbnail() ){ ?>
	    <figure>
	        <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( $image[0] ); ?>" alt="<?php the_title(); ?>"></a>
	    </figure>
	<?php } ?>
	<div class="news-content-wrap">
		<?php fsmag_colored_category(); ?>
		
		<h3 class="news-title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>

		<?php fsmag_posted_on(); ?>

		<div class="news-block-content">
			<?php the_excerpt(); ?>
		</div>

		<div class="news-block-footer">
			<div class="news-comment">
				<i class="icofont fa fa-commenting"></i> <?php comments_popup_link( esc_html__( 'No comment', 'fsmag' ), esc_html__( '1 Comment', 'fsmag' ), esc_html__( '% Comments', 'fsmag' ) ); ?>
			</div>
			<div class="news-comment readmore">
                <a href="<?php the_permalink(); ?>">
                	<?php esc_html_e('Continue Reading','fsmag'); ?> <i class="icofont fa fa-arrow-circle-o-right"></i>
                </a>
            </div>
		</div>
		
	</div>
</article>
