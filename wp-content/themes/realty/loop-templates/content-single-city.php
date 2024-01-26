<?php
/**
 * Single post partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

	</header><!-- .entry-header -->

	<?php 
		if(has_post_thumbnail( $post->ID)) {
            echo get_the_post_thumbnail( $post->ID, 'large' );
        } else {
            echo '<img src="/wp-content/uploads/2024/01/no_photo-300x300.png">';
        }
	?>

	<div class="entry-content">

		<?php
		the_content();
		understrap_link_pages();
		?>
		<div>
			<h4>Объекты в этом городе</h4>
			<?php
				$objects = get_children( [
					'post_parent' => $post->ID,
					'post_type'   => 'realty',
					'numberposts' => 10,
				] );
			foreach ($objects as $object) {
			?>
			<a href="<?php echo get_permalink($object) ?>">
				<div class="row">
					<div class="col-auto">
					<?
					if(has_post_thumbnail( $object->ID)) {
						echo get_the_post_thumbnail( $object->ID, 'thumbnail' );
					} else {
						echo '<img src="/wp-content/uploads/2024/01/no_photo-150x150.png">';
					}
					?>
					</div>	
					<div class="col-auto align-items-center d-flex"><div><?php echo $object->post_title;?></div></div>
				</div>
			</a>
			<?php } ?>
		</div>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
