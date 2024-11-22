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
    define('SANAS_VERSION', '1.5.7878485');
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



add_action('wp_ajax_remove_from_wishlist', 'sanas_remove_from_wishlist');
add_action('wp_ajax_nopriv_remove_from_wishlist', 'sanas_remove_from_wishlist');

function sanas_remove_from_wishlist() {
    global $wpdb;
    check_ajax_referer('sanas_wishlist_nonce', 'security');
    $user_id = get_current_user_id();
    $card_id = intval($_POST['card_id']);

    if (!$user_id) {
        wp_send_json_error(['message' => 'You must be logged in to manage your wishlist.']);
    }

    $result = $wpdb->delete(
        "{$wpdb->prefix}sanas_wishlist",
        array('user_id' => $user_id, 'card_id' => $card_id),
        array('%d', '%d')
    );

    if ($result === false) {
        error_log('Error removing card from wishlist: ' . $wpdb->last_error);
        wp_send_json_error(['message' => 'Failed to remove card from wishlist.']);
    } else {
        wp_send_json_success(['message' => 'Card removed from wishlist', 'action' => 'removed']);
    }

    wp_die();
}


function create_todo_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'todo_list';

    // Check if the table already exists
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id INT NOT NULL AUTO_INCREMENT,
            user_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            category VARCHAR(255) NOT NULL,
            notes TEXT,
            date DATE NOT NULL,
            status VARCHAR(50) NOT NULL DEFAULT 'Yet To Start',
			completed INT(1) NOT NULL DEFAULT 0,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
add_action('after_switch_theme', 'create_todo_table');

function get_todo_list_items() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'todo_list';
    $user_id = get_current_user_id();

    $results = $wpdb->get_results($wpdb->prepare("
        SELECT * FROM $table_name 
        WHERE user_id = %d 
        ORDER BY date DESC
    ", $user_id), ARRAY_A);

    return $results;
}

add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script('my-ajax-script', get_template_directory_uri() . '/js/my-ajax-script.js', array('jquery'), null, true);
    wp_localize_script('my-ajax-script', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('profile_nonce') // Ensure to create a nonce
    ));
});
// Function to add a to-do item
add_action('wp_ajax_add_todo_item', 'add_todo_item');
function add_todo_item() {
    global $wpdb;
    $current_user_id = get_current_user_id();

    $title = sanitize_text_field($_POST['title']);
    $date = sanitize_text_field($_POST['date']);
    $category = sanitize_text_field($_POST['category']);
    $notes = sanitize_textarea_field($_POST['notes']);

    $wpdb->insert(
        $wpdb->prefix . 'todo_list',
        array(
            'title' => $title,
            'date' => $date,
            'category' => $category,
            'notes' => $notes,
            'user_id' => $current_user_id,
        )
    );

    if ($wpdb->insert_id) {
        wp_send_json_success('To-Do item added successfully.');
    } else {
        wp_send_json_error('Failed to add To-Do item.');
    }
}

// Function to edit a to-do item
add_action('wp_ajax_edit_todo_item', 'edit_todo_item');
function edit_todo_item() {
    global $wpdb;
    $current_user_id = get_current_user_id();
    $id = intval($_POST['id']);

    // Sanitize input
    $title = sanitize_text_field($_POST['title']);
    $date = sanitize_text_field($_POST['date']);
    $category = sanitize_text_field($_POST['category']);
    $notes = sanitize_textarea_field($_POST['notes']);

    // Update the database
    $result = $wpdb->update(
        $wpdb->prefix.'todo_list',
        array(
            'title' => $title,
            'date' => $date,
            'category' => $category,
            'notes' => $notes,
        ),
        array('id' => $id, 'user_id' => $current_user_id)
    );

    if ($result !== false) {
        wp_send_json_success('To-Do item updated successfully.');
    } else {
        wp_send_json_error('Failed to update To-Do item.');
    }
}

// Function to toggle the completed status of a to-do item
add_action('wp_ajax_toggle_todo_completed', 'toggle_todo_completed');
function toggle_todo_completed() {
    global $wpdb;
    $current_user_id = get_current_user_id();
    $id = intval($_POST['id']);
    $completed = intval($_POST['completed']);

    $result = $wpdb->update(
        $wpdb->prefix.'todo_list',
        array('completed' => $completed),
        array('id' => $id, 'user_id' => $current_user_id)
    );

    if ($result !== false) {
        wp_send_json_success('To-Do item status updated successfully.');
    } else {
        wp_send_json_error('Failed to update To-Do item status.');
    }
    wp_die();
}

