<?php

namespace SSMPB;

add_filter('acf/settings/save_json',  __NAMESPACE__ . '\\my_acf_json_save_point');
/**
 *
 * Add our acf-json to the activated theme
 *
 */
function my_acf_json_save_point( $path ) {


    $path = SSMPB_INC . 'acf-json';

    return $path;

}



add_filter('acf/fields/flexible_content/layout_title/name=sections', __NAMESPACE__ . '\\acf_layout_title', 10, 4);
/**
 * Update The Flexible Content Label
 * @since 1.0.0
 */
function acf_layout_title( $title, $field, $layout, $i ) {

    if ( get_sub_field('section_label') ) {

        $label = get_sub_field('section_label');

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

function maybe_do_section_header() { ?>
  <?php if ( get_sub_field('section_headline') || get_sub_field('section_subheadline') ) { ?>

    <div class="row header-wrap">

      <div class="small-12 column">

        <header class="section-header">

          <?php if ( $headline = get_sub_field('section_headline') ) { ?>

          <h1 class="section-headline"><?php echo $headline; ?></h1>

          <?php } ?>

          <?php if ( $subheadline = get_sub_field('section_subheadline') ) { ?>

          <h2 class="section-subheadline"><?php echo $subheadline; ?></h2>

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

function module_id_classes( $m_classes = '' ) {

    $inline_classes = get_sub_field('html_classes');

    $module_id_classes = '';

    if ( $html_id = get_sub_field('html_id') ) {
    $html_id = sanitize_html_class(strtolower($html_id));
    $module_id_classes .= ' id="' . $html_id . '" class="module';
      } else {
        $module_id_classes .= ' class="module';
      }

      if ( $m_classes != NULL ) {
        $m_classes = \SSMCore\Helpers\sanitize_html_classes($m_classes);
        $module_id_classes .= ' ' . $m_classes;

      }

      if ( $inline_classes != NULL ) {
        $module_id_classes .= ' ' . $inline_classes;
      }

      $module_id_classes .= '"';

      return $module_id_classes;

}

function do_module( $template_args = array() ) {

    echo '<div' . module_id_classes( $m_classes ) . '>';

        get_template_part( 'templates/page-builder/components', $template_args );

    echo '</div>';

}

/**
 * Like get_template_part() but lets you pass args to the template file
 * Args are available in the tempalte as $template_args array
 * @param string filepart
 * @param mixed wp_args style argument list
 */
function get_template_part( $file, $template_args = array(), $cache_args = array() ) {
    $template_args = wp_parse_args( $template_args );
    $cache_args = wp_parse_args( $cache_args );
    if ( $cache_args ) {
        foreach ( $template_args as $key => $value ) {
            if ( is_scalar( $value ) || is_array( $value ) ) {
                $cache_args[$key] = $value;
            } else if ( is_object( $value ) && method_exists( $value, 'get_id' ) ) {
                $cache_args[$key] = call_user_method( 'get_id', $value );
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

function do_inline_css() {

    global $post;
    $styles = array();

    if( have_rows( 'sections', $post->ID ) ) {

        while( have_rows ( 'sections', $post->ID ) ) {
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

add_action('wp_head', __NAMESPACE__ . '\\do_inline_css', 99);