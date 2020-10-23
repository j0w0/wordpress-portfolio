<?php get_header(); ?>

    <section class="section-padding">
        <div class="container-fluid container-max-width">

            <h2 class="heading-3d-primary h1 mb-4">Software Engineering</h2>

            <div class="post-container mb-5">
                <p>I attended a Software Engineering Immersive from July to October 2020 through General Assembly. While I had previously been a self-taught developer and held a few dev positions up until then, I gained valuable experience through this journey. Learning about and utilizing several programming languages and web frameworks, I developed full-stack applications while applying computer science theories, industry standards, and best practices.</p>
            </div>
            
            <?php get_template_part( 'template-parts/portfolio/home', 'sei' ); ?>

            <a href="<?php echo get_site_url(); ?>/portfolio/category/interactive" class="btn btn-outline-primary btn-secondary-font mt-4">All Dev Projects</a>
            
        </div>
    </section>

    <section class="section-padding bg-light">
        <div class="container-fluid container-max-width">

            <h2 class="heading-3d-primary h1 mb-4">Previous Work</h2>

            <div class="post-container mb-5">
                <p>Before diving into the tech industry and landing my first Front-End Development position, I received my BFA in Communication Design from Texas State University. I then worked in digital marketing creating graphics, emails, websites, and event registration applications. Several of these projects are highlighted below.</p>
            </div>

            <?php get_template_part( 'template-parts/portfolio/home', 'all' ); ?>
            
            <a href="<?php echo get_site_url(); ?>/portfolio" class="btn btn-outline-primary btn-secondary-font mt-4">View All Work</a>
            
        </div>
    </section>

    <section class="section-padding">
        <div class="container-fluid container-max-width">

            <h2 class="heading-3d-primary h1 mb-4">Hello, World</h2>

            <div class="row">
                <div class="col-lg-9">
                    <div class="post-container mb-5">
                        <?php get_template_part( 'template-parts/post/about' ); ?>

                        <p><a href="<?php echo site_url(); ?>/portfolio">Check out my work</a> or <a href="<?php echo site_url(); ?>/contact">get in touch with me</a>.</p>
                    </div>
                </div>

                <aside id="sidebar" class="col-lg-3">
                    <?php get_template_part( 'template-parts/sidebar/contact' ); ?>
                </aside>
            </div>
            
        </div>
    </section>
    
<?php get_footer(); ?>