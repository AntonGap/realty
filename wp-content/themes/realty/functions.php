<?php
defined( 'ABSPATH' ) || exit;
add_action( 'init', 'create_realty_taxonomies' );

function create_realty_taxonomies(){

	register_taxonomy('realty_type', ['realty'], [
		'hierarchical'  => true,
		'labels'        => [
			'name'              => 'Тип недвижимости',
			'singular_name'     => 'Тип недвижимости',
			'menu_name'         => 'Тип недвижимости',
		],
		'show_ui'       => true,
		'query_var'     => true,
	]);

	register_post_type('realty', [
		'labels'             => [
			'name'          => 'Объекты недвижимости',
			'singular_name' => 'Объект недвижимости',
			'menu_name'     => 'Недвижимость',
			'all_items'		=> 'Объекты'
		],
		'menu_icon'			 => 'dashicons-admin-multisite',
		'public'             => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'supports'           => ['title','editor','thumbnail']
	]);
	register_post_type('city', [
		'labels'             => [
			'name'          => 'Города',
			'singular_name' => 'Город',
			'menu_name'     => 'Города'
		],
		'menu_icon'			 => 'dashicons-location-alt',
		'public'             => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'supports'           => ['title','editor','thumbnail']
	]);
}

add_action('add_meta_boxes', 'object_extra_fields');

function object_extra_fields() {
	add_meta_box( 'realty_fields', 'Основная информация', 'object_fields_box', 'realty');
	add_meta_box( 'city_field', 'Город объекта', 'object_city_box', 'realty', 'side', 'low');
}

function object_fields_box( $post ){
	?>
	<p>Площадь:<br/>
		<input type="text" name="extra[_square]" value="<?php echo get_post_meta($post->ID, '_square', 1); ?>"/>
	</p>

	<p>Стоимость:<br/>
		<input type="text" name="extra[_price]" value="<?php echo get_post_meta($post->ID, '_price', 1); ?>"/>
	</p>

	<p>Адрес:<br/>
		<input type="text" name="extra[_address]" value="<?php echo get_post_meta($post->ID, '_address', 1); ?>"/>
	</p>

	<p>Жилая площадь:<br/>
		<input type="text" name="extra[_livingsquare]" value="<?php echo get_post_meta($post->ID, '_livingsquare', 1); ?>"/>
	</p>

	<p>Этаж:<br/>
		<input type="number" name="extra[_floor]" value="<?php echo get_post_meta($post->ID, '_floor', 1); ?>"/>
	</p>

	<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
	<?php
}

function object_city_box( $post ){

	$query = new WP_Query;
	$cities = $query->query([
		'post_type' 	 => 'city',
		'orderby' 		 => 'post_title',
		'posts_per_page' => -1,
		'order'			 => 'ASC'
	]);
	?>
	<p>Город:<br/>
		<select name="post_parent">
			<option value="0" <?php selected( $post->post_parent, '0' );?>>Не выбрано</option>
			<?php
			foreach( $cities as $city ) {
				echo '<option value="'.$city->ID.'" '. selected( $post->post_parent, $city->ID ).'>'.$city->post_title.'</option>';
			}
			?>
		</select>
	</p>
	<?php
}

add_action( 'save_post', 'object_extra_fields_update', 0 );

function object_extra_fields_update( $post_id ){
	if (
		empty( $_POST['extra'] )
		|| ! wp_verify_nonce( $_POST['extra_fields_nonce'], __FILE__ )
		|| wp_is_post_autosave( $post_id )
		|| wp_is_post_revision( $post_id )
	)
		return false;

	$_POST['extra'] = array_map( 'sanitize_text_field', $_POST['extra'] );
	foreach( $_POST['extra'] as $key => $value ){
		if( empty($value) ){
			delete_post_meta( $post_id, $key );
			continue;
		}

		update_post_meta( $post_id, $key, $value );
	}

	return $post_id;
}

function object_meta($post, $field) {
	echo (metadata_exists('post', $post, '_square')?get_post_meta($post, $field, 1):'Не указано');
}

add_action( 'wp_enqueue_scripts', 'site_scripts' );
function site_scripts() {
	wp_enqueue_script( 'site_scripts', get_stylesheet_directory_uri() . '/js/site.js', ['jquery'], '1.0.0', true);
}

add_action( 'rest_api_init', function() {

	$namespace = 'newobject/v1';

	$route = '/add';

	$route_params = [
		'methods'  => 'POST',
		'callback' => 'create_post',
		'permission_callback' => '__return_true'
	];

	register_rest_route( $namespace, $route, $route_params );

} );

function create_post( WP_REST_Request $request ) {

	$meta = [];
	if(isset($request['_square']) && $request['_square'] !='') {
		$meta['_square'] = $request['_square'];
	}
	if(isset($request['_price']) && $request['_price'] !='') {
		$meta['_price'] = $request['_price'];
	}
	if(isset($request['_address']) && $request['_address'] !='') {
		$meta['_address'] = $request['_address'];
	}
	if(isset($request['_livingsquare']) && $request['_livingsquare'] !='') {
		$meta['_livingsquare'] = $request['_livingsquare'];
	}
	if(isset($request['_floor']) && $request['_floor'] !='') {
		$meta['_floor'] = intval($request['_floor']);
	}
	
	$postarr = array(
		'post_author'    => 1,
		'post_content'   => $request['description'],
		'post_parent'    => intval($request['post-parent']),
		'post_status'    => 'pending',
		'post_title'     => $request['name'],
		'post_type'      => 'realty',
		'meta_input'     => $meta,
	);

	$post_id = wp_insert_post( $postarr, true );
	if( is_wp_error($post_id) ){
		return ['success' => false, 'message' => $post_id->get_error_message()];
	}
	else {
		if(isset($request['type'])) {
			wp_set_post_terms( $post_id, $request['type'], 'realty_type' );
		}
		return ['success' => true, 'id' => $post_id];
	}
}

add_action( 'wp_ajax_'.'ajax_fileload',        'ajax_file_upload_callback' );
add_action( 'wp_ajax_nopriv_'.'ajax_fileload', 'ajax_file_upload_callback' );

function ajax_file_upload_callback(){
	check_ajax_referer( 'newobjectform', 'nonce' );

	if( empty( $_FILES ) )
		wp_send_json_error( 'Файлов нет...' );

	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';

	add_filter( 'upload_mimes', function( $mimes ){
		return [
			'jpg|jpeg|jpe' => 'image/jpeg',
			'gif'          => 'image/gif',
			'png'          => 'image/png',
		];
	} );

	$uploaded_imgs = array();
	$post_id = $_POST['post_id'];
	$is_gallery = false;
	if(isset($_POST['is_gallery'])) {
		$is_gallery = $_POST['is_gallery'];
	}

	foreach( $_FILES as $file_id => $data ){
		$attach_id = media_handle_upload( $file_id, $post_id );

		if( is_wp_error( $attach_id ) )
			$uploaded_imgs[] = 'Ошибка загрузки файла `'. $data['name'] .'`: '. $attach_id->get_error_message();
		else
			$uploaded_imgs[] = $attach_id;
	}

	if(!$is_gallery) {
		set_post_thumbnail($post_id, $uploaded_imgs[0]);
	} else {
		update_post_meta( $post_id, '_image_gallery', implode(',', $uploaded_imgs) );
	}

	wp_send_json_success( $uploaded_imgs );

}

function pre($val) {
	echo '<pre>';
	var_dump($val);
	echo '<pre>';
}