add_action('wp_ajax_update_todo_status', 'update_todo_status');
function update_todo_status() {
    global $wpdb;
    $current_user_id = get_current_user_id();
    $id = intval($_POST['id']);
    $status = sanitize_text_field($_POST['status']);

    $result = $wpdb->update(
        $wpdb->prefix . 'todo_list',
        array('status' => $status),
        array('id' => $id, 'user_id' => $current_user_id)
    );

    if ($result !== false) {
        wp_send_json_success('Status updated successfully.');
    } else {
        wp_send_json_error('Failed to update status.');
    }
}


// Function to retrieve a to-do item for editing
add_action('wp_ajax_get_todo_item', 'get_todo_item');
function get_todo_item() {
    global $wpdb;
    $current_user_id = get_current_user_id();
    $id = intval($_POST['id']);
	$tablename = $wpdb->prefix.'todo_list';
    $item = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $tablename WHERE id = %d AND user_id = %d",
        $id,
        $current_user_id
    ));

    if ($item) {
        wp_send_json_success($item);
    } else {
        wp_send_json_error('To-Do item not found or access denied.');
    }
}

// Optional: Function to delete a to-do item
add_action('wp_ajax_delete_todo_item', 'delete_todo_item');
function delete_todo_item() {
    global $wpdb;
    $current_user_id = get_current_user_id();
    $id = intval($_POST['id']);

    // Delete the to-do item for the current user
    $result = $wpdb->delete(
        $wpdb->prefix . 'todo_list', // Change to your actual table name
        array('id' => $id, 'user_id' => $current_user_id) // Ensure the current user can only delete their own items
    );

    if ($result) {
        wp_send_json_success('To-Do item deleted successfully.');
    } else {
        wp_send_json_error('Failed to delete To-Do item.');
    }
}

// Create Vendor List Table
function create_vendor_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'vendor_list';

    // Check if the table already exists
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id INT NOT NULL AUTO_INCREMENT,
            user_id INT NOT NULL,
            category VARCHAR(255) NOT NULL,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(20) NOT NULL,
            notes TEXT,
            social_media_profile VARCHAR(255),
            pricing DECIMAL(10, 2),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
add_action('after_switch_theme', 'create_vendor_table');

// Function to add a vendor item
add_action('wp_ajax_add_vendor_item', 'add_vendor_item');
function add_vendor_item() {
    global $wpdb;
    $current_user_id = get_current_user_id();

    $category = sanitize_text_field($_POST['category']);
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_text_field($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $notes = sanitize_textarea_field($_POST['notes']);
    $social_media_profile = sanitize_text_field($_POST['social_media_profile']);
    $pricing = floatval($_POST['pricing']);

    $wpdb->insert(
        $wpdb->prefix . 'vendor_list',
        array(
            'user_id' => $current_user_id,
            'category' => $category,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'notes' => $notes,
            'social_media_profile' => $social_media_profile,
            'pricing' => $pricing,
        )
    );

    if ($wpdb->insert_id) {
        // Fetch the updated list of vendors sorted by created_at in descending order
        $vendor_items = get_vendor_list_items();
        usort($vendor_items, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        ob_start();
        foreach ($vendor_items as $vendor) {
            ?>
            <tr>
                <td><input type="checkbox" class="checkSingle"></td>
                <td class="text-single-line" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($vendor['category']); ?>"><?php echo esc_html($vendor['category']); ?></td>
                <td class="text-single-line" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($vendor['name']); ?>"><?php echo esc_html($vendor['name']); ?></td>
                <td class="text-single-line" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($vendor['email']); ?>"><?php echo esc_html($vendor['email']); ?></td>
                <td class="text-single-line" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($vendor['phone']); ?>"><?php echo esc_html($vendor['phone']); ?></td>
                <td class="text-single-line" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($vendor['notes']); ?>"><?php echo esc_html($vendor['notes']); ?></td>
                <td class="text-single-line" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($vendor['social_media_profile']); ?>"><?php echo esc_html($vendor['social_media_profile']); ?></td>
                <td>$<?php echo esc_html($vendor['pricing']); ?></td>
                <td class="actions">
                    <div>
                        <a href="#" class="edit theme-btn" data-id="<?php echo esc_attr($vendor['id']); ?>" data-bs-toggle="modal" data-bs-target="#edit-todolist-popup">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <a href="#" class="delete theme-btn" data-id="<?php echo esc_attr($vendor['id']); ?>">
                            <i class="fa-regular fa-trash-can"></i>
                        </a>
                    </div>
                </td>
                </tr>
            <?php
        }
        $vendor_list_html = ob_get_clean();
        wp_send_json_success($vendor_list_html);
    } else {
        wp_send_json_error('Failed to add vendor item.');
    }
}

// Function to get all vendor items for the current user
add_action('wp_ajax_get_vendor_list_items', 'get_vendor_list_items');
function get_vendor_list_items() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'vendor_list';
    $current_user_id = get_current_user_id();
    $results = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $table_name WHERE user_id = %d",
            $current_user_id
        ),
        ARRAY_A
    );
    return $results;
}

