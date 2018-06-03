<?php
$PortfolioPosts = array(
    'post_type' => 'portfolio',
    'posts_per_page' => 6,
    'orderby' => 'rand'
);
$PortfolioPostsQuery = new WP_Query($PortfolioPosts);

if($PortfolioPostsQuery->have_posts()) { ?>
    
    <div class="row">
        
        <?php
        while($PortfolioPostsQuery->have_posts()) {
            $PortfolioPostsQuery->the_post();
            $projectThumbnail = get_the_post_thumbnail_url($post, 'square-xs');
            $projectCategoryObj = get_the_terms($post->ID, 'portfolio-categories');
            $projectCategory = $projectCategoryObj[0]->name;
            ?>
            
            <div class="col-12 col-sm-6 col-md-4 portfolio-thumbnail-box mb-5">
                <a href="<?php the_permalink(); ?>">
                    <div class="embed-responsive embed-responsive-1by1 box-shadow">
                        <div class="portfolio-thumbnail embed-responsive-item" style="background-image: url('<?php echo $projectThumbnail; ?>');">
                            <div class="pattern-overlay stripe-pattern">
                                <div class="gradient-overlay"></div>
                            </div>
                        </div>
                    </div>
                    <div class="portfolio-thumbnail-info">
                        <span class="portfolio-thumbnail-title"><?php the_title(); ?></span>
                        <span class="portfolio-thumbnail-category"><?php echo $projectCategory; ?></span>
                    </div>
                </a>
            </div>
            
        <?php
        }
        ?>
        
    </div>
    
<?php
}
?>