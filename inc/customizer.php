<?php
// filepath: c:\MAMP\htdocs\wordpress\wp-content\themes\iltheme\inc\customizer.php

function il_theme_customize_register($wp_customize) {
    $wp_customize->add_section('il_theme_images_section', array(
        'title' => __('Theme pictures', 'iltheme'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('il_theme_hero_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'il_theme_hero_image', array(
        'label' => __('Hero Image', 'iltheme'),
        'section' => 'il_theme_images_section',
        'settings' => 'il_theme_hero_image',
    )));

    $wp_customize->add_setting('il_theme_blog_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'il_theme_blog_logo', array(
        'label' => __('Blog logo', 'iltheme'),
        'section' => 'il_theme_images_section',
        'settings' => 'il_theme_blog_logo',
    )));

    $wp_customize->add_section('il_theme_hero_section', array(
        'title' => __('Hero content', 'iltheme'),
        'priority' => 40,
    ));

    $wp_customize->add_setting('il_theme_hero_content', array(
        'default' => '',
        'sanitize_callback' => '',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'il_theme_hero_content', array(
        'label' => __('Hero Content', 'iltheme'),
        'section' => 'il_theme_hero_section',
        'settings' => 'il_theme_hero_content',
        'type' => 'textarea'
    )));
}
add_action('customize_register', 'il_theme_customize_register');