add_action('wp_ajax_edit_vendor_item', 'edit_vendor_item');
function edit_vendor_item() {
    global $wpdb;
    $current_user_id = get_current_user_id();
    $id = intval($_POST['id']);

    $category = sanitize_text_field($_POST['category']);
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_text_field($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $notes = sanitize_textarea_field($_POST['notes']);
    $social_media_profile = sanitize_text_field($_POST['social_media_profile']);
    $pricing = floatval($_POST['pricing']);

    $result = $wpdb->update(
        $wpdb->prefix . 'vendor_list',
        array(
            'category' => $category,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'notes' => $notes,
            'social_media_profile' => $social_media_profile,
            'pricing' => $pricing,
        ),
        array('id' => $id, 'user_id' => $current_user_id)
    );

    if ($result !== false) {
        wp_send_json_success('Vendor item updated successfully.');
    } else {
        wp_send_json_error('Failed to update vendor item.');
    }
}

add_action('wp_ajax_get_vendor_list_item', 'get_vendor_list_item');
function get_vendor_list_item() {
    global $wpdb;
    $current_user_id = get_current_user_id();
    $id = intval($_POST['id']);

    $table_name = $wpdb->prefix . 'vendor_list';
    $vendor = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM $table_name WHERE id = %d AND user_id = %d",
            $id,
            $current_user_id
        ),
        ARRAY_A
    );

    if ($vendor) {
        wp_send_json_success($vendor);
    } else {
        wp_send_json_error('Vendor item not found or access denied.');
    }
}

add_action('wp_ajax_delete_vendor_item', 'delete_vendor_item');
function delete_vendor_item() {
    global $wpdb;
    $current_user_id = get_current_user_id();
    $id = intval($_POST['id']);

    // Delete the to-do item for the current user
    $result = $wpdb->delete(
        $wpdb->prefix . 'vendor_list', // Change to your actual table name
        array('id' => $id, 'user_id' => $current_user_id) // Ensure the current user can only delete their own items
    );

    if ($result) {
        wp_send_json_success('Vendor item deleted successfully.');
    } else {
        wp_send_json_error('Failed to delete vendor item.');
    }
}

// Create My Vendor List Table
function create_my_vendor_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_vendor_list';

    // Check if the table already exists
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id INT NOT NULL AUTO_INCREMENT,
            user_id INT NOT NULL,
            category VARCHAR(255) NOT NULL,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(20) NOT NULL,
            notes TEXT,
            social_media_profile VARCHAR(255),
            pricing DECIMAL(10, 2),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
add_action('after_switch_theme', 'create_my_vendor_table');

// Function to add a my vendor item
add_action('wp_ajax_add_my_vendor_item', 'add_my_vendor_item');
function add_my_vendor_item() {
    global $wpdb;
    $current_user_id = get_current_user_id();

    $category = sanitize_text_field($_POST['category']);
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_text_field($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $notes = sanitize_textarea_field($_POST['notes']);
    $social_media_profile = sanitize_text_field($_POST['social_media_profile']);
    $pricing = floatval($_POST['pricing']);

    $wpdb->insert(
        $wpdb->prefix . 'my_vendor_list',
        array(
            'user_id' => $current_user_id,
            'category' => $category,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'notes' => $notes,
            'social_media_profile' => $social_media_profile,
            'pricing' => $pricing,
        )
    );

    if ($wpdb->insert_id) {
        // Fetch the updated list of vendors sorted by created_at in descending order
        $my_vendor_items = get_my_vendor_list_items();
        usort($my_vendor_items, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        ob_start();
        foreach ($my_vendor_items as $my_vendor) {
            ?>  
            <tr>
                <td class="text-single-line" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($my_vendor['category']); ?>"><?php echo esc_html($my_vendor['category']); ?></td>
                <td class="text-single-line" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($my_vendor['name']); ?>"><?php echo esc_html($my_vendor['name']); ?></td>
                <td class="text-single-line" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($my_vendor['email']); ?>"><?php echo esc_html($my_vendor['email']); ?></td>
                <td class="text-single-line" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($my_vendor['phone']); ?>"><?php echo esc_html($my_vendor['phone']); ?></td>
                <td class="text-single-line" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($my_vendor['notes']); ?>"><?php echo esc_html($my_vendor['notes']); ?></td>
                <td class="text-single-line" data-toggle="tooltip" data-bs-original-title="<?php echo esc_html($my_vendor['social_media_profile']); ?>"><?php echo esc_html($my_vendor['social_media_profile']); ?></td>
                <td>$<?php echo esc_html($my_vendor['pricing']); ?></td>
                <td class="actions">
                    <div>
                        <a href="#" class="edit theme-btn" data-id="<?php echo esc_attr($my_vendor['id']); ?>" data-bs-toggle="modal" data-bs-target="#edit-todolist-popup">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <a href="#" class="delete theme-btn" data-id="<?php echo esc_attr($my_vendor['id']); ?>">
                            <i class="fa-regular fa-trash-can"></i>
                        </a>
                    </div>
                </td>
            </tr>
            <?php
        }
        $my_vendor_list_html = ob_get_clean();
        wp_send_json_success($my_vendor_list_html);
    } else {
        wp_send_json_error('Failed to add my vendor item.');
    }
}

// Function to get all vendor items for the current user
add_action('wp_ajax_get_my_vendor_list_items', 'get_my_vendor_list_items');
function get_my_vendor_list_items() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_vendor_list';
    $current_user_id = get_current_user_id();
    $results = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $table_name WHERE user_id = %d",
            $current_user_id
        ),
        ARRAY_A
    );
    return $results;
}

