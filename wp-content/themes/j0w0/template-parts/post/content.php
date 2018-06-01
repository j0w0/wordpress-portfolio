<?php
$post_type = get_post_type();
$featured_image_url = get_the_post_thumbnail_url($post, 'full');

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


if($post_type == "portfolio") {
    if( class_exists('Dynamic_Featured_Image') ) {
        global $dynamic_featured_image;
        $featured_images = $dynamic_featured_image->get_all_featured_images($post_id); ?>
        
        <div class="slider-container">
            
            <div class="slider">
                
                <?php
                if(!empty(get_post_meta($post->ID, "video-url", true))) { ?>
                    
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe src="<?php echo get_post_meta($post->ID, "video-url", true); ?>" class="embed-responsive-item"></iframe>
                    </div>
                    
                <?php
                }
                
                foreach($featured_images as $featured_image) {
                    $attachment_id = $featured_image['attachment_id'];
                    $sliderImage = $dynamic_featured_image->get_image_url( $attachment_id, '16-by-9-crop-md' );
                    $fullImage = $dynamic_featured_image->get_image_url( $attachment_id, 'full' ); ?>
                    
                    <div class="embed-responsive embed-responsive-16by9">
                        <a href="<?php echo $fullImage; ?>" data-lightbox="image">
                            <div class="embed-responsive-item slider-bg-image" style="background-image: url(<?php echo $sliderImage; ?>);"></div>
                        </a>
                    </div>
                    
                <?php
                }
                ?>
            </div>
            
            <div class="slider-direction-controls">
                <span class="slider-prev"></span>
                <span class="slider-next"></span>
            </div>
            
        </div>
        
    <?php
    }
}
?>

<div class="post-container">
    <?php the_content(); ?>
    
    <?php
    if($post_type == "portfolio") {
        $PDFUploadFile = get_post_meta($post->ID, 'portfolio-pdf', true); ?>
        <a href="<?php echo wp_get_attachment_url($PDFUploadFile); ?>" target="_blank" class="mb-3">View Final PDF of Project &raquo;</a>
    <?php
    }
    ?>
    
    <?php echo $post_links; ?>
</div>