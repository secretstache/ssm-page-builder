<?php

$c_classes = 'image';
$image = get_sub_field('image');
$image_link = get_field('image_link', $image['ID']);

?>


<div<?php echo SSMPB\component_id_classes( $c_classes ); ?>>

  <?php if ( $image_link ) { ?>

  <a href="<?php echo $image_link; ?>">

  <?php } ?>

  <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />

  <?php if ( $image_link ) { ?>

  </a>

  <?php } ?>

</div>