// Function to edit a my vendor item
add_action('wp_ajax_edit_my_vendor_item', 'edit_my_vendor_item');
function edit_my_vendor_item() {
    global $wpdb;
    $current_user_id = get_current_user_id();
    $id = intval($_POST['id']);

    $category = sanitize_text_field($_POST['category']);
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_text_field($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $notes = sanitize_textarea_field($_POST['notes']);
    $social_media_profile = sanitize_text_field($_POST['social_media_profile']);
    $pricing = floatval($_POST['pricing']);

    $result = $wpdb->update(
        $wpdb->prefix . 'my_vendor_list',
        array(
            'category' => $category,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'notes' => $notes,
            'social_media_profile' => $social_media_profile,
            'pricing' => $pricing,
        ),
        array('id' => $id, 'user_id' => $current_user_id)
    );

    if ($result !== false) {
        wp_send_json_success('My Vendor item updated successfully.');
    } else {
        wp_send_json_error('Failed to update my vendor item.');
    }
}

// Function to get a my vendor item for editing
add_action('wp_ajax_get_my_vendor_list_item', 'get_my_vendor_list_item');
function get_my_vendor_list_item() {
    global $wpdb;
    $current_user_id = get_current_user_id();
    $id = intval($_POST['id']);

    $table_name = $wpdb->prefix . 'my_vendor_list';
    $vendor = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM $table_name WHERE id = %d AND user_id = %d",
            $id,
            $current_user_id
        ),
        ARRAY_A
    );

    if ($vendor) {
        wp_send_json_success($vendor);
    } else {
        wp_send_json_error('My Vendor item not found or access denied.');
    }
}

// Function to delete a my vendor item
add_action('wp_ajax_delete_my_vendor_item', 'delete_my_vendor_item');
function delete_my_vendor_item() {
    global $wpdb;
    $current_user_id = get_current_user_id();
    $id = intval($_POST['id']);

    $result = $wpdb->delete(
        $wpdb->prefix . 'my_vendor_list',
        array('id' => $id, 'user_id' => $current_user_id)
    );

    if ($result) {
        wp_send_json_success('My Vendor item deleted successfully.');
    }
    // else {
    //     wp_send_json_error('Failed to delete my vendor item.');
    // }
}

add_action('wp_ajax_move_vendors_to_my_list', 'move_vendors_to_my_list');
function move_vendors_to_my_list() {
    global $wpdb;
    $current_user_id = get_current_user_id();
    $vendor_ids = $_POST['vendor_ids'];

    if (!is_array($vendor_ids) || empty($vendor_ids)) {
        wp_send_json_error('No vendors selected.');
        return;
    }

    foreach ($vendor_ids as $vendor_id) {
        $vendor_id = intval($vendor_id);

        // Get vendor details
        $vendor = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}vendor_list WHERE id = %d AND user_id = %d",
            $vendor_id,
            $current_user_id
        ), ARRAY_A);

        if ($vendor) {
            // Insert into my_vendor_list
            $wpdb->insert(
                $wpdb->prefix . 'my_vendor_list',
                array(
                    'user_id' => $current_user_id,
                    'category' => $vendor['category'],
                    'name' => $vendor['name'],
                    'email' => $vendor['email'],
                    'phone' => $vendor['phone'],
                    'notes' => $vendor['notes'],
                    'social_media_profile' => $vendor['social_media_profile'],
                    'pricing' => $vendor['pricing'],
                )
            );

            // Delete from vendor_list
            $wpdb->delete(
                $wpdb->prefix . 'vendor_list',
                array('id' => $vendor_id, 'user_id' => $current_user_id)
            );
        }
    }

    wp_send_json_success('Selected vendors moved to "My Vendors" list successfully.');
}

