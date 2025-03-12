<?php
function il_theme_setup() {
    add_theme_support('block-templates');

    add_theme_support('post-thumbnails');

    add_theme_support('comments');

    add_theme_support('menus');
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'il-theme'),
    ));
}
add_action('after_setup_theme', 'il_theme_setup');

