<?php

namespace SSMPB;

function acf_pro_missing_error() {
    echo '<div class="error"><p>SSM Page Builder requires ACF PRO.</p></div>';
}

function acf_pro_is_active() {

    if ( !class_exists('acf_pro') ) {
        add_action('admin_init', __NAMESPACE__ . '\\acf_pro_missing_error');
        return FALSE;

    } else {
        return TRUE;

    }

}

function has_ssm_core_helpers() {

    if ( !function_exists('SSMCore\Helpers\sanitize_html_classes') ) {
        return FALSE;

    } else {
        return TRUE;

    }

}

if ( acf_pro_is_active() == TRUE ) {
    require( get_stylesheet_directory() . '/src/lib/SSMPB/inc/helpers.php');
}

function do_page_builder() {

    if ( acf_pro_is_active() == TRUE && has_ssm_core_helpers() == TRUE ) {

        \get_template_part('templates/page-builder/sections');

    } else {

        if ( is_user_logged_in() ) {

            echo '<p style="text-align:center;">The SSM Page Builder requires SSM Core.</p>';

        }

    }

}

add_action('admin_enqueue_scripts', __NAMESPACE__ . '\\ssmpb_css');

function ssmpb_css() {
    wp_register_style( 'acf-styles', get_template_directory_uri() . '/src/lib/SSMPB/inc/styles/acf.css' );
    wp_enqueue_style( 'acf-styles' );
}
