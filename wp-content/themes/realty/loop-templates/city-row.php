<?php
$city = $args['city'];
?>
<div class="col-12 col-sm-3">
    <div class="border border-dark rounded p-2">
        <a href="<?php echo get_permalink($city) ?>" class="link-primary">
            <div class="text-center">
                <?php 
                    if(has_post_thumbnail( $city->ID)) {
                        echo get_the_post_thumbnail( $city->ID, 'thumbnail' );
                    } else {
                        echo '<img width="150" height="150" src="/wp-content/uploads/2024/01/no_photo-150x150.png">';
                    }
                ?>
            </div>
            <div class="text-center"><?php echo $city->post_title ?></div>
        </a>
    </div>
</div>