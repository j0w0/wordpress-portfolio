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
                                
                                <div class="post-container">
                                    
                                    <?php echo the_content(); ?>
                                    
                                    <p><a href="<?php echo site_url(); ?>/resume.pdf" target="_blank">View My Resume &raquo;</a></p>
                                    
                                    <hr />
                                    
                                    <div id="ajax-spinner" style="display: none;"><i class="fas fa-spinner fa-spin fa-lg text-primary"></i></div>
                                    <div id="form-return" style="display: none;"></div>
                                    
                                    <form id="contact-form" method="POST">
                                        <div class="form-row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="name">First and Last Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="name" id="name" class="form-control" value="" />
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="email-address">Email Address <span class="text-danger">*</span></label>
                                                    <input type="text" name="email-address" id="email-address" class="form-control" value="" />
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="message">How can I help you? <span class="text-danger">*</span></label>
                                            <textarea name="message" id="message" class="form-control"></textarea>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                    
                                </div>
                                
                            </section>
                            
                            <aside id="sidebar" class="col-md-4 offset-md-1">
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