<?php
$aboutArgs = array(
    'post_type' => 'page',
    'posts_per_page' => 1,
    'name' => 'about'
);
$aboutResults = new WP_Query($aboutArgs);

if($aboutResults->have_posts()) {
    while($aboutResults->have_posts()) {
        $aboutResults->the_post();

        // // remove images from page
        // $content = get_the_content();
        // $content = preg_replace("/<img[^>]+\>/i", " ", $content);          
        // $content = apply_filters('the_content', $content);
        // $content = str_replace(']]>', ']]>', $content);
        // echo $content;

        the_content();
    }
}
?>