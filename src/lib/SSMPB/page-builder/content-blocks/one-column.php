<?php

// Bail if section is set to inactive
if ( get_sub_field('status') == 0 )
  return;

global $column_count;
global $template_args;

$column_count = 1;
$template_args = array(
  'column_count' => $column_count
);

$column_width = get_sub_field( 'column_width' );

echo '<section' . SSMPB\section_id_classes() . '>';

SSMPB\maybe_do_section_header();

if ( have_rows( 'full_width_modules' ) ) {

  echo '<div class="row align-center">';

    while ( have_rows( 'full_width_modules' ) ) {

      the_row();

      $template_args['column_width'] = $column_width;

      echo '<div class="small-12 medium-' . $column_width . ' column">';

        SSMPB\do_column( $template_args );

      echo '</div>';

    }

  echo '</div>';

}

echo '</section>';
