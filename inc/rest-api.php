<?php
function il_theme_load_more_posts() {
    $date = isset($_GET['date']) ? sanitize_text_field($_GET['date']) : '';
    $category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
    $paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
    
    $query_args = array(
        'posts_per_page' => 1,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => $paged
    );

    if ($date) {
        $query_args['date_query'] = array(
            array(
                'before' => $date,
                'inclusive' => false,
            ),
        );
    }

    if ($category_id) {
        $query_args['cat'] = $category_id;
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
                'date' => get_the_date('c'), // ISO 8601 format
                'class' => join(' ', get_post_class())
            );
        }
        wp_reset_postdata();
    }

    wp_send_json(array(
        'posts' => $posts,
        'hasMore' => $query->max_num_pages > $paged,
        'page' => $paged,
    ));
}
add_action('rest_api_init', function() {
    register_rest_route('iltheme/v1', '/load-more-posts', array(
        'methods' => 'GET',
        'callback' => 'il_theme_load_more_posts'
     ));
});

function il_theme_load_more_posts_main() {
    $paged = isset($_GET['page']) ? intval($_GET['page']) : 1;

    $query_args = array(
        'posts_per_page' => 5,
        'post_status' => 'publish',
        'paged' => $paged,
    );

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
                'date' => get_the_date('c'), // ISO 8601 format
                'class' => join(' ', get_post_class())
            );
        }
        wp_reset_postdata();
    }

    wp_send_json(array(
        'posts' => $posts,
        'max_num_pages' => $query->max_num_pages,
    ));
}
add_action('rest_api_init', function() {
    register_rest_route('iltheme/v1', '/load-more-posts-main', array(
        'methods' => 'GET',
        'callback' => 'il_theme_load_more_posts_main'
    ));
});