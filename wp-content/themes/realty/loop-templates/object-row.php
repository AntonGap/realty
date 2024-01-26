<?php
$object = $args['object'];
?>
<div class="col-12 col-sm-6 col-md-6 col-lg-4">
    <div class="p-2 border border-dark rounded mb-3">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 border-end">
                <a href="<?php echo get_permalink($object) ?>" class="link-primary">
                    <div class="text-center">
                        <?php 
                            if(has_post_thumbnail( $object->ID)) {
                                echo get_the_post_thumbnail( $object->ID, 'thumbnail' );
                            } else {
                                echo '<img width="150" height="150" src="/wp-content/uploads/2024/01/no_photo-150x150.png">';
                            }
                        ?>
                    </div>
                    <div class="text-center"><?php echo $object->post_title ?></div>
                </a>
                <div>Тип: <?php echo get_the_term_list( $object->ID, 'realty_type', '', ', ' ); ?>
                </div>
                <div>Город: <?php echo get_post_parent($object->ID)->post_title;?>
            </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6">
                <h4 class="text-center">Информация</h4>
                
                <p>Площадь: <?php object_meta($object->ID, '_square');?></p>
                <p>Стоимость: <?php object_meta($object->ID, '_price');?></p>
                <p>Адрес: <?php object_meta($object->ID, '_address');?></p>
                <p>Жилая площадь: <?php object_meta($object->ID, '_livingsquare');?></p>
                <p>Этаж: <?php object_meta($object->ID, '_floor');?></p>
            </div>
        </div>
    </div>
</div>