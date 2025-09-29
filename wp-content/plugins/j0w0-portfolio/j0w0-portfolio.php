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
        [
            'label'                => 'Portfolio',
            'public'               => true,
            'supports'             => ['title', 'editor', 'thumbnail'],
            'taxonomies'           => ['portfolio-categories', 'portfolio-tags', 'technologies'],
            'has_archive'          => true,
            'register_meta_box_cb' => 'portfolio_metaboxes',
            'show_in_graphql'      => true,
            'show_in_rest'         => true,
            'graphql_single_name'  => 'project',
            'graphql_plural_name'  => 'projects',
        ]
    );
}
add_action('init', 'register_j0w0_portfolio', 11);

// add custom fields to graphql
function j0w0_register_graphql_types() {
    register_graphql_fields('Project', [
        'websiteUrl' => [
            'type'    => 'String',
            'resolve' => function (WPGraphQL\Model\Post $post, $args, $context, $info) {
                $url = get_post_meta($post->ID, 'website-url', true);

                return $url ? $url : null;
            },
        ],
        'videoUrl' => [
            'type'    => 'String',
            'resolve' => function (WPGraphQL\Model\Post $post, $args, $context, $info) {
                $url = get_post_meta($post->ID, 'video-url', true);

                return $url ? $url : null;
            },
        ],
        'portfolioPdf' => [
            'type'    => 'String',
            'resolve' => function (WPGraphQL\Model\Post $post, $args, $context, $info) {
                $url = get_post_meta($post->ID, 'portfolio-pdf', true);

                return $url ? $url : null;
            },
        ],
        'webDevelopmentContent' => [
            'type'    => 'String',
            'resolve' => function (WPGraphQL\Model\Post $post, $args, $context, $info) {
                $content = get_post_meta($post->ID, 'web_development_content', true);

                return $content ? apply_filters('the_content', $content) : null;
            },
        ],
    ]);

    // get attachment/media data for featured images
    // https://wpgraphql-docs.netlify.app/extending/connections/#register-the-connection
    register_graphql_connection([
        'fromType'       => 'ContentNode',
        'toType'         => 'MediaItem',
        'fromFieldName'  => 'featuredImages',
        'connectionArgs' => WPGraphQL\Connection\PostObjects::get_connection_args(),
        'resolve'        => function (WPGraphQL\Model\Post $source, $args, $context, $info) {
            $resolver = new WPGraphQL\Data\Connection\PostObjectConnectionResolver($source, $args, $context, $info, 'attachment');

            global $dynamic_featured_image;
            $featured_images = $dynamic_featured_image->get_featured_images();
            $images          = [];

            foreach ($featured_images as $featured_image) {
                $attachment_id = $featured_image['attachment_id'];
                array_push($images, $attachment_id);
            }

            $resolver->set_query_arg('post__in', $images);

            return $resolver->get_connection();
        },
    ]);

    // get randomly ordered interactive portfolio posts
    register_graphql_connection([
        'fromType'      => 'RootQuery',
        'toType'        => 'project',
        'fromFieldName' => 'projectsRandom',
        'resolve'       => function ($id, $args, $context, $info) {
            $resolver = new WPGraphQL\Data\Connection\PostObjectConnectionResolver($source, $args, $context, $info, 'portfolio');

            $resolver->set_query_arg('tax_query', [[
                'taxonomy' => 'portfolio-categories',
                'field'    => 'slug',
                'terms'    => 'interactive',
            ]]);

            $resolver->set_query_arg('orderby', 'rand');

            return $resolver->get_connection();
        },
    ]);
}
add_action('graphql_register_types', 'j0w0_register_graphql_types');

// add custom fields to wp rest api
function j0w0_add_fields_to_rest_api() {
    $fields = ['portfolio-pdf', 'video-url', 'website-url'];
    foreach ($fields as $field) {
        register_rest_field(
            'portfolio',
            $field,
            [
                'get_callback' => function ($object) use ($field) {
                    return get_post_meta($object['id'], $field, true);
                },
            ]
        );
    }
}
add_action('rest_api_init', 'j0w0_add_fields_to_rest_api');

// creates portfolio category
function create_portfolio_category_taxonomy() {
    register_taxonomy(
        'portfolio-categories',
        'portfolio',
        [
            'labels' => [
                'name' => 'Portfolio Categories',
            ],
            'hierarchical' => true,
            'rewrite'      => [
                'slug'         => 'portfolio/category',
                'hierarchical' => true,
            ],
            'show_in_rest'        => true,
            'show_in_graphql'     => true,
            'graphql_single_name' => 'projectCategory',
            'graphql_plural_name' => 'projectCategories',
        ]
    );
}
add_action('init', 'create_portfolio_category_taxonomy');

// creates portfolio tags
function create_portfolio_tags_taxonomy() {
    register_taxonomy(
        'portfolio-tags',
        'portfolio',
        [
            'labels' => [
                'name' => 'Portfolio Tags',
            ],
            'hierarchical' => false,
            'rewrite'      => [
                'slug' => 'portfolio/tag',
            ],
            'show_in_rest'        => true,
            'show_in_graphql'     => true,
            'graphql_single_name' => 'projectTag',
            'graphql_plural_name' => 'projectTags',
        ]
    );
}
add_action('init', 'create_portfolio_tags_taxonomy');

