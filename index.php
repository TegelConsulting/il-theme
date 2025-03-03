    <?php get_header(); ?>

    <div class="content">
        <div class="hero" style="background-image: url('<?php echo esc_url(get_theme_mod('il_theme_hero_image')); ?>');">
            
                <section>
                    Hej och välkommen till min blogg!
                </section>
            
        </div>
        <div>
            Posts
        <!-- <?php
            // Start the loop
            if (have_posts()) :
                while (have_posts()) : the_post();
            ?>
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
        ?> -->
        </div>
    </div>

    <?php get_footer(); ?>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/main.js"></script>
    <!-- <?php wp_footer(); ?> -->
</body>

</html>