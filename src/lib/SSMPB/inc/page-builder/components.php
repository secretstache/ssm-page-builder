<?php

if ( have_rows( 'components' ) ) {

  global $c_i;
  global $template_args;

  $c_i = 1;

  while ( have_rows( 'components' ) ) {

    the_row();

    if ( get_row_layout() == 'header' ) {

      SSMPB\get_template_part('templates/page-builder/components/header-component', $template_args ) ;

    } elseif ( get_row_layout() == 'text_editor' ) {

      SSMPB\get_template_part('templates/page-builder/components/text-editor-component', $template_args ) ;

    } elseif ( get_row_layout() == 'headline' ) {

      SSMPB\get_template_part('templates/page-builder/components/headline-component', $template_args ) ;

    } elseif ( get_row_layout() == 'image' ) {

      SSMPB\get_template_part('templates/page-builder/components/image-component', $template_args ) ;

    } elseif ( get_row_layout() == 'image_gallery' ) {

      SSMPB\get_template_part('templates/page-builder/components/image-gallery-component', $template_args ) ;

    } elseif ( get_row_layout() == 'video' ) {

      SSMPB\get_template_part('templates/page-builder/components/video-component', $template_args ) ;

    } elseif ( get_row_layout() == 'form' ) {

      SSMPB\get_template_part('templates/page-builder/components/form-component', $template_args ) ;

    }

    $c_i++;

  }

}
