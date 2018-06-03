<?php get_header(); ?>
    
    <section class="section-padding">
        <div class="container-fluid container-max-width">
            
            <div id="work-intro" class="text-center">
                <h2 class="heading-3d-primary">My Work</h2>
                <p>I specialize in web/graphic design and web development.<br />
                I create graphics using Adobe Creative Cloud. I create responsive websites using WordPress, HTML5, CSS3, and jQuery.</p>
            </div>
            
            <?php get_template_part( 'template-parts/portfolio/items', 'home' ); ?>
            
            <div class="text-center">
                <a href="<?php echo get_site_url(); ?>/portfolio" class="btn btn-outline-primary btn-lg btn-secondary-font">View All Work</a>
            </div>
            
        </div>
    </section>
    
<?php get_footer(); ?>