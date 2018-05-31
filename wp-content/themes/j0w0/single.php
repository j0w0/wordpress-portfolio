<?php get_header(); ?>
    
    <?php
    if(have_posts()) {
        while(have_posts()) {
            the_post();
            ?>
            
            <main>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    
                    <?php get_template_part( 'template-parts/post/hero' ); ?>
                    
                    <div class="container-fluid container-max-width section-padding">
                        <div class="row">
                            
                            <section id="content" class="col-md-7 mb-4 mb-md-0">
                                <?php get_template_part( 'template-parts/post/content' ); ?>
                            </section>
                            
                            <aside id="sidebar" class="col-md-4 offset-md-1">
                                <?php get_template_part( 'template-parts/post/related-category' ); ?>
                                <?php get_template_part( 'template-parts/post/related-tag' ); ?>
                                <?php get_template_part( 'template-parts/sidebar/contact' ); ?>
                            </aside>
                            
                        </div>
                    </div>
                    
                </article>
            </main>
            
        <?php
        }
    }
    ?>
    
<?php get_footer(); ?>