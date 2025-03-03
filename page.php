<?php
// filepath: /C:/MAMP/htdocs/wordpress/wp-content/themes/IL-theme/page-template.php
/*
Template Name: Page template
*/
get_header();
?>
<main class="content">
    <div class="top-margin"></div>
<?php

    // Start the loop
    if (have_posts()) :
        while (have_posts()) : the_post();
    ?>
    <div class="container">
            <h1><?php the_title(); ?></h1>
            <div>
                <?php the_content(); ?>
            </div>
    <?php
        endwhile;
    else :
        ?>
            <p><?php esc_html_e('Sorry, no content found.'); ?></p>
        <?php
        endif;
        ?>
        </div>
</main>

<?php get_footer(); ?>