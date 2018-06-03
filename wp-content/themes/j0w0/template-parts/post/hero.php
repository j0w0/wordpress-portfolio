<?php
$post_type = get_post_type();

if($post_type == "portfolio") {
    $terms = get_the_terms($post, 'portfolio-categories');
    $term_obj = $terms[0];
    $post_cat_name = $term_obj->name;
    $post_cat_id = $term_obj->term_id;
    $post_cat_link = get_term_link($post_cat_id);
    $post_links = get_the_term_list($post, 'portfolio-tags', '<ul class="post-tags"><li>', '</li><li>', '</li></ul>');
} else {
    $categories = get_the_category();
    $post_cat_obj = $categories[0];
    $post_cat_name = $post_cat_obj->name;
    $post_cat_id = $post_cat_obj->term_id;
    $post_cat_link = get_category_link($post_cat_id);
    $post_links = get_the_tag_list('<ul class="post-tags"><li>', '</li><li>', '</li></ul>');
}
?>

<header id="hero">
    <div class="hero-padding stripe-pattern bg-secondary">
        <div class="container-fluid container-max-width">
            <h1 class="text-primary"><?php the_title(); ?></h1>
            <?php
            if($post_type == "post") {
                echo "<p class='publish-data'>";
                echo "<span class='publish-date'>" . get_the_date() . "</span>";
                echo " by ";
                echo "<span class='publish-author'>" . get_the_author() . "</span>";
                echo "</p>";
            }
            ?>
        </div>
        
        <?php
        //if($post_type !== "page") {
        
        if($post_type == "post" || $post_type == "portfolio") { ?>
            <div class="post-category-container">
                <div class="container-fluid container-max-width">
                    <a href="<?php echo $post_cat_link; ?>">
                        <div class="post-category">
                            <?php echo $post_cat_name; ?>
                        </div>
                    </a>
                </div>
            </div>
        <?php
        }
        ?>
        
    </div>
</header>