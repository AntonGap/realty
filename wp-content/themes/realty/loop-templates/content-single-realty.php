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
	<div class="entry-content">
		<div class="row">
			<div class="col-12 col-sm-6 col-md-6">
				<?php 
					if(has_post_thumbnail( $post->ID)) {
						echo get_the_post_thumbnail( $post->ID, 'large' );
					} else {
						echo '<img src="/wp-content/uploads/2024/01/no_photo-300x300.png">';
					}
					the_content();
					understrap_link_pages();
				?>
			</div>
			<div class="col-12 col-sm-6 col-md-6">
				<div>Город: <?php echo get_post_parent($post->ID)->post_title;?>	
				<h4>Информация</h4>
				<p>Площадь: <?php object_meta($post->ID, '_square');?></p>
                <p>Стоимость: <?php object_meta($post->ID, '_price');?></p>
                <p>Адрес: <?php object_meta($post->ID, '_address');?></p>
                <p>Жилая площадь: <?php object_meta($post->ID, '_livingsquare');?></p>
                <p>Этаж: <?php object_meta($post->ID, '_floor');?></p>
			</div>
		</div>
		<div>
		<?php 
			$gallery = get_post_meta($post->ID, '_image_gallery', 1);
			if($gallery != '') {
				$ids = explode(',', $gallery);
		?>
		
			<div id="carouselExampleIndicators" class="carousel slide carousel-dark" data-bs-ride="carousel">
				<div class="carousel-indicators">
					<?php foreach ($ids as $key => $id)	{ ?>
						<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $key; ?>"<?php if($key == 0) { ?> class="active" aria-current="true" aria-label="Slide 1"<?php } ?>></button>
					<?php } ?>
				</div>
				<div class="carousel-inner">
					
					<?php foreach ($ids as $key => $id)	{ ?>
					<div class="carousel-item<?php if($key == 0) { ?> active<?php } ?>">
						<img src="<? echo wp_get_attachment_image_url( $id, 'large' ); ?>" class="d-block m-auto">
					</div>
					<?php } ?>
				</div>
				<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Previous</span>
				</button>
				<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Next</span>
				</button>
				</div>
			</div>
		<?php } ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
