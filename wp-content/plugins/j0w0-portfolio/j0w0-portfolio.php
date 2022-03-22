<?php
/*
Plugin Name: j0w0 Portfolio
Plugin URI: http://www.j0w0.com
Description: Creates portfolio post type.
Author: Josh Woodcock
*/

// creates post type
function register_j0w0_portfolio() {
    register_post_type(
        'portfolio',
        array(
            'label' => 'Portfolio',
            'public' => true,
            'supports' => array( 'title', 'editor', 'thumbnail' ),
            'taxonomies' => array( 'portfolio-categories', 'portfolio-tags' ),
            'has_archive' => true,
            'register_meta_box_cb' => 'portfolio_metaboxes',
            'show_in_graphql' => true,
            'graphql_single_name' => 'project',
            'graphql_plural_name' => 'projects'
        )
    );
};
add_action( 'init', 'register_j0w0_portfolio', 11);

// add custom fields to graphql
add_action( 'graphql_register_types', function() {
    register_graphql_field('Project', 'website-url', [
        'type' => 'string',
        'resolve' => function( $post ) {
            $url = get_post_meta( $post->ID, 'website-url', true );
            return $url ? $url : null;
        }
    ]);
    register_graphql_field('Project', 'video-url', [
        'type' => 'string',
        'resolve' => function( $post ) {
            $url = get_post_meta( $post->ID, 'video-url', true );
            return $url ? $url : null;
        }
    ]);
    register_graphql_field('Project', 'portfolio-pdf', [
        'type' => 'string',
        'resolve' => function( $post ) {
            $pdf = get_post_meta( $post->ID, 'portfolio-pdf', true );
            return $pdf ? $pdf : null;
        }
    ]);
});

// creates portfolio category
function create_portfolio_category_taxonomy() {
    register_taxonomy(
        'portfolio-categories',
        'portfolio',
        array(
            'labels' => array(
                'name' => 'Portfolio Categories'
            ),
            'hierarchical' => true,
            'rewrite' => array(
                'slug' => 'portfolio/category',
                'hierarchical' => true
            ),
            'show_in_graphql' => true,
            'graphql_single_name' => 'projectCategory',
            'graphql_plural_name' => 'projectCategories'
        )
    );
}
add_action( 'init', 'create_portfolio_category_taxonomy');

// creates portfolio tags
function create_portfolio_tags_taxonomy() {
    register_taxonomy(
        'portfolio-tags',
        'portfolio',
        array(
            'labels' => array(
                'name' => 'Portfolio Tags'
            ),
            'hierarchical' => false,
            'rewrite' => array(
                'slug' => 'portfolio/tag',
            ),
            'show_in_graphql' => true,
            'graphql_single_name' => 'projectTag',
            'graphql_plural_name' => 'projectTags'
        )
    );
}
add_action( 'init', 'create_portfolio_tags_taxonomy');

// custom admin columns
function portfolio_columns($columns) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => 'Title',
        'portfolio_categories' => 'Categories',
        'portfolio_tags' => 'Tags',
        'date' => 'Date'
    );
    return $columns;
}
add_filter('manage_edit-portfolio_columns', 'portfolio_columns');

// populate admin columns
function populate_portfolio_columns($column, $post_id) {
    switch($column) {
        case 'portfolio_categories':
            $terms = get_the_term_list($post_id, 'portfolio-categories', '', ', ', '');
            echo $terms;
        break;
        case 'portfolio_tags':
            $terms = get_the_term_list($post_id, 'portfolio-tags', '', ', ', '');
            echo $terms;
        break;
    }
}
add_action('manage_portfolio_posts_custom_column', 'populate_portfolio_columns', 10, 2);

// add metaboxes
function portfolio_metaboxes() {
    add_meta_box('interactive-metabox', 'Interactive', 'interactive_metabox', 'portfolio', 'normal', 'default');
    add_meta_box('motion-graphics-metabox', 'Motion Graphics', 'motion_graphics_metabox', 'portfolio', 'normal', 'default');
    add_meta_box('portfolio_pdf_upload_metabox', 'PDF Upload', 'portfolio_pdf_upload_metabox', 'portfolio', 'normal', 'default');
    // add more metaboxes here
}
add_action('add_meta_boxes', 'portfolio_metaboxes');

// pdf upload metabox content
function portfolio_pdf_upload_metabox($post) {
    wp_nonce_field( 'save-portfolio', 'portfolio-nonce' );
    $PDFUploadFile = get_post_meta($post->ID, 'portfolio-pdf', true);
    if(!empty($PDFUploadFile)) { ?>
        <a href="<?php echo wp_get_attachment_url($PDFUploadFile); ?>" title="PDF Upload">PDF Upload Link</a>
        <input type="submit" name="delete-portfolio-pdf" value="Delete" />
    <?php
    } else { ?>
        <input type="file" name="portfolio-pdf" id="portfolio-pdf" value="" style="width: 100%;" />
    <?php
    }
}

// interactive metabox content
function interactive_metabox($post) {
    $WebsiteURL = get_post_meta($post->ID, 'website-url', true);
    wp_nonce_field( 'save-portfolio', 'portfolio-nonce' ); ?>
    <label for="website-url">Website URL</label>
    <input type="text" name="website-url" id="website-url" value="<?php if(isset($WebsiteURL)) { echo $WebsiteURL; } ?>" />
<?php
}

// motion graphics metabox content
function motion_graphics_metabox($post) {
    $VideoURL = get_post_meta($post->ID, 'video-url', true);
    wp_nonce_field( 'save-portfolio', 'portfolio-nonce' ); ?>
    <label for="video-url">Video URL</label>
    <input type="text" name="video-url" id="video-url" value="<?php if(isset($VideoURL)) { echo $VideoURL; } ?>" />
<?php
}

// save custom fields
function save_portfolio_custom_fields($post_id) {
    
    if(!isset($_POST['portfolio-nonce']) || !wp_verify_nonce($_POST['portfolio-nonce'], 'save-portfolio')) {
        return $post_id;
    }
    
    if(!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    
    // save video url
    if(!empty($_POST['video-url'])) {
        update_post_meta($post_id, 'video-url', sanitize_text_field($_POST['video-url']));
    } else {
        delete_post_meta($post_id, 'video-url');
    }
    
    // save website url
    if(!empty($_POST['website-url'])) {
        update_post_meta($post_id, 'website-url', sanitize_text_field($_POST['website-url']));
    } else {
        delete_post_meta($post_id, 'website-url');
    }
    
    // save pdf
    if(!empty($_FILES['portfolio-pdf']['name'])) {
        $supported_types = array('application/pdf');
        $file_type = $_FILES['portfolio-pdf']['type'];
        
        if(in_array($file_type, $supported_types)) {
            $pdf_attachment_id = media_handle_upload('portfolio-pdf', $post_id);
            update_post_meta($post_id, 'portfolio-pdf', $pdf_attachment_id);
        } else {
            wp_die('File is not a PDF.');
        }
    }
    
    // delete pdf
    if(isset($_POST['delete-portfolio-pdf'])) {
        $PDFUploadID = get_post_meta($post_id, 'portfolio-pdf', true);
        wp_delete_attachment($PDFUploadID);
        delete_post_meta($post_id, 'portfolio-pdf');
    }
    
}
add_action( 'save_post', 'save_portfolio_custom_fields' );
?>