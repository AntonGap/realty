<?php

/**
 * Plugin Name: Post Multi Images
 * Version: 1.0.0
 */

add_action( 'admin_enqueue_scripts', 'multiimages_scripts' );
function multiimages_scripts() {
	wp_enqueue_style( 'multiimages', plugin_dir_url( __FILE__ ) . 'admin/css/multiimages.css', [], '1.0.0', 'all' );
	wp_enqueue_script( 'multiimages', plugin_dir_url( __FILE__ ) . 'admin/js/multiimages.js', ['jquery'], '1.0.0', false);
}

function add_gallery(){
    add_meta_box( 'post-gallery', 'Изображения объекта', 'metabox_gallery', 'realty', 'normal', 'low' );
}  
add_action('add_meta_boxes', 'add_gallery');

function metabox_gallery($post){ ?>
    <div id="images_container">
        <ul class="images">
            <?php global $post;
                if ( metadata_exists( 'post', $post->ID, '_image_gallery' ) ) {
                    $image_gallery = get_post_meta( $post->ID, '_image_gallery', true );
                } else { 
                    $attachment_ids = get_posts( 'post_parent=' . $post->ID . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids&meta_value=0' );
                    $attachment_ids = array_diff( $attachment_ids, array( get_post_thumbnail_id() ) );
                    $image_gallery = implode( ',', $attachment_ids );
                } 
              $attachments = array_filter( explode( ',', $image_gallery ) );

                if ( $attachments ) {
                    foreach ( $attachments as $attachment_id ) {
                        echo '<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
                            ' . wp_get_attachment_image( $attachment_id, 'thumbnail' ) . '
                            <ul class="actions">
                                <li><a href="#" class="delete tips" data-tip="Удалить изображение">Удалить</a></li>
                            </ul>
                        </li>';
                    } 
                }  
            ?>
        </ul> 
        <input type="hidden" id="image_gallery" name="image_gallery" value="<?php echo esc_attr( $image_gallery ); ?>" /> 
    </div>
    <p class="add_images hide-if-no-js">
        <a href="#" data-choose="Добавить изображения объекта" data-update="Добавить в галерею" data-delete="Удалить изображение" data-text="Удалить">Выбрать изображения</a>
    </p>
<?php 
} 
function update_gallery( $post_id, $post, $update ) {
    $slug = 'realty';
    if ( $slug != $post->post_type ) {
        return;
    }
    $attachment_ids = isset( $_POST['image_gallery'] ) ? array_filter( explode( ',', sanitize_text_field( $_POST['image_gallery'] ) ) ) : [];
    update_post_meta( $post_id, '_image_gallery', implode( ',', $attachment_ids ) );
}
add_action( 'save_post', 'update_gallery', 10, 3 );