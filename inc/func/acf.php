<?php

add_action('acf/init', 'my_acf_op_init');
function my_acf_op_init() {

    // Check function exists.
    if( function_exists('acf_add_options_page') ) {

        // Register options page.
        $option_page = acf_add_options_page(array(
            'page_title'    => __('Дополнительные настройки сайта'),
            'menu_title'    => __('Настройки сайта'),
            'menu_slug'     => 'theme-general-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false
        ));
    }
}