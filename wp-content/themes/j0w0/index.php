<?php get_header(); ?>

    <section class="section-padding">
        <div class="container-fluid container-max-width">

            <h2 class="heading-3d-primary h1 mb-4">Web Development</h2>

            <?php get_template_part('template-parts/portfolio/home', 'web'); ?>

            <a href="<?= get_site_url(); ?>/portfolio/category/interactive" class="btn btn-outline-primary btn-secondary-font mt-4">All Dev Projects</a>
            
        </div>
    </section>

    <section class="section-padding bg-light">
        <div class="container-fluid container-max-width">

            <h2 class="heading-3d-primary h1 mb-4">Early Career</h2>

            <div class="post-container mb-5">
                <p>I received my BFA in Communication Design from Texas State University. I then worked in digital marketing creating graphics, email campaigns, websites, and event registration web apps. Several of these projects are highlighted below.</p>
            </div>

            <?php get_template_part('template-parts/portfolio/home', 'all'); ?>
            
            <a href="<?= get_site_url(); ?>/portfolio" class="btn btn-outline-primary btn-secondary-font mt-4">View All Work</a>
            
        </div>
    </section>

    <section class="section-padding">
        <div class="container-fluid container-max-width">

            <h2 class="heading-3d-primary h1 mb-4">Hello, World</h2>

            <div class="row">
                <div class="col-lg-9">
                    <div class="post-container mb-5">
                        <?php get_template_part('template-parts/post/about'); ?>

                        <p><a href="<?= site_url(); ?>/portfolio">Check out my work</a> or <a href="<?= site_url(); ?>/contact">get in touch with me</a>.</p>
                    </div>
                </div>

                <aside id="sidebar" class="col-lg-3">
                    <?php get_template_part('template-parts/sidebar/contact'); ?>
                </aside>
            </div>
            
        </div>
    </section>
    
<?php get_footer(); ?>