<?php

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


//Font awesome
function enqueue_font_awesome(){
	wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');
