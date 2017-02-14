<?php

$column_count = $template_args[ 'column_count' ];
$c_classes = 'image-gallery';


if ( $column_count == 4 || $column_count == 3 ) {
  $images_per_row = '2';

} elseif ( $column_count == 2 ) {
  $images_per_row = '4';

} else {
  $images_per_row = '8';

}

$image_gallery = get_sub_field('image_gallery');

?>

<div<?php echo SSMPB\component_id_classes( $c_classes ); ?>>

  <div class="row small-up-2 medium-up-<?php echo $images_per_row; ?>">

    <?php foreach ( $image_gallery as $image ) { ?>

    <div class="thumb column">

      <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />

    </div>

    <?php } ?>

  </div>

</div>