// Create Budget Category Table
function create_budget_category_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'budget_category';

    // Check if the table already exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id INT NOT NULL AUTO_INCREMENT,
            user_id INT NOT NULL,
            category_name VARCHAR(255) NOT NULL,
            icon_class VARCHAR(255) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        // Default categories and icons
        $categories = [
            'Rentals' => 'truck-moving',
            'Bartenders' => 'martini-glass',
            'DJ/VJ' => 'music',
            'Choreographers' => 'person',
            'Cole sparklers' => 'volume-high',
            '360° Photo Booth' => 'camera',
            'Transportation' => 'car',
            'Alterations' => 'person',
            'Priest' => 'hands-praying',
            'Florist' => 'fan',
            'Pre Event Shooting' => 'camera',
            'Mehndi services' => 'hand',
            'Makeup artist' => 'paintbrush',
            'Saree draping' => 'shirt'
        ];
    }
}
add_action('after_switch_theme', 'create_budget_category_table');

// Function to add a budget category item
add_action('wp_ajax_add_budget_category_item', 'add_budget_category_item');
function add_budget_category_item() {
    global $wpdb;
    $current_user_id = get_current_user_id();

    $category_name = sanitize_text_field($_POST['category_name']);
    // $cost = floatval($_POST['cost']);

    $wpdb->insert(
        $wpdb->prefix . 'budget_category',
        array(
            'user_id' => $current_user_id,
            'category_name' => $category_name,
            'created_at' => current_time('mysql'),
            // 'cost' => $cost,
        )
    );

    if ($wpdb->insert_id) {
        $category_id = $wpdb->insert_id;
        wp_send_json_success(array(
            'message' => 'Budget category item added successfully.',
            'category_id' => $category_id
        ));
    } else {
        wp_send_json_error('Failed to add budget category item.');
    }
}


// Function to get all budget categories for the current user
add_action('wp_ajax_get_all_budget_categories', 'get_all_budget_categories');
function get_all_budget_categories() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'budget_category';
    $current_user_id = get_current_user_id();

    $results = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $table_name WHERE user_id = %d OR user_id = 0",
            $current_user_id
        ),
        ARRAY_A
    );
    return $results;
}

// Function to delete a budget category item
add_action('wp_ajax_delete_budget_category_item', 'delete_budget_category_item');
function delete_budget_category_item() {
    global $wpdb;
    $current_user_id = get_current_user_id();
    $id = intval($_POST['id']);

    $delete_category = $wpdb->delete($wpdb->prefix . 'budget_category', array('id' => $id, 'user_id' => $current_user_id));
        // Delete related expenses
    $wpdb->delete($wpdb->prefix . 'budget_expense', array('category_id' => $id, 'user_id' => $current_user_id));
    if ($delete_category) {
        wp_send_json_success('Budget category item and related expenses deleted successfully.');
    } else {
        wp_send_json_error('Failed to delete budget category item.');
    }
}

// Render Modal HTML Alert
function render_confirm_modal_html_alert() {
    ?>
    <div class="modal fade" id="confirm_modal_html_alert" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleConfirmModalLabel"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="confirm_modal-body-text"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-dark" id="modal-yes-button">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <?php
}


// Render Modal HTML Alert
function render_modal_html_alert() {
    ?>
       <div class="modal fade" id="modal_html_alert" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel"></h4>
                    <button type="button" id="render-modal-yes-button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="modal-body-text"></p>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-dark" id="render-modal-yes-button">Yes</button>
                </div> -->
            </div>
        </div>
    </div>
    <?php
}



// Handle profile update
add_action('wp_ajax_update_profile', 'update_profile_callback');
add_action('wp_ajax_nopriv_update_profile', 'update_profile_callback');

function update_profile_callback() {
    $user_id = get_current_user_id();
    if ($user_id) {
        // Update user meta
        if (isset($_POST['first_name'])) {
            update_user_meta($user_id, 'first_name', sanitize_text_field($_POST['first_name']));
            update_user_meta($user_id, 'last_name', sanitize_text_field($_POST['last_name']));
            wp_update_user(['ID' => $user_id, 'user_email' => sanitize_email($_POST['email'])]);
            update_user_meta($user_id, 'phone_number', sanitize_text_field($_POST['phone']));
            update_user_meta($user_id, 'description', sanitize_textarea_field($_POST['about']));
        }

        // Update social media links
        if (isset($_POST['facebook'])) {
            update_user_meta($user_id, 'facebook', esc_url_raw($_POST['facebook']));
            update_user_meta($user_id, 'twitter', esc_url_raw($_POST['twitter']));
            update_user_meta($user_id, 'instagram', esc_url_raw($_POST['instagram']));
            update_user_meta($user_id, 'youtube', esc_url_raw($_POST['youtube']));
        }

        // Send success response
        wp_send_json_success('Profile updated successfully!');
    } else {
        wp_send_json_error('User not logged in');
    }
    wp_die();
}
add_action('wp_ajax_change_password', 'change_password_callback');
function change_password_callback() {
    check_ajax_referer('profile_nonce', 'nonce');
    $user_id = get_current_user_id();
    if ($user_id && isset($_POST['current_password'], $_POST['new_password'])) {
        $user = get_user_by('id', $user_id);
        if (wp_check_password($_POST['current_password'], $user->data->user_pass, $user_id)) {
            wp_set_password($_POST['new_password'], $user_id);
            wp_send_json_success('Password updated successfully!');
        } else {
            wp_send_json_error('Current password is incorrect');
        }
    } else {
        wp_send_json_error('Error: Missing fields or user not logged in.');
    }
    wp_die();
}

