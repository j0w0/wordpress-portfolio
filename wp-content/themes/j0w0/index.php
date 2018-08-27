<?php get_header(); ?>
    
    <section class="section-padding">
        <div class="container-fluid container-max-width">
            
            <div id="work-intro" class="text-center post-container">
                <p>I design and develop interactive, data-driven mobile websites and web applications. <a href="<?php echo site_url(); ?>/portfolio">Check out my work</a> or <a href="<?php echo site_url(); ?>/contact">get in touch with me</a>.</p>
            </div>
            
            <?php get_template_part( 'template-parts/portfolio/items', 'home' ); ?>
            
            <div class="text-center">
                <a href="<?php echo get_site_url(); ?>/portfolio" class="btn btn-outline-primary btn-lg btn-secondary-font">View All Work</a>
            </div>
            
        </div>
    </section>
    
<?php get_footer(); ?>