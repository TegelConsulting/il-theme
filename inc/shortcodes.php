<?php
function il_theme_category_slug_shortcode() {
    wp_enqueue_script('il-theme-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), null, true);

    if (is_category()) {
        $category = get_queried_object();
        wp_localize_script('il-theme-main', 'ilThemeData', array(
            'categoryId' => $category->term_id,
        ));
    }
    return '';
}
add_shortcode('category_slug', 'il_theme_category_slug_shortcode');