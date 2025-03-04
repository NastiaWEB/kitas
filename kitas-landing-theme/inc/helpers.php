<?php
//getting and setting post views, needed for counter in job card
function getThemeimPostViews($postID){
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
function get_breadcrumb(){
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

function custom_shortcode_atts_wpcf7_filter($out, $pairs, $atts){
	$my_attr = 'destination-email';

	if (isset($atts[$my_attr])) {
		$out[$my_attr] = $atts[$my_attr];
	}

	return $out;
}


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

function update_active_vacation_status(){
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
