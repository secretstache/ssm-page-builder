<?php

$c_classes = 'module-header';

?>

<header<?php echo SSMPB\component_id_classes( $c_classes ); ?>>

  <h2 class="title"><?php the_sub_field('headline'); ?></h2>
  <h3 class="title"><?php the_sub_field('subheadline'); ?></h3>

</header>
