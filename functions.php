<?php
function il_theme_setup()
{
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

function il_theme_enqueue_styles()
{
    wp_enqueue_style('il-theme-style', get_stylesheet_uri());
    wp_enqueue_style('il-theme-main-style', get_template_directory_uri() . '/assets/css/style.css');
    wp_enqueue_style('il-theme-header-style', get_template_directory_uri() . '/assets/css/header.css');
    wp_enqueue_style('il-theme-footer-style', get_template_directory_uri() . '/assets/css/footer.css');
    wp_enqueue_style('il-theme-animations-style', get_template_directory_uri() . '/assets/css/animations.css');
    wp_enqueue_style('il-theme-posts-style', get_template_directory_uri() . '/assets/css/posts.css');
    wp_enqueue_style('il-theme-page-style', get_template_directory_uri() . '/assets/css/page.css');
    wp_enqueue_style('il-theme-carousel-style', get_template_directory_uri() . '/assets/css/carousel.css');
    wp_enqueue_style('il-theme-highlights-style', get_template_directory_uri() . '/assets/css/highlights.css');
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

function il_theme_enqueue_carousel_assets() {
    wp_enqueue_style('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css');
    wp_enqueue_style('owl-carousel-theme', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css');
    wp_enqueue_script('owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', array('jquery'), null, true);
    wp_enqueue_script('il-theme-carousel', get_template_directory_uri() . '/assets/js/carousel.js', array('jquery', 'owl-carousel'), null, true);
}
add_action('wp_enqueue_scripts', 'il_theme_enqueue_carousel_assets');

function il_theme_enqueue_block_editor_assets() {
    wp_enqueue_script(
        'il-theme-hero-block',
        get_template_directory_uri() . '/blocks/hero/index.js',
        array('wp-blocks', 'wp-element', 'wp-editor'),
        filemtime(get_template_directory() . '/blocks/hero/index.js')
    );

    // Localize the script with the hero image URL
    wp_localize_script('il-theme-hero-block', 'ilThemeHeroBlock', array(
        'heroImageUrl' => esc_url(get_theme_mod('il_theme_hero_image')),
    ));

    // Enqueue editor styles
    wp_enqueue_style(
        'il-theme-editor-style',
        get_template_directory_uri() . '/assets/css/style.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/style.css')
    );
    wp_enqueue_style(
        'il-theme-editor-header-style',
        get_template_directory_uri() . '/assets/css/header.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/header.css')
    );

    wp_enqueue_style(
        'il-theme-editor-posts-style',
        get_template_directory_uri() . '/assets/css/posts.css',
        array(),
        filemtime(get_template_directory() . '/assets/css/posts.css')
    );
}
add_action('enqueue_block_editor_assets', 'il_theme_enqueue_block_editor_assets');

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

    $wp_customize->add_section('il_theme_hero_section', array(
        'title' => __('Hero content', 'il-theme'),
        'priority' => 40,
    ));

    $wp_customize->add_setting('il_theme_hero_content', array(
        'default' => '',
        'sanitize_callback' => '',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'il_theme_hero_content', array(
        'label' => __('Hero Content', 'il-theme'),
        'section' => 'il_theme_hero_section',
        'settings' => 'il_theme_hero_content',
        'type' => 'textarea'
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

require_once get_template_directory() . '/inc/class-walker-nav-menu-spacer.php';

function il_theme_register_custom_blocks() {
    // Register the custom block
    register_block_type(__DIR__ . '/blocks/hero', array(
        'render_callback' => 'il_theme_render_hero_block',
    ));

    register_block_type(__DIR__ . '/blocks/coverimage', array(
        'render_callback' => 'il_theme_render_coverimage_block',
    ));

    register_block_type(__DIR__ . '/blocks/highlight', array(
        'render_callback' => 'il_theme_render_highlight_block',
    ));

    register_block_type(__DIR__ . '/blocks/carousel', array(
        'render_callback' => 'il_theme_render_carousel_block',
    ));

    register_block_type(__DIR__ . '/blocks/highlights', array(
        'render_callback' => 'il_theme_render_highlights_block',
    ));
}
add_action('init', 'il_theme_register_custom_blocks');

function il_theme_render_hero_block($attributes) {
    $hero_image_url = esc_url(get_theme_mod('il_theme_hero_image'));
    $hero_image_content = get_theme_mod('il_theme_hero_content');
    ob_start();
    ?>
    <div class="wp-block-cover alignfull no-padding">
        <div class="wp-block-cover__inner-container">
            <div class="hero box" style="background-image: url('<?php echo $hero_image_url; ?>');">
                <p><?php echo $hero_image_content ?></p>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

function il_theme_add_custom_meta_boxes() {
    add_meta_box(
        'il_theme_coverimage_meta_box',
        __('Cover Image', 'il-theme'),
        'il_theme_coverimage_meta_box_callback',
        'post',
        'side'
    );

    add_meta_box(
        'il_theme_highlight_meta_box',
        __('Highlight', 'il-theme'),
        'il_theme_highlight_meta_box_callback',
        'post',
        'side'
    );
}
add_action('add_meta_boxes', 'il_theme_add_custom_meta_boxes');

function il_theme_coverimage_meta_box_callback($post) {
    wp_nonce_field('il_theme_save_coverimage_meta_box_data', 'il_theme_coverimage_meta_box_nonce');
    $coverimage = get_post_meta($post->ID, '_il_theme_coverimage', true);
    echo '<input type="hidden" id="il_theme_coverimage" name="il_theme_coverimage" value="' . esc_attr($coverimage) . '">';
    echo '<input type="button" id="il_theme_coverimage_button" class="button" value="' . __('Select Cover Image', 'il-theme') . '">';
    echo '<div id="il_theme_coverimage_preview" style="margin-top: 10px;">';
    if ($coverimage) {
        echo '<img src="' . esc_url($coverimage) . '" style="max-width: 100%;">';
    }
    echo '</div>';
}

function il_theme_highlight_meta_box_callback($post) {
    wp_nonce_field('il_theme_save_highlight_meta_box_data', 'il_theme_highlight_meta_box_nonce');
    $highlight = get_post_meta($post->ID, '_il_theme_highlight', true);
    echo '<label for="il_theme_highlight">';
    echo '<input type="checkbox" id="il_theme_highlight" name="il_theme_highlight" value="1"' . checked($highlight, '1', false) . '>';
    echo __('Highlight this post', 'il-theme');
    echo '</label>';
}

function il_theme_save_custom_meta_box_data($post_id) {
    if (!isset($_POST['il_theme_coverimage_meta_box_nonce']) || !wp_verify_nonce($_POST['il_theme_coverimage_meta_box_nonce'], 'il_theme_save_coverimage_meta_box_data')) {
        return;
    }

    if (!isset($_POST['il_theme_highlight_meta_box_nonce']) || !wp_verify_nonce($_POST['il_theme_highlight_meta_box_nonce'], 'il_theme_save_highlight_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['il_theme_coverimage'])) {
        $coverimage = sanitize_text_field($_POST['il_theme_coverimage']);
        update_post_meta($post_id, '_il_theme_coverimage', $coverimage);
    }

    $highlight = isset($_POST['il_theme_highlight']) ? '1' : '';
    update_post_meta($post_id, '_il_theme_highlight', $highlight);
}
add_action('save_post', 'il_theme_save_custom_meta_box_data');

function il_theme_enqueue_admin_scripts($hook) {
    if ($hook !== 'post.php' && $hook !== 'post-new.php') {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_script('il-theme-admin-script', get_template_directory_uri() . '/assets/js/admin.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'il_theme_enqueue_admin_scripts');

function il_theme_render_coverimage_block($attributes, $content) {
    $post_id = get_the_ID();
    $coverImageUrl = get_post_meta($post_id, '_il_theme_coverimage', true);

    ob_start();
    if ($coverImageUrl) {
        echo '<div class="coverimage" style="background-image: url(' . esc_url($coverImageUrl) . ')">
            <h2 class="post__title wp-block-post-title">' . get_the_title() . '</h2>
        </div>';
    }
    return ob_get_clean();
}

function il_theme_render_highlight_block($attributes) {
    $post_id = get_the_ID();
    $highlight = get_post_meta($post_id, '_il_theme_highlight', true);

    ob_start();
    if ($highlight) {
        echo '<div class="highlight"><p>This post is highlighted!</p></div>';
    }
    return ob_get_clean();
}

function il_theme_render_carousel_block($attributes) {
    $query = new WP_Query(array(
        'posts_per_page' => 5,
        'post_status' => 'publish'
    ));

    ob_start();
    if ($query->have_posts()) {
        echo '<div id="carousel" class="carousel owl-carousel">';
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $coverImageUrl = get_post_meta($post_id, '_il_theme_coverimage', true);
            $post_title = get_the_title();
            $post_link = get_permalink();

            echo '<div class="carousel-item item">';
            if ($coverImageUrl) {
                echo '<div class="carousel-content">
                    <div class="carousel-image" style="background-image: url(' . esc_url($coverImageUrl) . ');">    
                        <h3><a href="' . esc_url($post_link) . '">' . esc_html($post_title) . '</a></h3>
                    </div>
                </div>';
            }
            else {
                echo '<div class="carousel-content">
                        <h3><a href="' . esc_url($post_link) . '">' . esc_html($post_title) . '</a></h3>
                    </div>';
            }
            echo '</div>';
        }
        echo '</div>';
        wp_reset_postdata();
    }
    return ob_get_clean();
}

function il_theme_render_highlights_block($attributes) {
    $query = new WP_Query(array(
        'posts_per_page' => 10,
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => '_il_theme_highlight',
                'value' => '1',
                'compare' => '='
            )
        ),
    ));

    ob_start();
    $post_count = $query->found_posts;
    $grid_style = 'display: grid; grid-template-columns: repeat(3, 1fr);';
    if ($post_count == 4) {
        $grid_style = 'display: grid; grid-template-columns: repeat(2, 1fr); grid-template-rows: repeat(2, 1fr);';
    } elseif ($post_count == 5) {
        $grid_style = 'display: grid; grid-template-columns: repeat(4, 1fr); grid-template-rows: repeat(2, 1fr);';
    }

    if ($query->have_posts()) {
        echo '<div class="highlights" style="' . $grid_style . '">';
        $post_index = 0;
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $coverImageUrl = get_post_meta($post_id, '_il_theme_coverimage', true);
            $post_title = get_the_title();
            $post_link = get_permalink();

            $item_style = '';
            if ($post_count == 5 && $post_index == 2) {
                $item_style = 'grid-column: 1 / 2; grid-row: 2 / 3;';
            }
            if ($post_count == 5 && $post_index == 3) {
                $item_style = 'grid-column: 2 / 3; grid-row: 2 / 3;';
            }
            if ($post_count == 5 && $post_index == 4) {
                $item_style = 'grid-column: 3 / 5; grid-row: 1 / span 2; height: calc(300px * 2 + 0.5rem);';
            }

            if ($coverImageUrl) {
                echo '<div class="item" style="' . $item_style . '">
                    <div class="item__background" style="background-image: url(' . esc_url($coverImageUrl) . ');">    
                        <h3><a href="' . esc_url($post_link) . '">' . esc_html($post_title) . '</a></h3>
                    </div>
                </div>';
            }
            else {
                echo '<div class="item">
                        <h3><a href="' . esc_url($post_link) . '">' . esc_html($post_title) . '</a></h3>
                    </div>';
            }
            $post_index++;
        }
        echo '</div>';
        wp_reset_postdata();
    }
    else {
        echo '<div>No posts found</div>';
    }
    return ob_get_clean();
}

function il_theme_load_more_posts() {
    $date = isset($_GET['date']) ? sanitize_text_field($_GET['date']) : '';

    $query_args = array(
        'posts_per_page' => 5,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
    );

    if ($date) {
        $query_args['date_query'] = array(
            array(
                'before' => $date,
                'inclusive' => false,
            ),
        );
    }

    $query = new WP_Query($query_args);

    $posts = array();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $posts[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'link' => get_permalink(),
                'excerpt' => get_the_excerpt(),
                'content' => get_the_content(),
                'date' => get_the_date(), // ISO 8601 format
                'class' => join(' ', get_post_class())
            );
        }
        wp_reset_postdata();
    }

    wp_send_json(array(
        'posts' => $posts,
        'hasMore' => $query->max_num_pages > $query->get('paged')
    ));
}

add_action('rest_api_init', function() {
    register_rest_route('il-theme/v1', '/load-more-posts', array(
        'methods' => 'GET',
        'callback' => 'il_theme_load_more_posts'
     ));
});

function il_theme_custom_post_date_format($block_content, $block) {
    if ($block['blockName'] === 'core/post-date') {
        // Load the post date in the desired format
        $post_date = get_the_date('Y-m-d H:i:s');
        $formatted_date = get_the_date('F j, Y');

        // Use DOMDocument to modify the block content
        $dom = new DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($block_content, 'HTML-ENTITIES', 'UTF-8'));
        $time_element = $dom->getElementsByTagName('time')->item(0);

        if ($time_element) {
            $time_element->setAttribute('datetime', $post_date);
            $time_element->nodeValue = $formatted_date;
        }

        $block_content = $dom->saveHTML($time_element->parentNode);
    }

    return $block_content;
}

add_filter('render_block', 'il_theme_custom_post_date_format', 10, 2);