<?php

//show save offers
function handle_get_save_offers()
{
    if (!empty($_POST['ids']) && is_array($_POST['ids'])) {
        $current_locale = isset($_GET['current_locale']) ? $_GET['current_locale'] : 'en';
        $paged = isset($_POST['currentPage']) ? $_POST['currentPage'] : '';

        $args = array(
            'post_type' => 'job-offer',
            'posts_per_page' => -1,
            'post__in' => $_POST['ids'],
            'lang' => $current_locale,
            'suppress_filters' => false,
            'paged' => $paged,
        );
        $query = new WP_Query($args);


        // Setting query var so we can pass offers list into template part
        $data = array(
            'query' => $query,

        );
        set_query_var('data', $data);

        // Capture the output of the template part
        ob_start();

        get_template_part('template-parts/offers-loop', null, $data);

        $output = ob_get_clean();

        // Return the captured output
        echo $output;

        wp_reset_postdata();
        wp_die();
    }
}

add_action('wp_ajax_get_save_offers', 'handle_get_save_offers');
add_action('wp_ajax_nopriv_get_save_offers', 'handle_get_save_offers');


//show applied offers
function handle_get_applied_offers()
{
    if (!empty($_POST['ids']) && is_array($_POST['ids'])) {
        $current_locale = isset($_GET['current_locale']) ? $_GET['current_locale'] : 'en';
        $paged = isset($_POST['currentPage']) ? $_POST['currentPage'] : '';

        $args = array(
            'post_type' => 'job-offer',
            'posts_per_page' => -1,
            'post__in' => $_POST['ids'],
            'lang' => $current_locale,
            'suppress_filters' => false,
            'paged' => $paged,
        );
        $query = new WP_Query($args);

        // Setting query var so we can pass offers list into template part
        $data = array(
            'query' => $query,
        );
        set_query_var('data', $data);

        // Capture the output of the template part
        ob_start();

        get_template_part('template-parts/offers-loop', null, $data);

        $output = ob_get_clean();

        // Return the captured output
        echo $output;

        wp_reset_postdata();
        wp_die();
    }
}

add_action('wp_ajax_get_applied_offers', 'handle_get_applied_offers');
add_action('wp_ajax_nopriv_get_applied_offers', 'handle_get_applied_offers');


//show dislike offers
function handle_get_dislike_offers()
{
    if (!empty($_POST['ids']) && is_array($_POST['ids'])) {
        $current_locale = isset($_GET['current_locale']) ? $_GET['current_locale'] : 'en';
        $paged = isset($_POST['currentPage']) ? $_POST['currentPage'] : '';

        $args = array(
            'post_type' => 'job-offer',
            'posts_per_page' => -1,
            'post__in' => $_POST['ids'],
            'lang' => $current_locale,
            'suppress_filters' => false,
            'paged' => $paged,
        );
        $query = new WP_Query($args);

        // Setting query var so we can pass offers list into template part
        $data = array(
            'query' => $query,
        );
        set_query_var('data', $data);

        // Capture the output of the template part
        ob_start();

        get_template_part('template-parts/offers-loop', null, $data);

        $output = ob_get_clean();

        // Return the captured output
        echo $output;

        wp_reset_postdata();
        wp_die();
    }

}

add_action('wp_ajax_get_dislike_offers', 'handle_get_dislike_offers');
add_action('wp_ajax_nopriv_get_dislike_offers', 'handle_get_dislike_offers');