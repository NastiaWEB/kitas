<?php

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


//Allow to use REST Api for filtration
function allow_custom_taxonomy_filters($args, $request) {
    $taxonomies = array('job_category', 'location', 'employment-type', 'teaching-approach', 'offer_language');

    foreach ($taxonomies as $taxonomy) {
        if (isset($request[$taxonomy])) {
            $terms = $request[$taxonomy];

            // Check if there are multiple values (comma-separated)
            if (strpos($terms, ',') !== false) {
                $terms = explode(',', $terms); // Convert to array if multiple
            } else {
                $terms = array($terms); // Wrap single value in an array
            }

            $args['tax_query'][] = array(
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => $terms,
            );
        }
    }

    return $args;
}
add_filter('rest_job_offer_query', 'allow_custom_taxonomy_filters', 10, 2);
