<?php

namespace SSMPB;

function do_page_builder( ) {
    \get_template_part( 'src/lib/SSMPB/page-builder/content-blocks');
}

function maybe_do_section_header() { ?>
  <?php if ( get_sub_field('include_content_block_header') == TRUE ) { ?>

    <div class="row header-wrap">

      <div class="small-12 column">

        <header class="section-header">

          <?php if ( $headline = get_sub_field('section_headline') ) { ?>

          <h1 class="headline"><?php echo $headline; ?></h1>

          <?php } ?>

          <?php if ( $subheadline = get_sub_field('section_subheadline') ) { ?>

          <h2 class="subheadline"><?php echo $subheadline; ?></h2>

          <?php } ?>

        </header>

      </div>

    </div>

  <?php }
}

function section_id_classes( $s_classes = '' ) {

  global $s_i;

  $even_odd = 0 == $s_i % 2 ? 'even' : 'odd';

  $inline_classes = get_sub_field('html_classes');

  $section_id_classes = '';

  if ( $html_id = get_sub_field('html_id') ) {
    $html_id = sanitize_html_class(strtolower($html_id));
    $section_id_classes .= ' id="' . $html_id . '" class="content-block row-' . $s_i . ' row-' . $even_odd;
  } else {
    $section_id_classes .= ' class="content-block row-' . $s_i . ' row-' . $even_odd;
  }

  if ( $s_classes != NULL ) {
    $s_classes = \SSMCore\Helpers\sanitize_html_classes($s_classes);
    $section_id_classes .= ' ' . $s_classes;

  }

  if ( $inline_classes != NULL ) {
    $section_id_classes .= ' ' . $inline_classes;
  }

  $section_id_classes .= '"';

  return $section_id_classes;

}

function component_id_classes( $c_classes = '' ) {

  global $c_i;

  $even_odd = 0 == $c_i % 2 ? 'even' : 'odd';

  $inline_classes = get_sub_field('html_classes');

  $component_id_classes = '';

  if ( $html_id = get_sub_field('html_id') ) {
    $html_id = sanitize_html_class(strtolower($html_id));
    $component_id_classes .= ' id="' . $html_id . '" class="component stack-order-' . $c_i . ' stack-order-' . $even_odd;
  } else {
    $component_id_classes .= ' class="component stack-order-' . $c_i . ' stack-order-' . $even_odd;
  }

  if ( $c_classes != NULL ) {
    $c_classes = \SSMCore\Helpers\sanitize_html_classes($c_classes);
    $component_id_classes .= ' ' . $c_classes;

  }

  if ( $inline_classes != NULL ) {
    $component_id_classes .= ' ' . $inline_classes;
  }

  $component_id_classes .= '"';

  return $component_id_classes;

}

function column_id_classes( $col_classes = '' ) {

    $inline_classes = get_sub_field('html_classes');

    $column_id_classes = '';

    if ( $html_id = get_sub_field('html_id') ) {
    $html_id = sanitize_html_class(strtolower($html_id));
        $column_id_classes .= ' id="' . $html_id . '" class="inner';
      } else {
        $column_id_classes .= ' class="inner';
      }

      if ( $col_classes != NULL ) {
          $col_classes = \SSMCore\Helpers\sanitize_html_classes($col_classes);
          $column_id_classes .= ' ' . $col_classes;

      }

      if ( $inline_classes != NULL ) {
          $column_id_classes .= ' ' . $inline_classes;
      }

    $column_id_classes .= '"';

      return $column_id_classes;

}

function do_column( $template_args = array() ) {

    echo '<div' . column_id_classes( $col_classes ) . '>';

        hm_get_template_part( SSMPB_DIR . 'page-builder/components.php', $template_args );

    echo '</div>';

}

/**
 * Like get_template_part() but lets you pass args to the template file
 * Args are available in the tempalte as $template_args array
 * @param string filepart
 * @param mixed wp_args style argument list
 */
function hm_get_template_part( $file, $template_args = array(), $cache_args = array() ) {
    $template_args = wp_parse_args( $template_args );
    $cache_args = wp_parse_args( $cache_args );
    if ( $cache_args ) {
        foreach ( $template_args as $key => $value ) {
            if ( is_scalar( $value ) || is_array( $value ) ) {
                $cache_args[$key] = $value;
            } else if ( is_object( $value ) && method_exists( $value, 'get_id' ) ) {
                $cache_args[$key] = call_user_func('get_id', $value);
            }
        }
        if ( ( $cache = wp_cache_get( $file, serialize( $cache_args ) ) ) !== false ) {
            if ( ! empty( $template_args['return'] ) )
                return $cache;
            echo $cache;
            return;
        }
    }
    $file_handle = $file;
    do_action( 'start_operation', 'hm_template_part::' . $file_handle );
    if ( file_exists( get_stylesheet_directory() . '/' . $file . '.php' ) )
        $file = get_stylesheet_directory() . '/' . $file . '.php';
    elseif ( file_exists( get_template_directory() . '/' . $file . '.php' ) )
        $file = get_template_directory() . '/' . $file . '.php';
    ob_start();
    $return = require( $file );
    $data = ob_get_clean();
    do_action( 'end_operation', 'hm_template_part::' . $file_handle );
    if ( $cache_args ) {
        wp_cache_set( $file, $data, serialize( $cache_args ), 3600 );
    }
    if ( ! empty( $template_args['return'] ) )
        if ( $return === false )
            return false;
        else
            return $data;
    echo $data;
}