// creates technologies taxonomy
function create_technologies_taxonomy() {
    register_taxonomy(
        'technologies',
        'portfolio',
        [
            'labels' => [
                'name' => 'Technologies',
            ],
            'hierarchical' => false,
            'rewrite'      => [
                'slug'         => 'portfolio/technology',
                'hierarchical' => false,
            ],
            'show_in_rest'        => true,
            'show_in_graphql'     => true,
            'graphql_single_name' => 'projectTechnology',
            'graphql_plural_name' => 'projectTechnologies',
        ]
    );
}
add_action('init', 'create_technologies_taxonomy');

// custom admin columns
function portfolio_columns($columns) {
    return [
        'cb'                     => '<input type="checkbox" />',
        'title'                  => 'Title',
        'portfolio_categories'   => 'Categories',
        'portfolio_tags'         => 'Tags',
        'portfolio_technologies' => 'Technologies',
        'date'                   => 'Date',
    ];
}
add_filter('manage_edit-portfolio_columns', 'portfolio_columns');

// populate admin columns
function populate_portfolio_columns($column, $post_id) {
    switch ($column) {
        case 'portfolio_categories':
            $terms = get_the_term_list($post_id, 'portfolio-categories', '', ', ', '');
            print $terms;

            break;
        case 'portfolio_tags':
            $terms = get_the_term_list($post_id, 'portfolio-tags', '', ', ', '');
            print $terms;

            break;
        case 'portfolio_technologies':
            $terms = get_the_term_list($post_id, 'technologies', '', ', ', '');
            print $terms;

            break;
    }
}
add_action('manage_portfolio_posts_custom_column', 'populate_portfolio_columns', 10, 2);

// add metaboxes
function portfolio_metaboxes() {
    add_meta_box('interactive-metabox', 'Interactive', 'interactive_metabox', 'portfolio', 'normal', 'default');
    add_meta_box('motion-graphics-metabox', 'Motion Graphics', 'motion_graphics_metabox', 'portfolio', 'normal', 'default');
    add_meta_box('portfolio_pdf_upload_metabox', 'PDF Upload', 'portfolio_pdf_upload_metabox', 'portfolio', 'normal', 'default');
}
add_action('add_meta_boxes', 'portfolio_metaboxes');

// pdf upload metabox content
function portfolio_pdf_upload_metabox($post) {
    wp_nonce_field('save-portfolio', 'portfolio-nonce');
    $PDFUploadFile = get_post_meta($post->ID, 'portfolio-pdf', true);
    if (!empty($PDFUploadFile)) { ?>
        <a href="<?= wp_get_attachment_url($PDFUploadFile); ?>" title="PDF Upload">PDF Upload Link</a>
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
    wp_nonce_field('save-portfolio', 'portfolio-nonce'); ?>
    <label for="website-url">Website URL</label>
    <input type="text" name="website-url" id="website-url" value="<?php if (isset($WebsiteURL)) {
        print $WebsiteURL;
    } ?>" />
<?php
}

// motion graphics metabox content
function motion_graphics_metabox($post) {
    $VideoURL = get_post_meta($post->ID, 'video-url', true);
    wp_nonce_field('save-portfolio', 'portfolio-nonce'); ?>
    <label for="video-url">Video URL</label>
    <input type="text" name="video-url" id="video-url" value="<?php if (isset($VideoURL)) {
        print $VideoURL;
    } ?>" />
<?php
}

// save custom fields
function save_portfolio_custom_fields($post_id) {
    if (!isset($_POST['portfolio-nonce']) || !wp_verify_nonce($_POST['portfolio-nonce'], 'save-portfolio')) {
        return $post_id;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // save video url
    if (!empty($_POST['video-url'])) {
        update_post_meta($post_id, 'video-url', sanitize_text_field($_POST['video-url']));
    } else {
        delete_post_meta($post_id, 'video-url');
    }

    // save website url
    if (!empty($_POST['website-url'])) {
        update_post_meta($post_id, 'website-url', sanitize_text_field($_POST['website-url']));
    } else {
        delete_post_meta($post_id, 'website-url');
    }

    // save pdf
    if (!empty($_FILES['portfolio-pdf']['name'])) {
        $supported_types = ['application/pdf'];
        $file_type       = $_FILES['portfolio-pdf']['type'];

        if (in_array($file_type, $supported_types)) {
            $pdf_attachment_id = media_handle_upload('portfolio-pdf', $post_id);
            update_post_meta($post_id, 'portfolio-pdf', $pdf_attachment_id);
        } else {
            wp_die('File is not a PDF.');
        }
    }

    // delete pdf
    if (isset($_POST['delete-portfolio-pdf'])) {
        $PDFUploadID = get_post_meta($post_id, 'portfolio-pdf', true);
        wp_delete_attachment($PDFUploadID);
        delete_post_meta($post_id, 'portfolio-pdf');
    }
}
add_action('save_post', 'save_portfolio_custom_fields');

// remove p tags from wrapping images in wysiwyg content
function filter_ptags_on_images($content) {
    return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'filter_ptags_on_images');
