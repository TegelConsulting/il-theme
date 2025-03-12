<?php
// filepath: c:\MAMP\htdocs\wordpress\wp-content\themes\IL-theme\inc\setup.php

function il_theme_setup() {
    // Add support for block templates
    add_theme_support('block-templates');

    // Add support for featured images
    add_theme_support('post-thumbnails');

    add_theme_support('comments');

    // Register navigation menus
    add_theme_support('menus');
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'il-theme'),
    ));
}
add_action('after_setup_theme', 'il_theme_setup');

