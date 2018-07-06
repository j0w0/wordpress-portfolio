<?php get_header(); ?>
    
    <section class="section-padding">
        <div class="container-fluid container-max-width">
            
            <div id="work-intro" class="text-center post-container">
                <h2 class="heading-3d-primary">My Work</h2>
                <p>I design and develop interactive, data-driven websites and web applications.</p>
                <p>I received my BFA in Communication Design, but found my way into the realm of web design and development. My process includes designing in Illustrator and then transforming that design into a responsive website using HTML, CSS, jQuery/Javascript, and Wordpress.</p>
                <p>Among these web projects, my portfolio also consists of my past graphic design work.</p>
            </div>
            
            <?php get_template_part( 'template-parts/portfolio/items', 'home' ); ?>
            
            <div class="text-center">
                <a href="<?php echo get_site_url(); ?>/portfolio" class="btn btn-outline-primary btn-lg btn-secondary-font">View All Work</a>
            </div>
            
        </div>
    </section>
    
<?php get_footer(); ?>