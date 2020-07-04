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
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logos/web-logo.svg" alt="Josh Woodcock, Designer and Developer" id="logo-img" />
                    <div id="logo-type">
                        Josh Woodcock<br />
                        Designer + Developer
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
                            <h1 class="heading-3d-primary"><span id="hello">Hey, I&rsquo;m Josh</span></h1>
                            <h2 class="heading-3d-primary"><span id="titles"></span></h2>
                            <a href="<?php echo get_site_url(); ?>/portfolio" class="btn btn-primary btn-lg btn-secondary-font mt-3">View My Work</a>
                        </div>

                        <div id="strings-to-type">
                            <p>Front-End Developer</p>
                            <p>Visual Designer</p>
                        </div>
                        
                    </div>
                </div>
            </section>
        <?php
        }
        ?>
        
        <section id="page-content">