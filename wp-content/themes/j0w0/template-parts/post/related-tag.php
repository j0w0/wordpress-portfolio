<?php
$post_type = get_post_type();
$post_id = get_the_id();

if($post_type == "portfolio") {
    $categories = get_the_terms($post, 'portfolio-categories');
    $tags = get_the_terms($post, 'portfolio-tags');
} else {
    $categories = get_the_category();
    $tags = get_the_tags();
}

$cat_term_obj = $categories[0];
$post_cat_name = $cat_term_obj->name;
$post_cat_id = $cat_term_obj->term_id;
$post_cat_slug = $cat_term_obj->slug;
$post_cat_tax = $cat_term_obj->taxonomy;
$post_cat_link = get_category_link($post_cat_id);

if(!empty($tags)) {
    foreach($tags as $tag) {
        $tagSlugs[] = $tag->slug;
        $tag_taxonomy_name = $tag->taxonomy;
    }
}

$args = array(
    "post_type" => $post_type,
    "tax_query" => array(
        "relation" => "AND",
        array(
            "taxonomy" => $tag_taxonomy_name,
            "field" => "slug",
            "terms" => $tagSlugs
        ),
        array(
            "taxonomy" => $post_cat_tax,
            "field" => "slug",
            "terms" => $post_cat_slug,
            "operator" => "NOT IN"
        )
    ),
    "posts_per_page" => 2,
    "post__not_in" => array($post_id),
    "orderby" => "rand"
);

$relatedPosts = new WP_Query($args);

if($relatedPosts->have_posts()) { ?>
    
    <section id="related-tags" class="mb-3">
        <h3 class="h5-5 text-pink mb-0">Sisters From Different Misters</h3>
        <p class="small text-muted font-italic">Projects that have different categories, but share a tag.</p>
        
        <div class="form-row">
            <?php
            while($relatedPosts->have_posts()) {
                $relatedPosts->the_post();
                $featured_image_url = get_the_post_thumbnail_url($post, '16-by-9-crop-xxs');
                
                $post_type = get_post_type();
                
                if($post_type == "portfolio") {
                    $categories = get_the_terms($post, 'portfolio-categories');
                } else {
                    $categories = get_the_category();
                }
                
                $cat_term_obj = $categories[0];
                $post_cat_name = $cat_term_obj->name;
                ?>
                
                <article class="col-6 mb-3 thumbnail-box">
                    
                    <a href="<?php echo the_permalink(); ?>" title="<?php echo the_title(); ?>">
                        <div class="embed-responsive embed-responsive-16by9 mb-2 box-shadow">
                            <div class="embed-responsive-item thumbnail-bg-image" style="background-image: url('<?php echo $featured_image_url; ?>');"></div>
                        </div>
                        <span class="d-block mb-1"><?php echo the_title(); ?></span>
                        <span class="text-muted font-italic d-block"><?php echo $post_cat_name; ?></span>
                    </a>
                    
                </article>
                
            <?php
            }
            ?>
        </div>
    </section>
    
<?php
wp_reset_postdata();
}
?>