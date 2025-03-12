<?php
function il_theme_setup() {
    add_theme_support('block-templates');
    add_theme_support('post-thumbnails');
    add_theme_support('comments');

    load_theme_textdomain('iltheme', get_template_directory() . '/languages');

    add_theme_support('menus');
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'iltheme'),
    ));
}
add_action('after_setup_theme', 'il_theme_setup');

