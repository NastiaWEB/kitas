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

// Register CPT and taxonomies
include_once get_stylesheet_directory() . '.inc/register-cpt-taxonomies.php';
// Theme setup
include_once get_stylesheet_directory() . '/inc/supports-widgets.php';
// Theme enqueue scripts
include_once get_stylesheet_directory() . '/inc/enqueue-scripts.php';
//Save offer form
include_once get_stylesheet_directory() . '/inc/form-vacancy-save.php';
//User function for registration, login, redirects and other
include_once get_stylesheet_directory() . '/inc/user-functions.php';
//Edit company page
include_once get_stylesheet_directory() . '/inc/save-edit-company-page.php';
//Applied jobs
include_once get_stylesheet_directory() . '/inc/applied-jobs.php';
//My job offers
include_once get_stylesheet_directory() . '/inc/my-job-offers.php';
//User edit profile
include_once get_stylesheet_directory() . '/inc/user-edit-profile.php';
//Implement login with google form.
include_once get_stylesheet_directory() . '/inc/login-with-google.php';
//Implement the Custom Header feature.
include_once get_stylesheet_directory() . '/inc/custom-header.php';
//Custom template tags for this theme.
include_once get_stylesheet_directory() . '/inc/template-tags.php';
//Functions which enhance the theme by hooking into WordPress.
include_once get_stylesheet_directory() . '/inc/template-functions.php';
//Customizer additions.
include_once get_stylesheet_directory() . '/inc/customizer.php';
//Default functions for filtration and sorting jobs
include_once get_stylesheet_directory() . '/inc/filtration-sort-jobs.php';
// Other functions
include_once get_stylesheet_directory() . '/inc/helpers.php';
//Load Jetpack compatibility file.
if (defined('JETPACK__VERSION')) {
	include_once get_stylesheet_directory() . '/inc/jetpack.php';
}
//adding custom menus to the theme
function header_menu_2(){	register_nav_menu('header-menu-2', __('Header menu 2'));}
add_action('init', 'header_menu_2');

function header_menu_3(){register_nav_menu('header-menu-3', __('Header menu 3'));}
add_action('init', 'header_menu_3');

function header_menu_company(){register_nav_menu('header-menu-hidden-company', __('Header menu hidden company'));}
add_action('init', 'header_menu_company');

function header_menu_user(){register_nav_menu('header-menu-hidden-user', __('Header menu hidden user'));}
add_action('init', 'header_menu_user');

function footer_menu_1(){register_nav_menu('footer-menu-1', __('Footer menu 1'));}
add_action('init', 'footer_menu_1');

function footer_menu_2(){register_nav_menu('footer-menu-2', __('Footer menu 2'));}
add_action('init', 'footer_menu_2');

function footer_menu_3(){register_nav_menu('footer-menu-3', __('Footer menu 3'));}
add_action('init', 'footer_menu_3');