add_action('wp_ajax_delete_account', 'delete_account_callback');
function delete_account_callback() {
    $user_id = get_current_user_id();
    if ($user_id) {
        wp_delete_user($user_id);
        wp_send_json_success('Account deleted successfully!');
    }
    wp_die();
}

add_action('wp_ajax_upload_user_profile_image', 'upload_user_profile_image_callback');

function upload_user_profile_image_callback() {
    $user_id = get_current_user_id();
    $uploadedfile = $_FILES['image'];
    $upload_overrides = array('test_form' => false);
    $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

    if ($movefile && !isset($movefile['error'])) {
        // Generate thumbnail
        $image_id = wp_insert_attachment(array(
            'guid'           => $movefile['url'],
            'post_mime_type' => $movefile['type'],
            'post_title'     => preg_replace('/\.[^.]+$/', '', basename($movefile['file'])),
            'post_content'   => '',
            'post_status'    => 'inherit'
        ), $movefile['file']);

        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata($image_id, $movefile['file']);
        wp_update_attachment_metadata($image_id, $attach_data);

        // Get thumbnail URL
        $thumbnail_url = wp_get_attachment_image_url($image_id, 'thumbnail');

        // Update user meta with thumbnail URL
        update_user_meta($user_id, 'profile_picture', $thumbnail_url);

        wp_send_json_success(array('url' => $thumbnail_url));
    } else {
        wp_send_json_error($movefile['error']);
    }

    wp_die();
}
add_action('wp_ajax_upload_user_profile_image', 'upload_user_profile_image_callback');
add_action('wp_ajax_nopriv_upload_user_profile_image', 'upload_user_profile_image_callback');

function create_budget_expense_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'budget_expense';

    // Check if the table already exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id INT NOT NULL AUTO_INCREMENT,
            user_id INT NOT NULL,
            category_id INT NOT NULL,
            expense VARCHAR(255),
            vendor_name VARCHAR(255),
            vendor_contact VARCHAR(255),
            estimated_cost DECIMAL(10, 2),
            actual_cost DECIMAL(10, 2),
            paid DECIMAL(10, 2),
            created_at current_time('mysql'),
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
add_action('after_switch_theme', 'create_budget_expense_table');

add_action('wp_ajax_add_expense', 'add_expense_handler');
function add_expense_handler() {
    global $wpdb;
    $user_id = get_current_user_id();
    $category_id = isset($_POST['category_id_add']) ? intval($_POST['category_id_add']) : 0;
    $expense = sanitize_text_field($_POST['expense']);
    $vendor_name = sanitize_text_field($_POST['vendor_name']);
    $vendor_contact = sanitize_text_field($_POST['vendor_contact']);
    $estimated_cost = floatval($_POST['estimated_cost']);
    $actual_cost = floatval($_POST['actual_cost']);
    $paid = floatval($_POST['paid']);

    $result = $wpdb->insert(
        $wpdb->prefix . 'budget_expense',
        [
            'user_id' => $user_id,
            'category_id' => $category_id,
            'expense' => $expense,
            'vendor_name' => $vendor_name,
            'vendor_contact' => $vendor_contact,
            'estimated_cost' => $estimated_cost,
            'actual_cost' => $actual_cost,
            'paid' => $paid,
            'created_at' => current_time('mysql')
        ]
    );

    if ($result) {
        wp_send_json_success('Expense added successfully.');
    } else {
        wp_send_json_error('Failed to add expense.');
    }

    wp_die(); // this is required to terminate immediately and return a proper response
}

function get_expense_list($category_id) {
    global $wpdb;
    $user_id = get_current_user_id(); // Get the current logged-in user ID
    $table_name = $wpdb->prefix . 'budget_expense';
    $query = "SELECT * FROM $table_name WHERE user_id = %d";
    $query_params = [$user_id];
    if ($category_id !== null) {
        $query .= " AND category_id = %d";
        $query_params[] = $category_id;
    }

    $results = $wpdb->get_results(
        $wpdb->prepare($query, $query_params),
        ARRAY_A
    );

    return $results;
}


