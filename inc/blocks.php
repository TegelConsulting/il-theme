<?php
function il_theme_register_custom_blocks() {
    // Register the custom block
    register_block_type(__DIR__ . '/../blocks/hero', array(
        'render_callback' => 'il_theme_render_hero_block',
    ));

    register_block_type(__DIR__ . '/../blocks/coverimage', array(
        'render_callback' => 'il_theme_render_coverimage_block',
    ));

    register_block_type(__DIR__ . '/../blocks/highlight', array(
        'render_callback' => 'il_theme_render_highlight_block',
    ));

    register_block_type(__DIR__ . '/../blocks/carousel', array(
        'render_callback' => 'il_theme_render_carousel_block',
    ));

    register_block_type(__DIR__ . '/../blocks/highlights', array(
        'render_callback' => 'il_theme_render_highlights_block',
    ));

    register_block_type(__DIR__ . '/../blocks/herovideo', array(
        'render_callback' => 'il_theme_render_hero_video_block',
    ));

    register_block_type(__DIR__ . '/../blocks/categories', array(
        'render_callback' => 'il_theme_render_categories_block',
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
    $container_class = 'highlights';

    if ($post_count % 2 == 0) {
        $container_class .= ' even-posts';
    } else {
        $container_class .= ' odd-posts';
    }

    if ($query->have_posts()) {
        echo '<div class="' . $container_class . '">';
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $coverImageUrl = get_post_meta($post_id, '_il_theme_coverimage', true);
            $post_title = get_the_title();
            $post_link = get_permalink();

            echo '<div class="item">';
            if ($coverImageUrl) {
                echo '<div class="item__background" style="background-image: url(' . esc_url($coverImageUrl) . ');">    
                        <h3><a href="' . esc_url($post_link) . '">' . esc_html($post_title) . '</a></h3>
                    </div>';
            } else {
                echo '<div class="item__background">
                        <h3><a href="' . esc_url($post_link) . '">' . esc_html($post_title) . '</a></h3>
                    </div>';
            }
            echo '</div>';
        }
        echo '</div>';
        wp_reset_postdata();
    } else {
        echo '<div>No posts found</div>';
    }
    return ob_get_clean();
}

function il_theme_render_hero_video_block($attributes) {
    ob_start();
    ?>
        <div class="video box">
            <video autoplay loop muted>
                <source src="http://localhost/wordpress/wp-content/uploads/2025/03/IMG_6475.mov" type="video/mp4">
            </video>
        </div>  
    <?php
    return ob_get_clean();
}

function il_theme_render_categories_block($attributes) {
    // Get all categories except the "Uncategorized" category
    $categories = get_categories(array(
        'exclude' => 1 // Exclude the "Uncategorized" category (ID 1)
    ));

    ob_start();
    if (!empty($categories)) {
        echo '<div class="categories">';
        foreach ($categories as $category) {
            $image_url = get_term_meta($category->term_id, 'category_image', true);
            echo '<div class="category" style="background-image: url(' . $image_url . '">';
                echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<div class="categories">No categories found</div>';
    }
    return ob_get_clean();
}

function il_theme_register_block_patterns() {
    register_block_pattern(
        'iltheme/previous-posts',
        array(
            'title'       => __('Previous posts', 'iltheme'),
            'description' => _x('A heading for previous posts', 'Block pattern description', 'il-theme'),
            'content'     => '<!-- wp:heading {"level":3} --><h3>' . esc_html__('Previous posts', 'iltheme') . '</h3><!-- /wp:heading -->',
            'categories'  => array('text'),
        )
    );
}
add_action('init', 'il_theme_register_block_patterns');