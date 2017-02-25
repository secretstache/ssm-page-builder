<?php
namespace SSMPB;

define( 'SSMPB_VERSION', '0.1');
define( 'SSMPB_DIR', trailingslashit( get_stylesheet_directory() . '/src/lib/SSMPB' ) );
define( 'SSMPB_DIR_URI', trailingslashit( get_stylesheet_directory_uri() . '/src/lib/SSMPB' ) );
define( 'SSMPB_INC', trailingslashit( SSMPB_DIR . 'inc' ) );
define( 'SSMPB_INC_URI', trailingslashit( SSMPB_DIR_URI . 'inc' ) );

require( SSMPB_INC . 'helpers.php');

function do_page_builder( ) {
    \get_template_part( 'src/lib/SSMPB/inc/page-builder/content-blocks');
}

add_action('admin_enqueue_scripts', __NAMESPACE__ . '\\css');


function css() {
    wp_register_style( 'ssmpb-styles', SSMPB_INC_URI . 'styles/ssmpb.css', '', SSMPB_VERSION );
    wp_enqueue_style( 'ssmpb-styles' );
}

add_action('admin_enqueue_scripts', __NAMESPACE__ . '\\js');

function js() {
    wp_register_script( 'ssmpb-scripts', SSMPB_INC_URI . 'scripts/ssmpb.js', array('jquery'), SSMPB_VERSION );
    wp_enqueue_script( 'ssmpb-scripts' );
}