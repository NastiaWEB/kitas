<?php
/**
 * Kitas Landing Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Kitas_Landing_Theme
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function kitas_landing_theme_setup()
{
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Kitas Landing Theme, use a find and replace
	 * to change 'kitas-landing-theme' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('kitas-landing-theme', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'kitas-landing-theme'),
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
			'kitas_landing_theme_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'kitas_landing_theme_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function kitas_landing_theme_content_width()
{
	$GLOBALS['content_width'] = apply_filters('kitas_landing_theme_content_width', 640);
}
add_action('after_setup_theme', 'kitas_landing_theme_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function kitas_landing_theme_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar', 'kitas-landing-theme'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'kitas-landing-theme'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}
add_action('widgets_init', 'kitas_landing_theme_widgets_init');

/**
 * Enqueue scripts and styles.
 */

function kitas_scripts() {
    $template_uri = get_template_directory_uri();

    wp_enqueue_style('kitas-main-style', "$template_uri/css/main.css");
    wp_enqueue_style('kitas-job-card-style', "$template_uri/css/job-card.css");
    wp_enqueue_style('mobile-responsive-style', "$template_uri/css/mobile-responsive.css");
    wp_enqueue_style('blog-page', "$template_uri/css/blog-page.css");
    wp_enqueue_style('article-page', "$template_uri/css/article-page.css");
    wp_enqueue_script('site-scripts', "$template_uri/js/scripts.js", ['jquery'], '1.0', true);
    
    wp_enqueue_script('jquery', 'https://cdn.jsdelivr.net/jquery/latest/jquery.min.js', [], null, true);
    wp_enqueue_script('moment', 'https://cdn.jsdelivr.net/momentjs/latest/moment.min.js', ['jquery'], null, true);
    wp_enqueue_script('jquery-ui', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', ['jquery'], null, true);
    wp_enqueue_script('daterangepicker', 'https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js', ['jquery', 'moment'], null, true);
    wp_enqueue_script('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['jquery'], null, true);
    
    if (is_page_template('search-jobs.php')) {
        wp_enqueue_script('kitas-main-script', "$template_uri/js/main.js", ['jquery'], null, true);
    }

    wp_enqueue_style('slick-theme-css', "$template_uri/assets/src/library/css/slick-theme.css");
    wp_enqueue_style('slick-css', "$template_uri/assets/src/library/css/slick.css");
    wp_enqueue_script('slick-js', "$template_uri/assets/src/library/js/slick.min.js", ['jquery'], null, true);
    wp_enqueue_script('custom-scripts', "$template_uri/js/customJquery.js", ['jquery'], '1.0', true);
    
    if (!is_page_template('template-parts/form-vacancy.php')) {
        wp_enqueue_script('jquery-ui-slider', "$template_uri/js/jquery-ui.js", ['jquery'], '1.0', true);
    }

    wp_localize_script('custom-scripts', 'myAjax', ['ajaxurl' => admin_url('admin-ajax.php')]);

    if (is_singular('job-offer')) {
        wp_enqueue_style('kitas-job-page-style', "$template_uri/css/job-page.css");
    }
    
    if (strpos($_SERVER['REQUEST_URI'], '/author/') !== false) {
        wp_enqueue_style('kitas-company-page-style', "$template_uri/css/company-page.css");
        wp_enqueue_script('author_js', "$template_uri/js/author-script.js", ['jquery'], '1.0', true);
    }

    $templates_with_scripts = [
        'template-parts/form-vacancy.php' => 'form-vacancy-js',
        'template-parts/edit-company-page.php' => 'edit-company-page',
        'featured-jobs.php' => 'featured-script-js',
        'template-parts/applied-jobs.php' => 'applied-script-js',
        'template-parts/my-job-offers.php' => 'my-job-offers-script-js',
        'template-parts/user-edit-profile.php' => 'user-edit-profile-script-js'
    ];

    foreach ($templates_with_scripts as $template => $script) {
        if (is_page_template($template)) {
            wp_enqueue_script($script, "$template_uri/js/$script.js", ['jquery'], '1.0', true);
        }
    }
    
    if (is_page_template('template-parts/registrations-en.php') || is_page_template('/inc/template-short-code.php')) {
        wp_enqueue_style('registr-page-style', "$template_uri/css/registr-page-style.css");
    }
    
    wp_enqueue_script('registrations-js', "$template_uri/js/registration.js", ['jquery'], null, true);
}
add_action('wp_enqueue_scripts', 'kitas_scripts', 99);



//low priority styles
function kitas_scripts_lp()
{
	wp_enqueue_style('kitas-reset-style', get_template_directory_uri() . '/css/reset.css');
}
add_action('wp_enqueue_scripts', 'kitas_scripts_lp', 97);



function kitas_landing_theme_scripts()
{
	wp_enqueue_style('kitas-landing-theme-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('kitas-landing-theme-style', 'rtl', 'replace');

	wp_enqueue_script('kitas-landing-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'kitas_landing_theme_scripts');


// Register job offers

function register_job_offer_post_type() {
    // Register Custom Post Type
    $labels = array(
        'name'               => _x('Job Offers', 'Post Type General Name', 'textdomain'),
        'singular_name'      => _x('Job Offer', 'Post Type Singular Name', 'textdomain'),
        'menu_name'          => __('Job Offers', 'textdomain'),
        'name_admin_bar'     => __('Job Offer', 'textdomain'),
        'add_new_item'       => __('Add New Job Offer', 'textdomain'),
        'edit_item'          => __('Edit Job Offer', 'textdomain'),
        'view_item'          => __('View Job Offer', 'textdomain'),
        'all_items'          => __('All Job Offers', 'textdomain'),
        'search_items'       => __('Search Job Offers', 'textdomain'),
        'not_found'          => __('No job offers found.', 'textdomain'),
        'not_found_in_trash' => __('No job offers found in Trash.', 'textdomain'),
    );

    $args = array(
        'label'               => __('Job Offer', 'textdomain'),
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'menu_icon'           => 'dashicons-businessman', // Change icon if needed
        'supports'            => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'rewrite'             => array('slug' => 'job-offers'),
        'show_in_rest'        => true,
        'taxonomies'          => array('job_category', 'location', 'employment-type', 'teaching-approach', 'offer_language'),
    );

    register_post_type('job-offer', $args);

    // Register Taxonomies
    $taxonomies = array(
        'job_category'     => array('singular' => 'Job Category', 'plural' => 'Job Categories'),
        'location'         => array('singular' => 'Location', 'plural' => 'Locations'),
        'employment-type'  => array('singular' => 'Employment Type', 'plural' => 'Employment Types'),
        'teaching-approach' => array('singular' => 'Teaching Approach', 'plural' => 'Teaching Approaches'),
        'offer_language'   => array('singular' => 'Offer Language', 'plural' => 'Offer Languages'),
    );

    foreach ($taxonomies as $taxonomy => $names) {
        $tax_labels = array(
            'name'              => __($names['plural'], 'textdomain'),
            'singular_name'     => __($names['singular'], 'textdomain'),
            'search_items'      => __('Search ' . $names['plural'], 'textdomain'),
            'all_items'         => __('All ' . $names['plural'], 'textdomain'),
            'parent_item'       => __('Parent ' . $names['singular'], 'textdomain'),
            'parent_item_colon' => __('Parent ' . $names['singular'] . ':', 'textdomain'),
            'edit_item'         => __('Edit ' . $names['singular'], 'textdomain'),
            'update_item'       => __('Update ' . $names['singular'], 'textdomain'),
            'add_new_item'      => __('Add New ' . $names['singular'], 'textdomain'),
            'new_item_name'     => __('New ' . $names['singular'] . ' Name', 'textdomain'),
            'menu_name'         => __($names['plural'], 'textdomain'),
        );

        $tax_args = array(
            'labels'            => $tax_labels,
            'hierarchical'      => true, // Set to false if you want non-hierarchical (tags)
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'rewrite'           => array('slug' => $taxonomy),
        );

        register_taxonomy($taxonomy, 'job-offer', $tax_args);
    }
    
}
add_action('init', 'register_job_offer_post_type');



/**
 * Implement the Shortcode.
 */
require get_template_directory() . '/inc/template-short-code.php';
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
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

//adding custom menus to the theme
function header_menu_2()
{
	register_nav_menu('header-menu-2', __('Header menu 2'));
}
add_action('init', 'header_menu_2');

function header_menu_3()
{
	register_nav_menu('header-menu-3', __('Header menu 3'));
}
add_action('init', 'header_menu_3');

function header_menu_company()
{
	register_nav_menu('header-menu-hidden-company', __('Header menu hidden company'));
}
add_action('init', 'header_menu_company');

function header_menu_user()
{
	register_nav_menu('header-menu-hidden-user', __('Header menu hidden user'));
}
add_action('init', 'header_menu_user');

function footer_menu_1()
{
	register_nav_menu('footer-menu-1', __('Footer menu 1'));
}
add_action('init', 'footer_menu_1');

function footer_menu_2()
{
	register_nav_menu('footer-menu-2', __('Footer menu 2'));
}
add_action('init', 'footer_menu_2');

function footer_menu_3()
{
	register_nav_menu('footer-menu-3', __('Footer menu 3'));
}
add_action('init', 'footer_menu_3');


//getting and setting post views, needed for counter in job card
function getThemeimPostViews($postID)
{
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if ($count == '') {
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
		return "0";
	}
	return $count;
}
function setThemeimPostViews($postID)
{
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if ($count == '') {
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
	} else {
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);


//breadcrumb
function get_breadcrumb()
{
	echo '<a href="' . home_url() . '" rel="nofollow">Home</a>';

	if (is_category() || is_single()) {
		if (is_single()) {
			$post_terms = explode(' | ', strip_tags(get_the_term_list(get_the_ID(), 'job_category', '', ' | ', '')));
			if (is_array($post_terms)) {
				echo " / ";
				echo '<a href="' . home_url() . '?catFilter=' . urlencode($post_terms[0]) . '" rel="nofollow">' . $post_terms[0] . '</a>';
			} else {
				echo " / ";
				echo implode(" / ", $post_terms);
			}
			echo " / ";
			the_title();
		}
	} elseif (is_page()) {
		echo "/";
		the_title();
	} elseif (is_search()) {
		echo "/ Search Results for... ";
		echo '"<em>';
		the_search_query();
		echo '</em>"';
	}
}


//removal of auto-added <p> tags in CF7, it's needed to make creating templates possible
add_filter('wpcf7_autop_or_not', '__return_false');

//adding 'destination-email' attribute to CF7 shortcode, needed to implement dynamic recipient
add_filter('shortcode_atts_wpcf7', 'custom_shortcode_atts_wpcf7_filter', 10, 3);

function custom_shortcode_atts_wpcf7_filter($out, $pairs, $atts)
{
	$my_attr = 'destination-email';

	if (isset($atts[$my_attr])) {
		$out[$my_attr] = $atts[$my_attr];
	}

	return $out;
}

//custom displaying of 'First name' field in user registration form
add_action('user_register', 'kitas_user_register');
function kitas_user_register($user_id)
{
	if (!empty($_POST['first_name'])) {
		update_user_meta($user_id, 'first_name', sanitize_text_field($_POST['first_name']));
	}
}

add_filter('registration_errors', 'kitas_registration_errors', 10, 3);
function kitas_registration_errors($errors, $sanitized_user_login, $user_email)
{

	if (empty($_POST['first_name']) || !empty($_POST['first_name']) && trim($_POST['first_name']) == '') {
		$errors->add('first_name_error', sprintf('<strong>%s</strong>: %s', __('ERROR', 'kitas'), __('Please fill your name.', 'kitas')));

	}

	return $errors;
}

//creating custom user role "Company"
add_role(
	'company',
	__('Company'),
	array(
		'read' => true,
		'delete_posts' => true,
		'delete_published_posts' => true,
		'edit_posts' => true,
		'publish_posts' => true,
		'edit_published_posts' => true,
		'upload_files' => true
	)
);

//adding capabilities for Company to create Job Offers
function job_offer_caps()
{

	$role = get_role('company');
	$role->add_cap('read');
	$role->add_cap('read_job-offer');
	$role->add_cap('read_private_job-offer');
	$role->add_cap('edit_job-offer');
	$role->add_cap('edit_published_job-offer');
	$role->add_cap('publish_job-offer');
	$role->add_cap('delete_private_job-offer');
	$role->add_cap('delete_published_job-offer');
}

add_action('admin_init', 'job_offer_caps', 5);


//jobs filter

//wp filter for removing posts that don't match the search

function search_by_name($where)
{
	global $wpdb;
	$search_name = isset($_POST['searchTermWhat']) ? $_POST['searchTermWhat'] : '';
	if (!empty($search_name)) {
		$where .= " AND $wpdb->posts.post_title LIKE '%" . esc_sql($wpdb->esc_like($search_name)) . "%'";
	}

	return $where;
}




//adding actions for both logged-in and nopriv users
// add_action('wp_ajax_look_for_jobs', 'look_for_jobs');
// add_action('wp_ajax_nopriv_look_for_jobs', 'look_for_jobs');

add_action('wp_ajax_look_for_jobs', 'look_for_jobs');
add_action('wp_ajax_nopriv_look_for_jobs', 'look_for_jobs');

function look_for_jobs()
{

	function get_user_dislike_list($user_id)
	{
		$dislike_list = get_field('hide_post_dislike', 'user_' . $user_id);

		if (!$dislike_list) {
			return [];
		}

		$post_ids = [];
		foreach ($dislike_list as $item) {
			if (isset($item['hide_post_dislike_id'])) {
				$post_ids[] = intval($item['hide_post_dislike_id']);
			}
		}

		return $post_ids;
	}


	$user_id = get_current_user_id();
	$dislike_list = get_user_dislike_list($user_id);


	// Getting data from jQuery
	$selected_type = isset($_POST['types']) ? $_POST['types'] : '';
	$selected_date = isset($_POST['startsAfter']) ? $_POST['startsAfter'] : '';
	$selected_langs = isset($_POST['langs']) ? $_POST['langs'] : '';
	$selected_period = isset($_POST['period']) ? $_POST['period'] : '';
	$current_locale = isset($_POST['locale']) ? $_POST['locale'] : '';
	$search_name = isset($_POST['searchTermWhat']) ? $_POST['searchTermWhat'] : '';
	$search_by = isset($_POST['searchBy']) ? $_POST['searchBy'] : '';
	$search_where = isset($_POST['searchTermWhere']) ? $_POST['searchTermWhere'] : '';
	$min_load = isset($_POST['minLoad']) ? $_POST['minLoad'] : '';
	$max_load = isset($_POST['maxLoad']) ? $_POST['maxLoad'] : '';
	$categories = isset($_POST['cats']) ? $_POST['cats'] : '';
	$paged = isset($_POST['paged']) ? $_POST['paged'] : 1; // Default to 1 if not set
	$search_bar_where = isset($_POST['locSearchBar']) ? $_POST['locSearchBar'] : '';

	$metaKey = isset($_POST['metaKey']) ? $_POST['metaKey'] : '';
	$noMore = 0;
	$orderby = isset($_POST['orderby']) ? $_POST['orderby'] : 'date'; // Default to 'date'
	$order = 'DESC'; // Default value
	$today = date('Ymd');

	// Forming query arguments
	$args = array(
		'posts_per_page' => 10, // Adjust as needed
		'paged' => $paged,
		'post_type' => 'job-offer',
		'meta_key' => 'checkactivevacationtruefalse',
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => 'checkactivevacationtruefalse',
				'compare' => 'EXISTS'
			),
		),
		'tax_query' => array('relation' => 'AND'),
		'lang' => $current_locale,
		'post__not_in' => $dislike_list, // Exclude disliked posts
	);

	// Determine the order and metaKey based on the orderby parameter
	if ($orderby) {
		switch ($orderby) {
			case 'sort-most-recent':
				$args['orderby'] = array(
					'meta_value' => 'DESC', // First order by meta_value
					'date' => 'DESC', // Then order by date
				);
				break;
			case 'sort-earliest-start-date':
				$args['orderby'] = array(
					'meta_value' => 'ASC', // First order by meta_value in ascending order
					'date' => 'ASC', // Then order by date in ascending order
				);
				break;
			default:
				$args['orderby'] = array(
					'meta_value' => 'DESC', // First order by meta_value
					'date' => 'DESC', // Then order by date
				);
				break;
		}
	}

	if (!empty($search_name)) {
		$args['s'] = $search_name;
	}

	// Add other filters to $args['tax_query'] and $args['meta_query'] as needed

	// Add taxonomy and meta query filters
	if ($search_by == 'company') {
		$args['author_name'] = $search_name;
	}

	if (is_array($selected_type)) {
		$type_filter = array(
			'taxonomy' => 'employment-type',
			'field' => 'slug',
			'terms' => $selected_type
		);
		array_push($args['tax_query'], $type_filter);
	}

	if (is_array($selected_langs)) {
		$lang_filter = array(
			'taxonomy' => 'offer_language',
			'field' => 'slug',
			'terms' => $selected_langs
		);
		array_push($args['tax_query'], $lang_filter);
	}

	if (is_array($categories)) {
		$cat_filter = array(
			'taxonomy' => 'job_category',
			'field' => 'slug',
			'terms' => $categories
		);
		array_push($args['tax_query'], $cat_filter);
	}

	if (is_array($search_where)) {
		$loc_filter = array(
			'taxonomy' => 'location',
			'field' => 'slug',
			'terms' => $search_where
		);
		array_push($args['tax_query'], $loc_filter);
	}

	if (is_array($search_bar_where)) {
		$loc_filter = array(
			'taxonomy' => 'location',
			'field' => 'slug',
			'terms' => $search_bar_where
		);
		array_push($args['tax_query'], $loc_filter);
	}

	$date_query = array();

	if (is_array($selected_period)) {
		foreach ($selected_period as $period) {
			switch ($period) {
				case 'after-1-day-ago':
					$date_query[] = array(
						'after' => '1 day ago'
					);
					break;
				case 'after-1-week-ago':
					$date_query[] = array(
						'after' => '1 week ago'
					);
					break;
				case 'before-1-week-ago':
					$date_query[] = array(
						'before' => '1 week ago'
					);
					break;
			}
		}
	}

	$args['date_query'] = $date_query;

	if (strlen($selected_date) > 0) {
		$date_filter = array(
			'key' => 'starts_on',
			'compare' => '>',
			'value' => $selected_date,
			'type' => 'DATETIME',
		);
		array_push($args['meta_query'], $date_filter);
	}

	if (strlen($min_load) > 0) {
		$minload_filter = array(
			'key' => 'workload',
			'compare' => '>=',
			'value' => intval($min_load),
			'type' => 'NUMERIC'
		);
		array_push($args['meta_query'], $minload_filter);
	}

	if (strlen($max_load) > 0) {
		$maxload_filter = array(
			'key' => 'max_workload',
			'compare' => '<=',
			'value' => intval($max_load),
			'type' => 'NUMERIC'
		);
		array_push($args['meta_query'], $maxload_filter);
	}

	// Execute query
	if ($search_by == 'job' || $search_by == '') {
		add_filter('posts_where', 'search_by_title', 10, 2);
	}

	$query = new WP_Query($args);

	if ($search_by == 'job' || $search_by == '') {
		remove_filter('posts_where', 'search_by_title', 10, 2);
	}

	// Pagination links
	$pagination = paginate_links(
		array(
			'base' => home_url('/%_%'),
			'format' => 'page/%#%',
			'current' => max(1, $paged),
			'total' => $query->max_num_pages,
			'prev_text' => '<img src="/wp-content/themes/kitas-landing-theme/img/caret.svg" class="pagination-icon prev-icon-left" alt="Previous">',
			'next_text' => '<img src="/wp-content/themes/kitas-landing-theme/img/caret.svg" class="pagination-icon next-icon-right" alt="Previous">',
			'add_args' => array(
				'orderby' => $orderby,
				'meta_key' => $metaKey,
				'order' => $order
			)
		)
	);

	$pagination = str_replace('<a class="prev page-numbers"', '<a class="prev page-numbers" data-paged="prev"', $pagination);
	$pagination = str_replace('<a class="next page-numbers"', '<a class="prev page-numbers" data-paged="next"', $pagination);

	// Setting query var so we can pass offers list into template part
	$data = array(
		'query' => $query,
		'pages' => $pagination
	);

	set_query_var('data', $data);

	if ($paged > $query->max_num_pages) {
		$noMore = 1;
	}

	// Buffering template part so we can send it
	ob_start();
	if ($paged > $query->max_num_pages) {
		echo '<h1 class="noMore">No more jobs!</h1>';
	} else {
		get_template_part('template-parts/offers-loop', null, $data);
		echo '<div class="button-container"><div class="load-more">
        <button class="button color-teal" role="button">Load more</button>
        </div></div>';
		echo '<div class="pagination-links">' . $pagination . '</div>';
	}

	$filtered = array(
		'response' => ob_get_clean(),
		'noMore' => $noMore
	);

	wp_send_json($filtered);
	wp_die();
}

// Add this function to filter posts by title
function search_by_title($where, $wp_query)
{
	global $wpdb;
	if ($search_term = $wp_query->get('s')) {
		$where .= " AND " . $wpdb->posts . ".post_title LIKE '%" . esc_sql($wpdb->esc_like($search_term)) . "%'";
	}
	return $where;
}


//featured jobs render
add_action('wp_ajax_featured_jobs', 'get_featured_jobs');
add_action('wp_ajax_nopriv_featured_jobs', 'get_featured_jobs');

function get_featured_jobs()
{

	$paged = isset($_POST['paged']) ? $_POST['paged'] : 1;
	//query vars
	$featured = $_POST['featured'];
	$current_locale = $_GET['current_locale'] ? $_GET['current_locale'] : 'en';

	array_map('intval', $featured);
	$args = array(
		'post_type' => 'job-offer',
		'posts_per_page' => -1,
		'post__in' => $featured,
		'lang' => $current_locale,
		'suppress_filters' => false,
	);
	$query = new WP_Query($args);

	//pagination links
	$pagination = paginate_links(
		array(
			'base' => home_url('/%_%'),
			'format' => 'page/%#%',
			'current' => max(1, $paged),
			'total' => $query->max_num_pages,
			'prev_text' => '<img src="/wp-content/themes/kitas-landing-theme/img/caret.svg" class="pagination-icon prev-icon-left" alt="Previous">',
			'next_text' => '<img src="/wp-content/themes/kitas-landing-theme/img/caret.svg" class="pagination-icon next-icon-right" alt="Previous">',
			'add_args' => $args
		)
	);
	$pagination = str_replace('<a class="prev page-numbers"', '<a class="prev page-numbers" data-paged="prev"', $pagination);
	$pagination = str_replace('<a class="next page-numbers"', '<a class="prev page-numbers" data-paged="next"', $pagination);

	//setting query var so we can pass offers list into template part
	$data = array(
		'query' => $query,
		'pages' => $pagination
	);
	set_query_var('data', $data);

	if ($paged > $query->max_num_pages) {
		$noMore = 1;
	}

	//buffering template part so we can send it
	ob_start();
	if ($paged > $query->max_num_pages) {
		echo '<h1 class="noMore">No more jobs!</h1>';
	} else {
		get_template_part('template-parts/offers-loop', null, $data);
		echo '<div class="button-container"><div class="load-more">
		<button class="button color-teal" role="button">Load more</button>
		</div></div>';
		echo '<div class="pagination-links">' . $pagination . '</div>';
	}

	$filtered = array(
		'response' => ob_get_clean(),
		'noMore' => $noMore
	); //getting the rendered part as html

	//sending json + unsetting filters so next time we can filter again
	wp_send_json($filtered);
	unset($args);
	wp_die();
}

//new featured jobs YY

function handle_get_featured_posts()
{
	if (!empty($_POST['ids']) && is_array($_POST['ids'])) {
		$current_locale = isset($_GET['current_locale']) ? $_GET['current_locale'] : 'en';
		$paged = isset($_POST['currentPage']) ? $_POST['currentPage'] : '';

		$args = array(
			'post_type' => 'job-offer',
			'posts_per_page' => 2,
			'post__in' => $_POST['ids'],
			'lang' => $current_locale,
			'suppress_filters' => false,
			'paged' => $paged,
		);
		$query = new WP_Query($args);

		// Pagination links
		$pagination = paginate_links(
			array(
				'base' => home_url('/saved-jobs/%_%'),
				'format' => 'page/%#%',
				'current' => max(1, $paged),
				'total' => $query->max_num_pages,
				'prev_text' => '<img src="/wp-content/themes/kitas-landing-theme/img/caret.svg" class="pagination-icon prev-icon-left" alt="Previous">',
				'next_text' => '<img src="/wp-content/themes/kitas-landing-theme/img/caret.svg" class="pagination-icon next-icon-right" alt="Previous">',
				'add_args' => $query
			)
		);
		$pagination = str_replace('<a class="prev page-numbers"', '<a class="prev page-numbers" data-paged="prev"', $pagination);
		$pagination = str_replace('<a class="next page-numbers"', '<a class="prev page-numbers" data-paged="next"', $pagination);

		// Setting query var so we can pass offers list into template part
		$data = array(
			'query' => $query,
			'pages' => $pagination,
		);
		set_query_var('data', $data);

		$button_html = '<div class="load-more">
                <button class="button color-teal" role="button">Load more</button>
                </div>';

		// Capture the output of the template part
		ob_start();
		get_template_part('template-parts/offers-loop', null, $data);
		echo '<div class="button-container">' . $button_html . '</div>';
		echo '<div class="pagination-links">' . $pagination . '</div>';
		$output = ob_get_clean();

		// Return the captured output
		echo $output;

		wp_reset_postdata();
		wp_die();
	}
}

add_action('wp_ajax_get_featured_posts', 'handle_get_featured_posts');
add_action('wp_ajax_nopriv_get_featured_posts', 'handle_get_featured_posts');



//sorting jobs
function sort_posts_by_criteria_callback()
{


	$paged = isset($_POST['paged']) ? $_POST['paged'] : 1;

	if (isset($_POST['orderby'])) {
		switch ($_POST['orderby']) {
			case 'sort-most-recent':
				$orderby = 'date';
				break;
			case 'sort-earliest-start-date':
				$orderby = 'meta_value_num';
				$metaKey = 'starts_on';
				break;
			// default:
			// 	$orderby = 'date';
			// 	break;
		}
	}

	$orderBy = '';
	$args = array(
		'post_type' => 'job-offer',
		'posts_per_page' => 2,
		//'orderby' => $orderBy,
		'order' => ($orderBy == 'meta_value_num') ? 'ASC' : 'DESC',
	);

	if (!empty($metaKey)) {
		$args['meta_key'] = $metaKey;
		$args['meta_type'] = 'TIME';
	}

	$query = new WP_Query($args);

	// Pagination links
	$pagination = paginate_links(
		array(
			'base' => home_url('/%_%'),
			'format' => 'page/%#%',
			'current' => max(1, $paged),
			'total' => $query->max_num_pages,
			'prev_text' => '<img src="/wp-content/themes/kitas-landing-theme/img/caret.svg" class="pagination-icon prev-icon-left" alt="Previous">',
			'next_text' => '<img src="/wp-content/themes/kitas-landing-theme/img/caret.svg" class="pagination-icon next-icon-right" alt="Previous">',
			'add_args' => $args
		)
	);
	$pagination = str_replace('<a class="prev page-numbers"', '<a class="prev page-numbers" data-paged="prev"', $pagination);
	$pagination = str_replace('<a class="next page-numbers"', '<a class="prev page-numbers" data-paged="next"', $pagination);

	// Setting query var to pass offers list into template part
	$data = array(
		'query' => $query,
		'pages' => $pagination
	);

	set_query_var('data', $data);

	// If there are no posts, display message
	if (!$query->have_posts()) {
		echo '<h1 class="noMore">No jobs found</h1>';
	} else {
		get_template_part('template-parts/offers-loop', null, $data);
		echo '<div class="button-container"><div class="load-more">
		<button class="button color-teal" role="button">Load more</button>
		</div></div>';
		echo '<div class="pagination-links">' . $pagination . '</div>';
	}

	wp_die();
}

//Save offer form
include_once get_stylesheet_directory() . '/inc/form-vacancy-save.php';

//User registration
include_once get_stylesheet_directory() . '/inc/registrations.php';

//Edit company page
include_once get_stylesheet_directory() . '/inc/save-edit-company-page.php';

//Applied jobs
include_once get_stylesheet_directory() . '/inc/applied-jobs.php';

//My job offers
include_once get_stylesheet_directory() . '/inc/my-job-offers.php';

//User edit profile
include_once get_stylesheet_directory() . '/inc/user-edit-profile.php';

//Custom single post template

function custom_single_template($single_template)
{
	global $post;

	if ($post->post_type == 'post') {
		$single_template = get_template_directory() . '/article-page.php';
	}

	return $single_template;
}
add_filter('single_template', 'custom_single_template');


//Font awesome
function enqueue_font_awesome()
{
	wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');


// shortcode after send cv


//if user is not logged in, redirect to registration page
function restrict_edit_company_page()
{
	if (is_page('edit-company-page')) {
		if (!is_user_logged_in()) {
			wp_redirect(home_url('/registrations/'));
			exit;
		}
	}
}
add_action('template_redirect', 'restrict_edit_company_page');

function restrict_edit_company_page_de()
{
	if (is_page('unternehmensseite-bearbeiten')) {
		if (!is_user_logged_in()) {
			wp_redirect(home_url('/de/anmeldungen//'));
			exit;
		}
	}
}
add_action('template_redirect', 'restrict_edit_company_page_de');

//redirect from registration page if user is logged in
function redirect_logged_in_users()
{
	if (is_user_logged_in() && !current_user_can('administrator')) {

		$current_url = home_url(add_query_arg(null, null));

		$redirect_url_en = home_url('/my-profile/');
		$redirect_url_de = home_url('/de/mein-profil/');

		if (strpos($current_url, '/registrations/') !== false) {
			wp_redirect($redirect_url_en);
			exit;
		} elseif (strpos($current_url, '/de/anmeldungen/') !== false) {
			wp_redirect($redirect_url_de);
			exit;
		}
	}
}
add_action('template_redirect', 'redirect_logged_in_users');


/////////////////// 05 07 - Clear form
add_action('wp_ajax_fluentform_clear_form', 'fluentform_clear_form');
add_action('wp_ajax_nopriv_fluentform_clear_form', 'fluentform_clear_form');

function fluentform_clear_form()
{
	if (!isset($_POST['form_id'])) {
		wp_send_json_error('Form ID is missing.');
		wp_die();
	}

	$form_id = intval($_POST['form_id']);

	global $wpdb;
	$entries_table = $wpdb->prefix . 'fluentform_submissions';
	$wpdb->delete($entries_table, array('form_id' => $form_id));

	$upload_dir = wp_upload_dir();
	$temp_dir = $upload_dir['basedir'] . '/fluentform/temp/';

	if (is_dir($temp_dir)) {
		$files = glob($temp_dir . '*');

		foreach ($files as $file) {
			if (is_file($file)) {
				unlink($file);
			}
		}
	}

	wp_send_json_success('Form cleared');
	wp_die();
}

function load_form_content()
{
	ob_start();
	your_form_function();
	$form_content = ob_get_clean();

	echo $form_content;
	wp_die();
}


// function my_enqueue_scripts() {
//     wp_enqueue_script('my-ajax-script', get_template_directory_uri() . '/js/my-ajax-script.js', array('jquery'), null, true);
//     wp_localize_script('my-ajax-script', 'myAjax', array(
//         'ajaxurl' => admin_url('admin-ajax.php')
//     ));
// }
// add_action('wp_enqueue_scripts', 'my_enqueue_scripts');

function update_active_vacation_status()
{
	$today = date('Ymd');

	$args = array(
		'post_type' => 'job-offer',
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key' => 'apply_by',
				'compare' => 'EXISTS'
			)
		)
	);

	$query = new WP_Query($args);
	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();

			$apply_by = get_post_meta(get_the_ID(), 'apply_by', true);

			// Convert apply_by date to timestamp and format it to Ymd
			$apply_by_timestamp = strtotime($apply_by);
			$apply_by_formatted = date('Ymd', $apply_by_timestamp);

			if ($apply_by) {
				if ($apply_by_formatted >= $today) {
					update_post_meta(get_the_ID(), 'checkactivevacationtruefalse', true);
				} else {
					update_post_meta(get_the_ID(), 'checkactivevacationtruefalse', false);
				}
			} else {
				update_post_meta(get_the_ID(), 'checkactivevacationtruefalse', false);
			}
		}
		wp_reset_postdata();
	}
}

add_action('init', 'update_active_vacation_status');


// functions for send cv popup form

function custom_cv_form_shortcode()
{
	$url = $_SERVER['REQUEST_URI'];
	$lang = 'en-US';

	if (str_contains($url, '/de')) {
		$lang = 'de-DE';
	}
	?>
	<div class="custom_cv_form_shortcode_block <?php echo $lang; ?>" style="display: none;">
		<form id="cvForm" enctype="multipart/form-data" method="post">
			<span class="modal-close"></span>
			<h3><?php esc_html_e('Application form', 'kitas-landing-theme'); ?></h3>
			<div class="form-border-send-cv">
				<input type="file" name="cv_files[]" id="cv_file_send_for_cv_doc" multiple required>
				<span
					class="file_upd_for_send_cv_uc"><?php esc_html_e('Attach your resume files', 'kitas-landing-theme'); ?></span>
				<p class="modal-form-send-cv-content-text-file">.pdf, .doc, .docx, .jpg, .jpeg, .png
					<br><br>
					<?php esc_html_e('Max 3 files up to 4MB', 'kitas-landing-theme'); ?>
				</p>
			</div>
			<span class="error-message-for-file" style="color: red; display: none;"></span>
			<div id="file-preview"></div>
			<span class="error-message" style="color: red;"></span>
			<div class="form-border-send-cv">
				<input type="text" name="name_user" class=""
					placeholder="<?php esc_html_e('Full name', 'kitas-landing-theme'); ?>" id="name_user" required>
			</div>
			<span class="error-message" style="color: red;"></span>
			<div class="form-border-send-cv">
				<input type="email" name="email" id="email_user" class=""
					placeholder="<?php esc_html_e('Email', 'kitas-landing-theme'); ?>" required>
			</div>
			<span class="error-message" style="color: red;"></span>
			<div class="form-border-send-cv">
				<textarea name="description" id="description_user" class=""
					placeholder="<?php esc_html_e('Compose a cover letter', 'kitas-landing-theme'); ?>" rows="3" cols="2"
					required></textarea>
			</div>
			<button type="submit" name="submit_cv_form"
				id="send_cv_form_button"><?php esc_html_e('Send', 'kitas-landing-theme'); ?></button>
			<p class="fz-12">
				<?php esc_html_e('By proceeding, you agree to our Terms of use and our Privacy policy', 'kitas-landing-theme'); ?>.
			</p>

			<div class="vacations_send_sv_for_list_ajax_hide">
				<p class="id_vacations_send_sv_for_list_ajax"></p>
			</div>
		</form>
	</div>

	<?php
}
add_shortcode('custom_cv_form', 'custom_cv_form_shortcode');

//ajax for send cv form
function send_custom_email($to, $subject, $message, $attachments = array())
{
	$headers = array('Content-Type: text/html; charset=UTF-8');
	$sent = wp_mail($to, $subject, $message, $headers, $attachments);
	return $sent;
}

//send cv form
function functions_for_send_cv_form()
{
	$name_user = sanitize_text_field($_POST['name_user']);
	$email = sanitize_email($_POST['email']);
	$description = sanitize_textarea_field($_POST['description']);
	$id = intval($_POST['id']);
	$files = $_FILES['cv_files'];

	$author_id = get_post_field('post_author', $id);
	$author_info = get_userdata($author_id);
	$post_title = get_the_title($id);

	error_log('Name: ' . $name_user);
	error_log('Email: ' . $email);
	error_log('Description: ' . $description);
	error_log('ID: ' . $id);

	foreach ($files['name'] as $index => $filename) {
		error_log('File ' . ($index + 1) . ': ' . $filename);
	}

	$message = "Name: $name_user<br>Email: $email<br>Description: $description<br>";
	foreach ($files['name'] as $index => $filename) {
		$message .= "File " . ($index + 1) . ": $filename<br>";
	}

	$attachments = array();
	foreach ($files['tmp_name'] as $index => $tmp_name) {
		$file = array(
			'name' => $files['name'][$index],
			'type' => $files['type'][$index],
			'tmp_name' => $tmp_name,
			'error' => $files['error'][$index],
			'size' => $files['size'][$index]
		);
		$upload = wp_handle_upload($file, array('test_form' => false));

		if (isset($upload['file'])) {
			$attachments[] = $upload['file'];
		}
	}

	$to = $author_info->user_email;
	$subject = $post_title;

	$sent = send_custom_email($to, $subject, $message, $attachments);

	if ($sent) {
		wp_send_json_success('Emails sent successfully');
	} else {
		wp_send_json_error('Failed to send email');
	}
}

add_action('wp_ajax_functions_for_send_cv_form', 'functions_for_send_cv_form');
add_action('wp_ajax_nopriv_functions_for_send_cv_form', 'functions_for_send_cv_form');


//template for
function set_job_offer_template($template)
{
	if (is_singular('job-offer')) {
		$custom_template = locate_template('single-job-offer.php');

		if ($custom_template) {
			return $custom_template;
		}
	}

	return $template;
}

add_filter('template_include', 'set_job_offer_template');

function set_default_job_offer_template($post_ID, $post, $update)
{
	if ($post->post_type == 'job-offer' && !$update) {
		update_post_meta($post_ID, '_wp_page_template', 'single-job-offer.php');
	}
}

add_action('wp_insert_post', 'set_default_job_offer_template', 10, 3);

//pagination for job author page
function vaca_author_more_prev_next()
{
	$paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
	$author_id = isset($_POST['author']) ? intval($_POST['author']) : 0;
	$lang = isset($_POST['lang']) ? sanitize_text_field($_POST['lang']) : 'en';

	$args = array(
		'post_type' => 'job-offer',
		'posts_per_page' => 10,
		'paged' => $paged,
		'author' => $author_id,
		'orderby' => array(
			'meta_value' => 'DESC',
			'date' => 'DESC'
		),
		'meta_key' => 'checkactivevacationtruefalse',
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => 'checkactivevacationtruefalse',
				'compare' => 'EXISTS'
			)
		),
		'lang' => $lang,
		'suppress_filters' => false,
	);

	$total_query = new WP_Query($args);

	ob_start();

	if ($total_query->have_posts()) {
		$data = array(
			'query' => $total_query
		);
		set_query_var('data', $data);
		get_template_part('template-parts/offers-loop');
	} else {
		echo '<h1 class="noMore">No more jobs!</h1>';
	}

	$pagination = paginate_links(
		array(
			'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
			'format' => 'page/%#%',
			'current' => max(1, $paged),
			'total' => $total_query->max_num_pages,
			'prev_text' => '<img src="/wp-content/themes/kitas-landing-theme/img/caret.svg" class="pagination-icon prev-icon-left" alt="Previous">',
			'next_text' => '<img src="/wp-content/themes/kitas-landing-theme/img/caret.svg" class="pagination-icon next-icon-right" alt="Previous">',
			'add_args' => false
		)
	);
	$pagination = str_replace('<a class="prev page-numbers"', '<a class="prev page-numbers author-prev" data-paged="prev"', $pagination);
	$pagination = str_replace('<a class="next page-numbers"', '<a class="next page-numbers author-next" data-paged="next"', $pagination);

	$response = array(
		'html' => ob_get_clean(),
		'max_num_pages' => $total_query->max_num_pages,
		'current_page' => $paged,
		'pagination' => $pagination
	);

	wp_send_json($response);
	wp_die();
}

