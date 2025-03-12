<?php
// filepath: c:\MAMP\htdocs\wordpress\wp-content\themes\IL-theme\inc\meta-boxes.php

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

function il_theme_add_category_image_field($term) {
    $image_url = get_term_meta($term->term_id, 'category_image', true);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="category_image"><?php _e('Category Image', 'il-theme'); ?></label>
        </th>
        <td>
            <input type="hidden" name="category_image" id="category_image" value="<?php echo esc_attr($image_url); ?>" />
            <div id="category_image_preview" style="margin-bottom: 10px;">
                <?php if ($image_url) : ?>
                    <img src="<?php echo esc_url($image_url); ?>" style="max-width: 100%;" />
                <?php endif; ?>
            </div>
            <input type="button" class="button" id="category_image_button" value="<?php _e('Upload/Add Image', 'il-theme'); ?>" />
            <input type="button" class="button" id="category_image_remove_button" value="<?php _e('Remove Image', 'il-theme'); ?>" />
            <p class="description"><?php _e('Upload or add an image for this category.', 'il-theme'); ?></p>
        </td>
    </tr>
    <script>
        jQuery(document).ready(function($) {
            $('#category_image_button').click(function(e) {
                e.preventDefault();
                var image = wp.media({
                    title: '<?php _e('Upload/Add Image', 'il-theme'); ?>',
                    multiple: false
                }).open()
                .on('select', function() {
                    var uploaded_image = image.state().get('selection').first();
                    var image_url = uploaded_image.toJSON().url;
                    $('#category_image').val(image_url);
                    $('#category_image_preview').html('<img src="' + image_url + '" style="max-width: 100%;" />');
                });
            });

            $('#category_image_remove_button').click(function(e) {
                e.preventDefault();
                $('#category_image').val('');
                $('#category_image_preview').html('');
            });
        });
    </script>
    <?php
}
add_action('category_edit_form_fields', 'il_theme_add_category_image_field');
add_action('category_add_form_fields', 'il_theme_add_category_image_field');

// Save the category image URL
function il_theme_save_category_image($term_id) {
    if (isset($_POST['category_image'])) {
        update_term_meta($term_id, 'category_image', sanitize_text_field($_POST['category_image']));
    }
}
add_action('edited_category', 'il_theme_save_category_image');
add_action('create_category', 'il_theme_save_category_image');