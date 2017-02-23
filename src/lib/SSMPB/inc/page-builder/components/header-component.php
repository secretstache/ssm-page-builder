<?php

$c_classes = 'module-header';

?>

<header<?php echo SSMPB\component_id_classes( $c_classes ); ?>>

  <?php if ( $headline = get_sub_field('headline') ) { ?>

      <h2 class="module-headline"><?php echo $headline ?></h2>

  <?php } ?>

  <?php if ( $subheadline = get_sub_field('subheadline') ) { ?>

      <h3 class="module-subheadline"><?php echo $subheadline ?></h3>

  <?php } ?>

</header>
