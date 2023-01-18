<?php
$seiPosts = array(
    'post_type' => 'portfolio',
    'posts_per_page' => 4,
    'tax_query' => array(
        array(
            'taxonomy' => 'portfolio-tags',
            'field' => 'slug',
            'terms' => 'sei'
        )
    ),
    'orderby' => 'rand',
);
$seiPostsQuery = new WP_Query($seiPosts);

if($seiPostsQuery->have_posts()) { ?>

    <div class="post-container mb-5">
        <p>I attended a Software Engineering Immersive from July to October 2020 through General Assembly. While I had previously been a self-taught developer and held a few dev positions up until then, I gained valuable experience through this journey. Learning about and utilizing several programming languages and web frameworks, I developed full-stack applications while applying computer science theories, industry standards, and best practices.</p>
    </div>
    
    <div class="row">
        
        <?php
        while($seiPostsQuery->have_posts()) {
            $seiPostsQuery->the_post();
            $projectThumbnail = get_the_post_thumbnail_url($post, 'square-xs');
            $projectCategoryObj = get_the_terms($post->ID, 'portfolio-categories');
            $projectCategory = $projectCategoryObj[0]->name;
            ?>
            
            <div class="col-sm-6 col-lg-3 portfolio-thumbnail-box mb-5">
                <a href="<?php the_permalink(); ?>">
                    <div class="embed-responsive embed-responsive-1by1 box-shadow">
                        <div class="portfolio-thumbnail embed-responsive-item" style="background-image: url('<?php echo $projectThumbnail; ?>');">
                            <div class="pattern-overlay">
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