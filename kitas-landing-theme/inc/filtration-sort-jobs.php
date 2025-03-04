<?php

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
add_action('wp_ajax_look_for_jobs', 'look_for_jobs');
add_action('wp_ajax_nopriv_look_for_jobs', 'look_for_jobs');

function look_for_jobs(){

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
function search_by_title($where, $wp_query){
	global $wpdb;
	if ($search_term = $wp_query->get('s')) {
		$where .= " AND " . $wpdb->posts . ".post_title LIKE '%" . esc_sql($wpdb->esc_like($search_term)) . "%'";
	}
	return $where;
}


//featured jobs render
add_action('wp_ajax_featured_jobs', 'get_featured_jobs');
add_action('wp_ajax_nopriv_featured_jobs', 'get_featured_jobs');

function get_featured_jobs(){

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
function sort_posts_by_criteria_callback(){
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
