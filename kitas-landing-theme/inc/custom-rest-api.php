<?php

add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/job-offers', array(
        'methods'  => 'GET',
        'callback' => 'get_filtered_job_offers',
        'permission_callback' => '__return_true',
    ));
});

function get_filtered_job_offers($request) {
    $user_id = get_current_user_id();
    $dislike_list = get_user_dislike_list($user_id);

    $per_page = $request->get_param('per_page') ? intval($request->get_param('per_page')) : 10;
    $page = $request->get_param('page') ? intval($request->get_param('page')) : 1;
    $search_name = $request->get_param('search_name');
    $search_where = $request->get_param('search_where');
    $order_by = $request->get_param('orderby') ? sanitize_text_field($request->get_param('orderby')) : 'date';
    $order = $request->get_param('order') ? sanitize_text_field($request->get_param('order')) : 'DESC';

    $args = [
        'post_type'      => 'job-offer',
        'post_status'    => 'publish',
        'posts_per_page' => $per_page,
        'paged'          => $page,
        'orderby'        => $order_by,
        'order'          => $order,
        'post__not_in'   => $dislike_list,
        'meta_query'     => [['key' => 'checkactivevacationtruefalse', 'compare' => 'EXISTS']],
        'tax_query'      => ['relation' => 'AND'],
    ];

    // Apply search filters
    if (!empty($search_name)) {
        $args['s'] = $search_name;
    }

    // Apply taxonomy filters
    $taxonomies = ['job_category', 'location', 'employment-type', 'teaching-approach', 'offer_language'];
    foreach ($taxonomies as $taxonomy) {
        if ($request->get_param($taxonomy)) {
            $terms = explode(',', $request->get_param($taxonomy));
            $args['tax_query'][] = [
                'taxonomy' => $taxonomy,
                'field'    => 'slug',
                'terms'    => $terms,
            ];
        }
    }

    $query = new WP_Query($args);
    $jobs = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $jobs[] = [
                'id'    => get_the_ID(),
                'title' => get_the_title(),
                'link'  => get_permalink(),
            ];
        }
        wp_reset_postdata();
    }

    return rest_ensure_response([
        'jobs'        => $jobs,
        'total'       => (int) $query->found_posts,
        'per_page'    => $per_page,
        'total_pages' => (int) $query->max_num_pages,
        'current_page' => $page,
    ]);
}

// Function to get user's disliked jobs
function get_user_dislike_list($user_id) {
    $dislike_list = get_field('hide_post_dislike', 'user_' . $user_id);
    if (!$dislike_list) return [];

    return array_map(function ($item) {
        return isset($item['hide_post_dislike_id']) ? intval($item['hide_post_dislike_id']) : null;
    }, $dislike_list);
}