add_action('wp_ajax_nopriv_vaca_author_more_prev_next', 'vaca_author_more_prev_next');
add_action('wp_ajax_vaca_author_more_prev_next', 'vaca_author_more_prev_next');

//redirect to login page if user is not logged in
function redirect_if_not_logged_in()
{
	if (!is_user_logged_in()) {
		$current_url = home_url($_SERVER['REQUEST_URI']);

		$protected_pages = array(
			home_url('/contact-person-settings/'),
			home_url('/my-profile/')
		);
		foreach ($protected_pages as $page) {
			if (strpos($current_url, $page) !== false) {
				wp_redirect(home_url('/registrations/'));
				exit();
			}
		}
	}
}
add_action('template_redirect', 'redirect_if_not_logged_in');

//hide admin bar for users/companies
function hide_admin_bar_for_subscribers()
{
	if (current_user_can('subscriber')) {
		add_filter('show_admin_bar', '__return_false');
	}
}
add_action('after_setup_theme', 'hide_admin_bar_for_subscribers');


//dislike global
function update_user_dislike_list()
{
	if (!is_user_logged_in()) {
		wp_send_json_error('User not logged in');
		return;
	}

	$user_id = get_current_user_id();

	$post_ids = isset($_POST['post_ids']) ? array_map('intval', $_POST['post_ids']) : [];


	if (empty($post_ids)) {
		$repeater_data = [
			['hide_post_dislike_id' => 0]
		];
	} else {
		$repeater_data = [];
		foreach ($post_ids as $post_id) {
			$repeater_data[] = ['hide_post_dislike_id' => $post_id];
		}
	}

	$update_result = update_field('hide_post_dislike', $repeater_data, 'user_' . $user_id);
	if (!$update_result) {
		wp_send_json_error('Failed to update dislike list.');
		return;
	}

	wp_send_json_success('Dislike list updated');
}
add_action('wp_ajax_update_user_dislike_list', 'update_user_dislike_list');
add_action('wp_ajax_nopriv_update_user_dislike_list', 'update_user_dislike_list');


// translation for months in date
function translate_months($text, $lang)
{
	$months_en_to_de = array(
		'January' => 'Januar',
		'February' => 'Februar',
		'March' => 'März',
		'April' => 'April',
		'May' => 'Mai',
		'June' => 'Juni',
		'July' => 'Juli',
		'August' => 'August',
		'September' => 'September',
		'October' => 'Oktober',
		'November' => 'November',
		'December' => 'Dezember'
	);

	$months_de_to_en = array(
		'Januar' => 'January',
		'Februar' => 'February',
		'März' => 'March',
		'April' => 'April',
		'Mai' => 'May',
		'Juni' => 'June',
		'Juli' => 'July',
		'August' => 'August',
		'September' => 'September',
		'Oktober' => 'October',
		'November' => 'November',
		'Dezember' => 'December'
	);

	if ($lang === 'de-DE') {
		$text = strtr($text, $months_en_to_de);
	} else {
		$text = strtr($text, $months_de_to_en);
	}

	return $text;
}
