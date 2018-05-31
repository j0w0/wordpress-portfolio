<?php
$post_type = get_post_type();

if($post_type == "portfolio") {
    $categories = get_terms('portfolio-tags');
} else {
    $categories = get_terms('post_tag');
}
?>

<section id="tags-list" class="mb-3">
    
    <h3 class="h5-5 text-pink">Tags</h3>
    
    <ul class="list-unstyled sidebar-category-list">
        <?php
        foreach($categories as $cat_term_obj) {
            $post_cat_name = $cat_term_obj->name;
            $post_cat_id = $cat_term_obj->term_id;
            $post_cat_link = get_category_link($post_cat_id);
            ?>
            
            <li>
                <a href="<?php echo $post_cat_link; ?>">
                    <?php echo $post_cat_name; ?>
                </a>
            </li>
            
        <?php
        }
        ?>
        
    </ul>
    
</section>