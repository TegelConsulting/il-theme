<?php
function il_theme_setup()
{
    // Add support for block templates
    add_theme_support('block-templates');

    // Add support for featured images
    add_theme_support('post-thumbnails');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'il-theme'),
    ));
}

add_action('after_setup_theme', 'il_theme_setup');

function il_theme_enqueue_styles()
{
    wp_enqueue_style('il-theme-style', get_stylesheet_uri());
    wp_enqueue_style('il-theme-main-style', get_template_directory_uri() . '/assets/css/style.css');
    wp_enqueue_style('il-theme-header-style', get_template_directory_uri() . '/assets/css/header.css');
    wp_enqueue_style('il-theme-footer-style', get_template_directory_uri() . '/assets/css/footer.css');
    wp_enqueue_style('il-theme-animations-style', get_template_directory_uri() . '/assets/css/animations.css');
    wp_enqueue_style('il-theme-posts-style', get_template_directory_uri() . '/assets/css/posts.css');
    wp_enqueue_style('il-theme-font-1', 'https://fonts.googleapis.com');
    wp_enqueue_style('il-theme-font-2', 'https://fonts.gstatic.com');
    wp_enqueue_style('il-theme-font-3', 'https://fonts.googleapis.com/css2?family=Libre+Caslon+Text:ital,wght@0,400;0,700;1,400&display=swap');
}

add_action('wp_enqueue_scripts', 'il_theme_enqueue_styles');

function il_theme_enqueue_scripts()
{
    wp_enqueue_script('il-theme-main-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'il_theme_enqueue_scripts');

function il_theme_customize_register($wp_customize)
{
    $wp_customize->add_section('il_theme_images_section', array(
        'title' => __('Theme pictures', 'il-theme'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('il_theme_hero_image', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'il_theme_hero_image', array(
        'label' => __('Hero Image', 'il-theme'),
        'section' => 'il_theme_images_section',
        'settings' => 'il_theme_hero_image',
    )));

    $wp_customize->add_setting('il_theme_blog_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'il_theme_blog_logo', array(
        'label' => __('Blog logo', 'il-theme'),
        'section' => 'il_theme_images_section',
        'settings' => 'il_theme_blog_logo',
    )));
}

add_action('customize_register', 'il_theme_customize_register');

function il_theme_create_about_me_page() {
    // Check if the page already exists
    $page_check = get_page_by_title('Om mig');
    if (!isset($page_check->ID)) {
        // Create the "About Me" page
        $about_me_page = array(
            'post_title'    => 'Om mig',
            'post_content'  => 'Detta är det vanliga innehållet för sidan Om mig.',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_author'   => 1,
            'page_template' => 'page.php'
        );
        wp_insert_post($about_me_page);
    }

    $page_check = get_page_by_title('Kontakt');
    if (!isset($page_check->ID)) {
        // Create the "About Me" page
        $about_me_page = array(
            'post_title'    => 'Kontakt',
            'post_content'  => 'This is the contact form stuff',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_author'   => 1,
            'page_template' => 'page.php'
        );
        wp_insert_post($about_me_page);
    }
}
add_action('after_switch_theme', 'il_theme_create_about_me_page');

function il_theme_register_custom_blocks() {
    // Register the custom block
    register_block_type(__DIR__ . '/blocks/hero', array(
        'render_callback' => 'il_theme_render_hero_block',
    ));
}
add_action('init', 'il_theme_register_custom_blocks');

function il_theme_render_hero_block($attributes) {
    $hero_image_url = esc_url(get_theme_mod('il_theme_hero_image'));
    ob_start();
    ?>
    <div class="hero box" style="background-image: url('<?php echo $hero_image_url; ?>');">
        <section>Hej och välkommen till min blogg!</section>
    </div>
    <?php
    return ob_get_clean();
}