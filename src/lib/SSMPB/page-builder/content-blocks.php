<?php

if ( ! post_password_required() ) {

    if (have_rows('content_blocks')) {

        global $s_i;

        if (get_the_content()) {
            $s_i = 2;
        } else {
            $s_i = 1;
        }

        while (have_rows('content_blocks')) {

            the_row();

            if (get_row_layout() == 'wrapper_open') {

                SSMPB\hm_get_template_part( SSMPB_DIR . 'page-builder/content-blocks/wrapper-open.php');

            } elseif (get_row_layout() == 'one_column') {

                SSMPB\hm_get_template_part( SSMPB_DIR . 'page-builder/content-blocks/one-column.php');

            } elseif (get_row_layout() == 'two_columns') {

                SSMPB\hm_get_template_part( SSMPB_DIR . 'page-builder/content-blocks/two-columns.php');

            } elseif (get_row_layout() == 'three_columns') {

                SSMPB\hm_get_template_part( SSMPB_DIR . 'page-builder/content-blocks/three-columns.php');

            } elseif (get_row_layout() == 'four_columns') {

                SSMPB\hm_get_template_part( SSMPB_DIR . 'page-builder/content-blocks/four-columns.php');

            } elseif (get_row_layout() == 'wrapper_close') {

                SSMPB\hm_get_template_part( SSMPB_DIR . 'page-builder/content-blocks/wrapper-close.php');

            }

            $wrapper_open = get_row_layout() == 'wrapper_open';
            $wrapper_close = get_row_layout() == 'wrapper_close';

            if (!$wrapper_open && !$wrapper_close) {
                $s_i++;
            }

        }

    }

}