add_action('wp_ajax_get_expenses_ajax', 'get_expenses_ajax_handler');
function get_expenses_ajax_handler() {
    $expenses = get_expense_list();

    // Sort expenses by 'created_at' in descending order
    usort($expenses, function($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    });

    $total_estimated = 0;
    $total_actual = 0;
    $total_paid = 0;
    $total_due = 0;
    
    ob_start();
    foreach ($expenses as $expense) {
        $total_estimated += $expense['estimated_cost'];
        $total_actual += $expense['actual_cost'];
        $total_paid += $expense['paid'];
        $total_due += $expense['due'];
        
        echo '<tr>';
        echo '<td class="expense">' . esc_html($expense['expense']) . '</td>';
        echo '<td class="text-single-line">' . esc_html($expense['vendor_name']) . '</td>';
        echo '<td class="text-single-line">' . esc_html($expense['vendor_contact']) . '</td>';
        echo '<td class="text-single-line">$' . esc_html($expense['estimated_cost']) . '</td>';
        echo '<td class="text-single-line">$' . esc_html($expense['actual_cost']) . '</td>';
        echo '<td class="text-single-line">$' . esc_html($expense['paid']) . '</td>';
        echo '<td class="text-single-line">$' . esc_html($expense['due']) . '</td>';
        echo '<td class="actions"><div>';
        echo '<a href="#" class="edit theme-btn" data-id="' . esc_attr($expense['id']) . '" data-bs-toggle="modal" data-bs-target="#edit-expense-popup">';
        echo '<i class="fa-solid fa-pen"></i>';
        echo '</a>';
        echo '<a href="#" class="delete theme-btn" data-id="' . esc_attr($expense['id']) . '">';
        echo '<i class="fa-regular fa-trash-can"></i>';
        echo '</a>';
        echo '</div></td>';
        echo '</tr>';
    }
    
    echo '<tr>';
    echo '<td>Total</td>';
    echo '<td>&nbsp;</td>';
    echo '<td>&nbsp;</td>';
    echo '<td class="text-single-line" data-toggle="tooltip" data-bs-original-title="' . esc_html($total_estimated) . '">$' . esc_html($total_estimated) . '</td>';
    echo '<td class="text-single-line" data-toggle="tooltip" data-bs-original-title="' . esc_html($total_actual) . '">$' . esc_html($total_actual) . '</td>';
    echo '<td class="text-single-line" data-toggle="tooltip" data-bs-original-title="' . esc_html($total_paid) . '">$' . esc_html($total_paid) . '</td>';
    echo '<td class="text-single-line" data-toggle="tooltip" data-bs-original-title="' . esc_html($total_due) . '">$' . esc_html($total_due) . '</td>';
    echo '<td class="actions">&nbsp;</td>';
    echo '</tr>';
    
    $output = ob_get_clean();
    echo $output;
    wp_die();
}

// expense and category dumy entries hook
function add_default_budget_data_on_user_registration($user_id) {
    global $wpdb;

    // Set up default categories with their icon classes
    $categories = [
        ['Rentals', 'truck-moving'],
        ['Bartenders', 'martini-glass'],
        ['DJ/VJ', 'music'],
        ['Choreographers', 'person'],
        ['Cole sparklers', 'volume-high'],
        ['360° Photo Booth', 'camera'],
        ['Transportation', 'car'],
        ['Alterations', 'person'],
        ['Priest', 'hands-praying'],
        ['Florist', 'fan'],
        ['Pre Event Shooting', 'camera'],
        ['Mehndi services', 'hand'],
        ['Makeup artist', 'paintbrush'],
        ['Saree draping', 'shirt']
    ];

    // Insert default categories into `prefix_budget_category`
    foreach ($categories as $category) {
        $wpdb->insert(
            "{$wpdb->prefix}budget_category",
            [
                'user_id'       => $user_id,
                'category_name' => $category[0],
                'icon_class'    => $category[1],
                'created_at'    => current_time('mysql'),
            ]
        );
        // Get the inserted category ID
        $category_id = $wpdb->insert_id;

        // Insert two dummy expenses for each category into `prefix_budget_expense`
        for ($i = 1; $i <= 2; $i++) {
            $wpdb->insert(
                "{$wpdb->prefix}budget_expense",
                [
                    'user_id'         => $user_id,
                    'category_id'     => $category_id,
                    'expense'         => "{$category[0]} Expense $i",
                    'estimated_cost'  => 500.00,
                    'actual_cost'     => 0.00,
                    'paid'            => 0.00,
                    'created_at'      => current_time('mysql'),
                ]
            );
        }
    }

    // Insert a dummy task into `prefix_todo_list`
    $wpdb->insert(
        "{$wpdb->prefix}todo_list",
        [
            'title'    => 'Sample Task',
            'date'     => current_time('mysql'),
            'category' => 'General',
            'notes'    => 'This is a sample task for new users.',
            'user_id'  => $user_id,
        ]
    );

    // Insert a sample vendor into `prefix_vendor_list`
    $wpdb->insert(
        "{$wpdb->prefix}vendor_list",
        [
            'user_id'              => $user_id,
            'category'             => 'Catering',
            'name'                 => 'Sample Vendor',
            'email'                => 'vendor@example.com',
            'phone'                => '123-456-7890',
            'notes'                => 'This is a sample vendor for demonstration.',
            'social_media_profile' => 'https://facebook.com/samplevendor',
            'pricing'              => 'Affordable',
        ]
    );

    // Insert a sample entry into `prefix_my_vendor_list`
    $wpdb->insert(
        "{$wpdb->prefix}my_vendor_list",
        [
            'user_id'              => $user_id,
            'category'             => 'Photography',
            'name'                 => 'My Vendor',
            'email'                => 'myvendor@example.com',
            'phone'                => '987-654-3210',
            'notes'                => 'This is a sample entry in my vendor list.',
            'social_media_profile' => 'https://instagram.com/myvendor',
            'pricing'              => 'Premium',
        ]
    );
}

