<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php
		the_title(
			sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
			'</a></h2>'
		);
		?>

		<?php if ( 'post' === get_post_type() ) : ?>

			<div class="entry-meta">
				<?php understrap_posted_on(); ?>
			</div><!-- .entry-meta -->

		<?php endif; ?>

	</header><!-- .entry-header -->

	<div class="row">
		<div class="col-12 col-sm-6 col-md-6">
			<?php 
				if(has_post_thumbnail( $post->ID)) {
					echo get_the_post_thumbnail( $post->ID, 'large' );
				} else {
					echo '<img src="/wp-content/uploads/2024/01/no_photo-1024x1024.png">';
				}
			?>
		</div>
		<div class="col-12 col-sm-6 col-md-6">
			<h4>Город: <?php echo (get_post_parent($post->ID)->post_title);?></h4>
			<h4>Характеристики</h4>
			<p>Площадь: <?php object_meta($object->ID, '_square');?></p>
            <p>Стоимость: <?php object_meta($object->ID, '_price');?></p>
            <p>Адрес: <?php object_meta($object->ID, '_address');?></p>
            <p>Жилая площадь: <?php object_meta($object->ID, '_livingsquare');?></p>
            <p>Этаж: <?php object_meta($object->ID, '_floor');?></p>
		</div>

	<div class="entry-content">

		<?php
		the_excerpt();
		understrap_link_pages();
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
