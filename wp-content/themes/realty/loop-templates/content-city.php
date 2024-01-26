<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>
<div class="col-12 col-sm-6 col-md-4">
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php
		the_title(
			sprintf( '<h2 class="entry-title text-center"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
			'</a></h2>'
		);
		?>

		<?php if ( 'post' === get_post_type() ) : ?>

			<div class="entry-meta">
				<?php understrap_posted_on(); ?>
			</div><!-- .entry-meta -->

		<?php endif; ?>

	</header><!-- .entry-header -->
	<div class="text-center">
	<?php
		if(has_post_thumbnail( $post->ID)) {
            echo get_the_post_thumbnail( $post->ID, 'thumbnail' );
        } else {
        	echo '<img width="150" height="150" src="/wp-content/uploads/2024/01/no_photo-150x150.png">';
        }
	?>
	</div>

	<div class="entry-content text-center">
		<div>
		<?php
			$childrens = get_children( [
				'post_parent' => $post->ID,
				'post_type'   => 'realty',
				'numberposts' => -1,
			] );
		?>
		<p>Количество объектов: <?php echo count($childrens); ?></p>
		</div>
	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
</div>