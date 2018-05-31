<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <?php wp_head(); ?>
    </head>
    
    <body <?php body_class(); ?>>
        
        <header id="masthead">
            
            <div id="masthead-main">
                <a id="logo" href="<?php echo get_site_url(); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logos/web-logo.svg" alt="Josh Woodcock Creative Design" id="logo-img" />
                    <div id="logo-type">
                        Josh Woodcock<br />
                        Creative Design
                    </div>
                </a>
                <div id="mobile-menu-button">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
            
            <?php
            $MainMenuSettings = array(
                'menu' => 'main',
                'menu_class' => 'menu list-unstyled',
                'container' => 'nav',
                'container_id' => 'main-menu',
                'container_class' => 'main-menu-container',
                'link_before' => '[ ',
                'link_after' => ' ]'
            );
            wp_nav_menu($MainMenuSettings);
            ?>
            
        </header>
        
        <?php
        if(is_home() || is_404()) { ?>
            <section id="above-the-fold">
                <div class="pattern-overlay stripe-pattern">
                    <div class="container-fluid container-max-width">
                        
                        <div id="home-intro" class="text-center">
                            <h1 class="heading-3d-primary">Hello, I&rsquo;m Josh.</h1>
                            <h2 class="heading-3d-primary">Graphic Designer &  Web Developer</h2>
                            <a href="<?php echo get_site_url(); ?>/portfolio" class="btn btn-primary btn-lg">View My Work</a>
                        </div>
                        
                    </div>
                </div>
            </section>
        <?php
        }
        ?>
        
        <section id="page-content">