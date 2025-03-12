<?php
// filepath: c:\MAMP\htdocs\wordpress\wp-content\themes\iltheme\inc\enqueue-scripts.php

function il_theme_enqueue_styles() {
    wp_enqueue_style('iltheme-style', get_stylesheet_uri());
    wp_enqueue_style('iltheme-main-style', get_template_directory_uri() . '/assets/css/style.css');
    wp_enqueue_style('iltheme-header-style', get_template_directory_uri() . '/assets/css/header.css');
    wp_enqueue_style('iltheme-footer-style', get_template_directory_uri() . '/assets/css/footer.css');
    wp_enqueue_style('iltheme-animations-style', get_template_directory_uri() . '/assets/css/animations.css');
    wp_enqueue_style('iltheme-posts-style', get_template_directory_uri() . '/assets/css/posts.css');
    wp_enqueue_style('iltheme-page-style', get_template_directory_uri() . '/assets/css/page.css');
    wp_enqueue_style('iltheme-carousel-style', get_template_directory_uri() . '/assets/css/carousel.css');
    wp_enqueue_style('iltheme-highlights-style', get_template_directory_uri() . '/assets/css/highlights.css');
    wp_enqueue_style('iltheme-categories-style', get_template_directory_uri() . '/assets/css/categories.css');
    wp_enqueue_style('iltheme-font-1', 'https://fonts.googleapis.com');
    wp_enqueue_style('iltheme-font-2', 'https://fonts.gstatic.com');
    wp_enqueue_style('iltheme-font-3', 'https://fonts.googleapis.com/css2?family=Libre+Caslon+Text:ital,wght@0,400;0,700;1,400&display=swap');
}
add_action('wp_enqueue_scripts', 'il_theme_enqueue_styles');

function il_theme_enqueue_scripts() {
    wp_enqueue_script('iltheme-main-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'il_theme_enqueue_scripts');

function il_theme_enqueue_category_media() {
    if (isset($_GET['taxonomy']) && $_GET['taxonomy'] === 'category') {
        wp_enqueue_media();
        wp_enqueue_script('iltheme-category-media', get_template_directory_uri() . '/assets/js/category-media.js', array('jquery'), null, true);
    }
}
add_action('admin_enqueue_scripts', 'il_theme_enqueue_category_media');

function il_theme_enqueue_carousel_assets() {
    wp_enqueue_script('wp-i18n');
    wp_enqueue_style('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css');
    wp_enqueue_style('owl-carousel-theme', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css');
    wp_enqueue_script('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery'), null, true);
    wp_enqueue_script('iltheme-carousel', get_template_directory_uri() . '/assets/js/carousel.js', array('jquery', 'owl-carousel','wp-i18n'), null, true);
    wp_set_script_translations('carousel', 'iltheme', get_template_directory() . '/languages');
}
add_action('wp_enqueue_scripts', 'il_theme_enqueue_carousel_assets');

function il_theme_enqueue_block_editor_assets() {
    wp_enqueue_script(
        'iltheme-hero-block',
        get_template_directory_uri() . '/blocks/hero/index.js',
        array('wp-blocks', 'wp-element', 'wp-editor'),
        filemtime(get_template_directory() . '/blocks/hero/index.js')
    );

    // Localize the script with the hero image URL
    wp_localize_script('iltheme-hero-block', 'ilThemeHeroBlock', array(
        'heroImageUrl' => esc_url(get_theme_mod('il_theme_hero_image')),
    ));

    // Enqueue editor styles
    wp_enqueue_style(
        'iltheme-editor-style',
        get_template_directory_uri() . '/assets/css/style.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/style.css')
    );
    wp_enqueue_style(
        'iltheme-editor-header-style',
        get_template_directory_uri() . '/assets/css/header.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/header.css')
    );

    wp_enqueue_style(
        'iltheme-editor-posts-style',
        get_template_directory_uri() . '/assets/css/posts.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/posts.css')
    );
}
add_action('enqueue_block_editor_assets', 'il_theme_enqueue_block_editor_assets');

function il_theme_enqueue_admin_scripts($hook) {
    if ($hook !== 'post.php' && $hook !== 'post-new.php') {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_script('iltheme-admin-script', get_template_directory_uri() . '/assets/js/admin.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'il_theme_enqueue_admin_scripts');