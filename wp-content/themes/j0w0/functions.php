<?php
session_start();

// theme set up
function j0w0_theme_setup() {
    add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
    
    // original aspect ratios
    add_image_size( 'lg', 1200, 9999 );
    add_image_size( 'md', 1024, 9999 );
    add_image_size( 'sm', 768, 9999 );
    add_image_size( 'xs', 480, 9999 );
    add_image_size( 'xxs', 300, 9999 );
    
    // square crop
    add_image_size( 'square-lg', 1200, 1200, true );
    add_image_size( 'square-md', 1024, 1024, true );
    add_image_size( 'square-sm', 768, 768, true );
    add_image_size( 'square-xs', 480, 480, true );
    add_image_size( 'square-xxs', 300, 300, true );
    
    // 16:9 crop
    add_image_size( '16-by-9-crop-lg', 1200, 675, true );
    add_image_size( '16-by-9-crop-md', 1024, 576, true );
    add_image_size( '16-by-9-crop-sm', 768, 432, true );
    add_image_size( '16-by-9-crop-xs', 480, 270, true );
    add_image_size( '16-by-9-crop-xxs', 300, 169, true );
    
	register_nav_menus();
    
    // remove unecessary scripts in header
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); 
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head' );
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'rest_output_link_wp_head' );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' ); 
    
}
add_action( 'after_setup_theme', 'j0w0_theme_setup' );

// turns off wordpress image compression
add_filter('jpeg_quality', function($arg) {
    return 100;
});

// remove default image sizes
function remove_default_image_sizes($sizes) {
    unset( $sizes['medium'] );
    unset( $sizes['medium_large'] );
    unset( $sizes['large'] );
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'remove_default_image_sizes');


// theme styles
function j0w0_styles() {
    wp_enqueue_style( 'j0w0-theme', get_template_directory_uri() . '/assets/styles/css/main.min.css', '', null );
}
add_action( 'wp_enqueue_scripts', 'j0w0_styles' );


// theme scripts
function j0w0_javascript() {
    // popper.js for bootstrap js
    wp_enqueue_script( 'popper-js', get_template_directory_uri() . '/assets/vendor/popper-js/popper.min.js', array( 'jquery' ), null, true );
    // bootstrap js
    wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/assets/vendor/bootstrap-4.1.1/dist/js/bootstrap.min.js', array( 'jquery' ), null, true );
    // fontawesome js
    wp_enqueue_script( 'fontawesome-js', get_template_directory_uri() . '/assets/vendor/fontawesome-free-5.0.13/svg-with-js/js/fontawesome-all.min.js', array( ), null, true );
    // typed
    wp_enqueue_script( 'typed', get_template_directory_uri() . '/assets/vendor/typed.js-master/lib/typed.min.js', array( ), null, false );
    // bxslider
    wp_enqueue_script( 'bxslider', get_template_directory_uri() . '/assets/vendor/bxslider-4-master/dist/jquery.bxslider.min.js', array( 'jquery' ), null, true );
    // lightbox
    wp_enqueue_script( 'lightbox', get_template_directory_uri() . '/assets/vendor/lightbox2-master/dist/js/lightbox.min.js', array( 'jquery' ), null, true );
    // jquery validate
    wp_enqueue_script( 'jquery-validate', get_template_directory_uri() . '/assets/vendor/jquery-validation-1.17.0/dist/jquery.validate.min.js', array( 'jquery' ), null, true );
    
    // google tag manager for analytics
    wp_enqueue_script( 'google-tag-manager', '//www.googletagmanager.com/gtag/js?id=UA-129393365-1', array(), null, false);
    // google analytics
    wp_enqueue_script( 'google-analytics', get_template_directory_uri() . '/assets/scripts/google-analytics.js', array('google-tag-manager'), null, false);
    
    // custom scripts
    wp_enqueue_script( 'j0w0-theme-js', get_template_directory_uri() . '/assets/scripts/j0w0-theme.js', array( 'jquery' ), null, true );
    
    // for ajax calls
    wp_localize_script( 'j0w0-theme-js', 'ajax', array(
		'url' => admin_url( 'admin-ajax.php' )
	));
}
add_action( 'wp_enqueue_scripts', 'j0w0_javascript' );


// update edit form
function update_edit_form() {
    echo ' enctype="multipart/form-data"';
}
add_action('post_edit_form_tag', 'update_edit_form');


// remove admin bar elements
function remove_admin_bar_elements( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'wp-logo' );
    $wp_admin_bar->remove_node( 'comments' );
}
add_action('admin_bar_menu', 'remove_admin_bar_elements', 999);


// remove comments from admin dashboard menu
function remove_comments_menu() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'remove_comments_menu');


// removes from post and pages
function remove_comment_support() {
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'page', 'comments' );
}
add_action('init', 'remove_comment_support', 100);


// php mailer presets
function myPHPMailer($phpmailer) {
    $phpmailer->setFrom('josh@j0w0.com', 'Josh Woodcock');
}
add_action( "phpmailer_init", "myPHPMailer" );


// contact form submission
function submitContactForm() {
    
    // send email here
    $name = $_POST['name'];
    $emailAddress = $_POST['email-address'];
    $message = $_POST['message'];
    
    $to = "josh@j0w0.com";
    $subject = "j0w0.com Contact Form Submission";
    
    $headers = array(
        //'From: ' . $name . ' <' . $emailAddress . '>',
        'Reply-To: ' . $name . ' <' . $emailAddress . '>',
        'Content-Type: text/html; charset=UTF-8'
    );
    
    if(wp_mail($to, $subject, $message, $headers)) {
        echo "Thanks for reaching out! I will respond as soon as possible.";
        exit();
    } else {
        echo "Could not send email at this time. Please contact me at <a href='mailto:josh@j0w0.com'>josh@j0w0.com</a> or through LinkedIn.";
        exit();
    }
}
add_action("wp_ajax_submitContactForm", "submitContactForm"); // for wordpress users
add_action("wp_ajax_nopriv_submitContactForm", "submitContactForm"); // for public users


// display portfolio archive items in random order
function portfolio_random_order($query) {
	if($query->is_main_query() && !is_admin() && is_post_type_archive('portfolio')) {
		$query->set('orderby', 'rand');
	}
}
add_action( 'pre_get_posts', 'portfolio_random_order' );


// prevents posts from showing up twice on random/paginated archives
function randomize_with_pagination($orderby) {
    
	if(is_main_query() && !is_admin() && is_post_type_archive('portfolio')) {
	  	// Reset seed on load of initial archive page
		if( ! get_query_var( 'paged' ) || get_query_var( 'paged' ) == 0 || get_query_var( 'paged' ) == 1 ) {
			if( isset( $_SESSION['seed'] ) ) {
				unset( $_SESSION['seed'] );
			}
		}
        
		// Get seed from session variable if it exists
		$seed = false;
		if( isset( $_SESSION['seed'] ) ) {
			$seed = $_SESSION['seed'];
		}
        
        // Set new seed if none exists
        if ( ! $seed ) {
            $seed = rand();
            $_SESSION['seed'] = $seed;
        }
        
        // Update ORDER BY clause to use seed
        $orderby = 'RAND(' . $seed . ')';
	}
    
	return $orderby;
}
add_filter( 'posts_orderby', 'randomize_with_pagination' );
