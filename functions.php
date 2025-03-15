<?php
require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/scripts.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/blocks.php';
require_once get_template_directory() . '/inc/class-walker-nav-menu-spacer.php';
require_once get_template_directory() . '/inc/meta-boxes.php';
require_once get_template_directory() . '/inc/rest-api.php';


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

function il_theme_category_slug_shortcode() {
    wp_enqueue_script('iltheme-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), null, true);

    if (is_category()) {
        $category = get_queried_object();
        wp_localize_script('iltheme-main', 'ilThemeData', array(
            'categoryId' => $category->term_id,
        ));
    }
    return '';
}
add_shortcode('category_slug', 'il_theme_category_slug_shortcode');

//Include the theme update checker library
require get_template_directory() . '/lib/plugin-update-checker-5.5/plugin-update-checker.php';

// Initialize the theme update checker
// $theme_update_checker = new ThemeUpdateChecker(
//     'iltheme',
//     'https://raw.githubusercontent.com/TegelConsulting/il-theme/main/theme-update.json'
// );
$theme_update_checker = new YahnisElsts\PluginUpdateChecker\v5p5\Theme\UpdateChecker(
    'https://raw.githubusercontent.com/TegelConsulting/il-theme/main/theme-update.json',
    __FILE__,
    'iltheme'
);