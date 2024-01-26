<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() && is_home() ) : ?>
	<?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>

<div class="wrapper" id="index-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<?php
			// Do the left sidebar check and open div#primary.
			get_template_part( 'global-templates/left-sidebar-check' );
			?>

			<main class="site-main" id="main">

				<div>
					<h2>Последние объекты недвижимости</h2>
					<div class="row">
					<?php
						$objects = new WP_Query([
							'post_type' 	 => 'realty',
							'orderby' 		 => 'ID',
							'posts_per_page' => 9
						]);
						if( $objects->have_posts() ) {
							while ( $objects->have_posts() ) {
								$object = $objects->next_post();
								get_template_part( 'loop-templates/object-row', '', ['object' => $object] );
							}
						} else {
							echo '<p>Нет данных</p>';
						}
					?>
					</div>
				</div>

				<div>
					<h2>Недвижимость по городам</h2>
					<div class="row">
					<?php
						$cities = new WP_Query([
							'post_type' 	 => 'city',
							'orderby' 		 => 'post_title',
							'posts_per_page' => -1,
							'order' => 'ASC'
						]);
						if( $cities->have_posts() ) {
							while ( $cities->have_posts() ) {
								$city = $cities->next_post();
								get_template_part( 'loop-templates/city-row', '', ['city' => $city] );
							}
						} else {
							echo '<p>Нет данных</p>';
						}
					?>
					</div>
				</div>

				<div class="row">
					<div class="col-6">
						<form method="post" id="createObject">
							<h2>Добавить новый объект</h2>
							<div class="mb-3">
								<p class="form-label">Название объекта</p>
								<p><input type="text" class="form-control" name="name"></p>
							</div>
							<div class="mb-3">
								<p class="form-label">Описание объекта</p>
								<p><textarea class="form-control" name="description"></textarea></p>
							</div>
							<div class="mb-3">
								<p class="form-label">Основное изображение</p>
								<p><input type="file" class="form-control" name="thumbnail"></p>
							</div>
							<div class="mb-3">
								<p class="form-label">Тип</p>
								<?php 
								  	$types = get_terms( ['taxonomy' => 'realty_type', 'orderby' => 'id', 'order' => 'ASC'] );
									if( $types ) {
										foreach ( $types as $type ) { ?>
											<div class="form-check">
												<input class="form-check-input" type="checkbox" value="<?php echo $type->term_id; ?>" id="type<?php echo $type->term_id; ?>" name="type[]">
												<label class="form-check-label" for="type<?php echo $type->term_id; ?>"><?php echo $type->name; ?></label>
											</div>
										<? }
									}
								?>
							</div>
							<div class="mb-3">
								<p class="form-label">Город</p>
								<?php
									$query = new WP_Query;
									$cities = $query->query([
										'post_type' 	 => 'city',
										'orderby' 		 => 'post_title',
										'posts_per_page' => -1,
										'order'			 => 'ASC'
									]);
								?>
								<p>
									<select class="form-select" name="post-parent">
										<option value="0">Не выбрано</option>
										<?php foreach($cities as $city) {?>
											<option value="<?php echo $city->id; ?>"><?php echo $city->post_title; ?></option>
										<?php } ?>
									</select>
								</p>
							</div>
							<div class="mb-3">
								<p class="form-label">Площадь</p>
								<p><input type="text" class="form-control" name="_square"></p>
							</div>
							<div class="mb-3">
								<p class="form-label">Стоимость</p>
								<p><input type="text" class="form-control" name="_price"></p>
							</div>
							<div class="mb-3">
								<p class="form-label">Адрес</p>
								<p><input type="text" class="form-control" name="_address"></p>
							</div>
							<div class="mb-3">
								<p class="form-label">Жилая площадь</p>
								<p><input type="text" class="form-control" name="_livingsquare"></p>
							</div>
							<div class="mb-3">
								<p class="form-label">Этаж</p>
								<p><input type="number" class="form-control" name="_floor"></p>
							</div>
							<div class="col-12">
    							<button class="btn btn-primary" type="submit">Создать объект</button>
  							</div>
						</form>
					</div>
				</div>
			</main>

			<?php
			// Display the pagination component.
			understrap_pagination();

			// Do the right sidebar check and close div#primary.
			get_template_part( 'global-templates/right-sidebar-check' );
			?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #index-wrapper -->

<?php
get_footer();
