<?php

// Theme supports
function kitas_landing_theme_setup()
	load_theme_textdomain('kitas-landing-theme', get_template_directory() . '/languages');
	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
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
		array('search-form','comment-form','comment-list','gallery','caption','style','script',)
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

function kitas_landing_theme_content_width(){	$GLOBALS['content_width'] = apply_filters('kitas_landing_theme_content_width', 640);}
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
