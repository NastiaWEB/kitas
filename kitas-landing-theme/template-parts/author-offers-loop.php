<?php
/**
 * Template part for displaying offers loop on jobs search page
 *
 * @package Kitas_Landing_Theme
 */

$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));

$paged = isset($_GET['currentPage']) ? intval($_GET['currentPage']) : 1;
$lang = isset($_GET['current_locale']) ? sanitize_text_field($_GET['current_locale']) : 'en';
$author_id = isset($_GET['author']) ? intval($_GET['author']) : $curauth->ID;

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

$base_url = add_query_arg(
    array(
        'current_locale' => $lang,
        'author' => $author_id
    ), get_author_posts_url($author_id));

$pagination = paginate_links(
    array(
        'base' => $base_url . '%_%',
        'format' => '&currentPage=%#%',
        'current' => max(1, $paged),
        'total' => $total_query->max_num_pages,
        'prev_text' => '<img src="/wp-content/themes/kitas-landing-theme/img/caret.svg" class="pagination-icon prev-icon-left" alt="Previous">',
        'next_text' => '<img src="/wp-content/themes/kitas-landing-theme/img/caret.svg" class="pagination-icon next-icon-right" alt="Previous">',
        'add_args' => false
    )
);
$pagination = str_replace('<a class="prev page-numbers"', '<a class="prev page-numbers author-prev" data-paged="prev"', $pagination);
$pagination = str_replace('<a class="next page-numbers"', '<a class="next page-numbers author-next" data-paged="next"', $pagination);

$button_html = '<div class="load-more author-more">
<button class="button color-teal" role="button">Load more</button>
</div>';

$data = array(
    'query' => $total_query,
    'pages' => $pagination
);

set_query_var('data', $data);

if ($paged > $total_query->max_num_pages) {
    echo '<h1 class="noMore">No more jobs!</h1>';
} else {
    echo '<div id="jobsList">';
    get_template_part('template-parts/offers-loop', null, $data);
    echo '</div>';
    echo '<div class="button-container">' . $button_html . '</div>';
    echo '<div class="pagination-links">' . $pagination . '</div>';
}

wp_reset_postdata();

