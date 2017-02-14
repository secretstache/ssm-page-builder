<?php

if ( have_rows( 'sections' ) ) {

  global $s_i;
  $s_i = 1;

  while ( have_rows( 'sections' ) ) {

    the_row();

    if ( get_row_layout() == 'wrapper_open' ) {

      SSMPB\get_template_part('templates/page-builder/sections/wrapper-open-section');

    } elseif ( get_row_layout() == 'full_width' ) {

      SSMPB\get_template_part('templates/page-builder/sections/full-width-section');

    } elseif ( get_row_layout() == 'two_columns' ) {

      SSMPB\get_template_part('templates/page-builder/sections/two-column-section');

    } elseif ( get_row_layout() == 'three_columns' ) {

      SSMPB\get_template_part('templates/page-builder/sections/three-column-section');

    } elseif ( get_row_layout() == 'four_columns' ) {

      SSMPB\get_template_part('templates/page-builder/sections/four-column-section');

    } elseif ( get_row_layout() == 'wrapper_close' ) {

      SSMPB\get_template_part('templates/page-builder/sections/wrapper-close-section');

    }

    $wrapper_open = get_row_layout() == 'wrapper_open';
    $wrapper_close = get_row_layout() == 'wrapper_close';

    if ( !$wrapper_open && !$wrapper_close ) {
      $s_i++;
    }

  }

}
