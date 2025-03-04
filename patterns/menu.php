<?php
/**
 * Title: Menu
 * Slug: themeslug/menu
 * Categories: featured
 */
?>

<?php
        if (has_nav_menu('primary')) {
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => true,
                'before' => '<span>',
                'after' => '</span>',
                'fallback_cb' => false,
                'walker' => new Walker_Nav_Menu_Spacer()
            ));
        } else {
            echo '<span>No menu assigned!</span>';
        }
        ?>


