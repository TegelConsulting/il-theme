<!DOCTYPE html>
<html lang=<?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Text:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/header.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/footer.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/animations.css">
    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/main.js" defer></script>
    <title><?php bloginfo('name'); ?></title>
</head>
<body>
    <div class="content">
        <header id="header" class="transparent-header">
            <!-- <div class="logo">
                <a href="<?php echo home_url(); ?>">
                    <img src="<?php echo esc_url(get_theme_mod('il_theme_blog_logo')); ?>" alt="<?php bloginfo('name'); ?>">
                </a>
            </div> -->
            <nav class="navigation">
                <button
                    class="burger"
                    type="button"
                    aria-label="Toggle menu"
                    aria-expanded="false"
                >
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="menu">
                    <span><a href="<?php echo home_url(); ?>">Hem</a></span>
                    <div class="spacer">|</div>
                    <span><a href="<?php echo home_url('/om-mig'); ?>">Om mig</a></span>
                    <div class="spacer">|</div>
                    <span><a href="<?php echo home_url('/kontakt'); ?>">Kontakt</a></span>
                </div>
            </nav>
            <h3 class="center">Isabel Lindström</h3>
        </header>
