<?php
/**
 * sanas functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package sanas
 */

if (!defined('SANAS_VERSION')) {
    // Replace the version number of the theme on each release.
    define('SANAS_VERSION', '1.5.55454444');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function sanas_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on sanas, use a find and replace
		* to change 'sanas' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'sanas', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
    register_nav_menus(
        array(
            'sanas-main-menu' => esc_html__('Header', 'sanas'),
            'sanas-footer-menu' => esc_html__('Footer', 'sanas'),
        )
    );

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'sanas_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'sanas_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function sanas_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'sanas_content_width', 640 );
}
add_action( 'after_setup_theme', 'sanas_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function sanas_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'sanas' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'sanas' ),
		'before_widget' => '<section id="%1$s" class="sidebar-widget widget-box widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="blog-sidebar-heading">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'sanas_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function sanas_scripts() {
	wp_enqueue_style( 'sanas-style', get_stylesheet_uri(), array(), SANAS_VERSION );
	wp_style_add_data( 'sanas-style', 'rtl', 'replace' );

	wp_enqueue_script( 'sanas-navigation', get_template_directory_uri() . '/js/navigation.js', array(), SANAS_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'sanas_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

require get_template_directory() . '/inc/includes-files.php';
/*
Load All Require File
 */
do_action('sanas_includes_file');

// Hide the admin bar for subscribers
add_filter('show_admin_bar', 'hide_admin_bar_for_subscribers');
function hide_admin_bar_for_subscribers($show_admin_bar) {
    if (current_user_can('subscriber')) {
        return false;
    }
    return $show_admin_bar;
}

// Handle the video upload via AJAX
function handle_video_upload() {
    check_ajax_referer('video-upload-nonce', 'nonce');

    if (!function_exists('wp_handle_upload')) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
    }

    $file = $_FILES['video'];
    $uploaded_file = wp_handle_upload($file, array('test_form' => false));

    if (isset($uploaded_file['file'])) {
        $file_name_and_location = $uploaded_file['file'];
        $file_title_for_media_library = $file['name'];

        $wp_upload_dir = wp_upload_dir();

        $attachment = array(
            'guid'           => $wp_upload_dir['url'] . '/' . basename($file_name_and_location),
            'post_mime_type' => $uploaded_file['type'],
            'post_title'     => preg_replace('/\.[^.]+$/', '', basename($file_name_and_location)),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );

        $attach_id = wp_insert_attachment($attachment, $file_name_and_location);

        require_once(ABSPATH . 'wp-admin/includes/image.php');

        $attach_data = wp_generate_attachment_metadata($attach_id, $file_name_and_location);
        wp_update_attachment_metadata($attach_id, $attach_data);

        echo wp_get_attachment_url($attach_id);
    } else {
        echo 'Upload failed!';
    }

    wp_die();
}
add_action('wp_ajax_handle_video_upload', 'handle_video_upload');
add_action('wp_ajax_nopriv_handle_video_upload', 'handle_video_upload');


class Footer_Walker_Nav_Menu extends Walker_Nav_Menu {
    // Start the element output.
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= '<li' . $class_names . '>';

        // Link attributes
        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

        // Start the anchor tag
        $item_output = '<a' . $attributes . '>';

        // Add Font Awesome icon before the menu item text
        $item_output .= '<i class="fa-solid fa-chevron-right"></i>';

        // Add the menu item text
        $item_output .= apply_filters('the_title', $item->title, $item->ID);

        // Close the anchor tag
        $item_output .= '</a>';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}