add_action('user_register', 'add_default_budget_data_on_user_registration');


add_action('wp_ajax_get_budget_expense_by_category', 'get_budget_expense_by_category');
add_action('wp_ajax_nopriv_get_budget_expense_by_category', 'get_budget_expense_by_category'); // If you want to allow non-logged-in users

function get_budget_expense_by_category() {
    if (isset($_POST['category_id'])) {
        $category_id = intval($_POST['category_id']); // Sanitize input

        $expenses = get_expense_list($category_id); // Fetch expenses for the category

        if (!empty($expenses)) {
            wp_send_json_success(['expenses' => $expenses]);
        } else {
            wp_send_json_error('No expenses found for this category.');
        }
    }
    wp_die();
}

// Fetch expense details for editing
add_action('wp_ajax_get_expense_details', 'get_expense_details');
function get_expense_details() {
    global $wpdb;
    $expense_id = intval($_POST['id']);
    $table_name = $wpdb->prefix . 'budget_expense';

    $expense = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $expense_id), ARRAY_A);

    if ($expense) {
        wp_send_json_success($expense);
    } else {
        wp_send_json_error('Expense not found.');
    }
}

// Update expense details
add_action('wp_ajax_edit_expense', 'edit_expense');
function edit_expense() {
    global $wpdb;
    $expense_id = intval($_POST['id']);
    $category_id = intval($_POST['category_id']);
    $expense = sanitize_text_field($_POST['expense']);
    $vendor_name = sanitize_text_field($_POST['vendor_name']);
    $vendor_contact = sanitize_text_field($_POST['vendor_contact']);
    $estimated_cost = floatval($_POST['estimated_cost']);
    $actual_cost = floatval($_POST['actual_cost']);
    $paid = floatval($_POST['paid']);

    $result = $wpdb->update(
        $wpdb->prefix . 'budget_expense',
        [
            'category_id' => $category_id,
            'expense' => $expense,
            'vendor_name' => $vendor_name,
            'vendor_contact' => $vendor_contact,
            'estimated_cost' => $estimated_cost,
            'actual_cost' => $actual_cost,
            'paid' => $paid
        ],
        ['id' => $expense_id]
    );

    if ($result !== false) {
        wp_send_json_success('Expense updated successfully.');
    } else {
        wp_send_json_error('Failed to update expense.');
    }
}

// Add AJAX action for deleting an expense
add_action('wp_ajax_delete_expense', 'delete_expense');
function delete_expense() {
    global $wpdb;
    $expense_id = intval($_POST['id']); // Sanitize input
    $table_name = $wpdb->prefix . 'budget_expense';

    $result = $wpdb->delete($table_name, ['id' => $expense_id]);

    if ($result !== false) {
        wp_send_json_success('Expense deleted successfully.');
    } else {
        wp_send_json_error('Failed to delete expense.');
    }
}

//clear_budget for current user only
add_action('wp_ajax_clear_budget', 'clear_budget');
function clear_budget() {
    global $wpdb;
    $user_id = get_current_user_id();
    $table_name = $wpdb->prefix . 'budget_expense';

    $result = $wpdb->delete($table_name, ['user_id' => $user_id]);

    if ($result !== false) {
        wp_send_json_success('Budget cleared successfully.');
    } else {
        wp_send_json_error('Failed to clear budget.');
    }
}