<?php

namespace SSMPB;

function do_page_builder( ) {
    \get_template_part('templates/page-builder/sections');
}

add_action('admin_enqueue_scripts', __NAMESPACE__ . '\\ssmpb_css');

function ssmpb_css() {
    wp_register_style( 'acf-styles', SSMPB_INC . 'styles/acf.css' );
    wp_enqueue_style( 'acf-styles' );
}
