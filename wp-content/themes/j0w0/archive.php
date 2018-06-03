<?php get_header(); ?>
    
    <main>
        
        <header id="hero">
            <div class="hero-padding stripe-pattern bg-secondary">
                <div class="container-fluid container-max-width">
                    <h1 class="text-primary">
                        <?php
                        if(is_post_type_archive()) {
                            post_type_archive_title();
                        } else {
                            single_cat_title();
                        }
                        ?>
                    </h1>
                </div>
            </div>
        </header>
        
        <div class="container-fluid container-max-width section-padding">
            <div class="row">
                
                <section id="content" class="col-md-7 mb-4 mb-md-0">
                    <?php
                    if(have_posts()) { ?>
                        <div class="row">
                            <?php
                            while(have_posts()) {
                                the_post();
                                $projectThumbnail = get_the_post_thumbnail_url($post, 'square-xs');
                                $projectCategoryObj = get_the_terms($post->ID, 'portfolio-categories');
                                $projectCategory = $projectCategoryObj[0]->name;
                                ?>
                                
                                <article class="col-sm-6 col-xl-4 mb-3 thumbnail-box">
                                    
                                    <header>
                                        <a href="<?php echo the_permalink(); ?>" class="d-block">
                                            <div class="embed-responsive embed-responsive-1by1 mb-2 box-shadow">
                                                <?php
                                                if(has_post_thumbnail()) { ?>
                                                    <div style="background-image: url(<?php echo $projectThumbnail; ?>)" class="embed-responsive-item thumbnail-bg-image mb-2 box-shadow"></div>
                                                <?php    
                                                }
                                                ?>
                                            </div>
                                            <h1 class="h6 mb-0"><?php echo the_title(); ?></h1>
                                            <p class="small text-muted font-italic mb-3"><?php echo $projectCategory; ?></p>
                                        </a>
                                    </header>
                                    
                                </article>
                                
                            <?php
                            }
                            ?>
                        </div>
                    <?php
                    } else {
                        echo "<p>No posts were found.</p>";
                    }
                    
                    if($wp_query->max_num_pages > 1) { ?>
                        
                        <div class="posts-pagination">
                            <?php
                            $paginationArgs = array(
                                "prev_text" => "&laquo; Previous",
                                "next_text" => "Next &raquo;",
                                "screen_reader_text" => " "
                            );
                            
                            the_posts_pagination($paginationArgs);
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                    
                </section>
                
                <aside id="sidebar" class="col-md-4 offset-md-1">
                    <?php get_template_part( 'template-parts/sidebar/categories' ); ?>
                    <?php get_template_part( 'template-parts/sidebar/tags' ); ?>
                    <?php get_template_part( 'template-parts/sidebar/contact' ); ?>
                </aside>
                
            </div>
        </div>
        
    </main>
    
<?php get_footer(); ?>