add_filter('acf/fields/flexible_content/layout_title/name=content_blocks', __NAMESPACE__ . '\\content_block_title', 10, 4);
/**
 * Update The Flexible Content Label
 * @since 1.0.0
 */
function content_block_title( $title, $field, $layout, $i ) {

    $short_title = '';

    if ( $title == 'Two Columns' ) {
        $short_title = '2 Cols';
    } elseif ( $title == 'Three Columns' ) {
        $short_title = '3 Cols';
    } elseif ( $title == 'Four Columns' ) {
        $short_title = '4 Cols';
    } else {
        $short_title = $title;
    }


    if ( get_sub_field('section_label') ) {

        $label = get_sub_field('section_label') . ' &mdash; ' . $short_title;

    } else {

        $label = $title;

    }

    if ( get_sub_field('status') == 0 ) {
        $new_title = '<span style="color:red; font-weight:bold;">Inactive</span> - ' . $label;
    } else {
        $new_title = $label;
    }

    return $new_title;

}

add_action('wp_head', __NAMESPACE__ . '\\do_inline_css', 99);
/**
 * Injects inline CSS into the head
 * @since 1.0.0
 */
function do_inline_css() {

    global $post;
    $styles = array();

    if( have_rows( 'content_blocks', $post->ID ) ) {

        while( have_rows ( 'content_blocks', $post->ID ) ) {
            the_row();

            if ( $inline_styles = get_sub_field('inline_css') ) {
                $styles[] = $inline_styles;

            }

            if( have_rows( 'full_width_modules', $post->ID ) ) {

                while( have_rows ( 'full_width_modules', $post->ID ) ) {
                the_row();

                    if ( $inline_styles = get_sub_field('inline_css') ) {
                        $styles[] = $inline_styles;

                    }

                    if( have_rows( 'components', $post->ID ) ) {

                        while( have_rows ( 'components', $post->ID ) ) {
                            the_row();

                            if ( $inline_styles = get_sub_field('inline_css') ) {
                                $styles[] = $inline_styles;

                            }

                        }

                    }

                }

            }

            if( have_rows( 'two_column_modules', $post->ID ) ) {

                while( have_rows ( 'two_column_modules', $post->ID ) ) {
                the_row();

                    if ( $inline_styles = get_sub_field('inline_css') ) {
                        $styles[] = $inline_styles;

                    }

                    if( have_rows( 'components', $post->ID ) ) {

                        while( have_rows ( 'components', $post->ID ) ) {
                            the_row();

                            if ( $inline_styles = get_sub_field('inline_css') ) {
                                $styles[] = $inline_styles;

                            }

                        }

                    }

                }

            }

            if( have_rows( 'three_column_modules', $post->ID ) ) {

                while( have_rows ( 'three_column_modules', $post->ID ) ) {
                the_row();

                    if ( $inline_styles = get_sub_field('inline_css') ) {
                        $styles[] = $inline_styles;

                    }

                    if( have_rows( 'components', $post->ID ) ) {

                        while( have_rows ( 'components', $post->ID ) ) {
                            the_row();

                            if ( $inline_styles = get_sub_field('inline_css') ) {
                                $styles[] = $inline_styles;

                            }

                        }

                    }

                }

            }

            if( have_rows( 'four_column_modules', $post->ID ) ) {

                while( have_rows ( 'four_column_modules', $post->ID ) ) {
                the_row();

                    if ( $inline_styles = get_sub_field('inline_css') ) {
                        $styles[] = $inline_styles;

                    }

                    if( have_rows( 'components', $post->ID ) ) {

                        while( have_rows ( 'components', $post->ID ) ) {
                            the_row();

                            if ( $inline_styles = get_sub_field('inline_css') ) {
                                $styles[] = $inline_styles;

                            }

                        }

                    }

                }

            }

        }

    }

    foreach ( $styles as $style ) :
        $output .= $style;
    endforeach;

    if ( $output != '' ) {
        echo '<style id="inline-css">' . $output . '</style>';
    }

}