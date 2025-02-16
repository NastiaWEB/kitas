<?php

function save_images_ava()
{
    if (isset($_FILES['avatar_company']) && $_FILES['avatar_company']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = wp_upload_dir();
        $file = $_FILES['avatar_company'];
        $filename = $file['name'];
        $file_type = $file['type'];
        $hashed_filename = md5($filename . microtime()) . '_' . $filename;
        $full_path = $upload_dir['path'] . '/' . $hashed_filename;

        if (move_uploaded_file($file['tmp_name'], $full_path)) {
            $attachment = [
                'post_mime_type' => $file_type,
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($hashed_filename)),
                'post_content' => '',
                'post_status' => 'inherit',
                'guid' => $upload_dir['url'] . '/' . basename($hashed_filename)
            ];

            $attachment_id = wp_insert_attachment($attachment, $full_path);
            require_once (ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata($attachment_id, $full_path);
            wp_update_attachment_metadata($attachment_id, $attach_data);

            return $attachment_id;
        }
    }
    return null;
}


function handle_company_profile_update($formData)
{

    $user_id = get_current_user_id();


    update_field('company_name', sanitize_text_field($_POST['companyName']), 'user_' . $user_id);
    update_field('company_website', sanitize_text_field($_POST['website']), 'user_' . $user_id);
    update_field('company_size_profile', sanitize_text_field($_POST['companySize']), 'user_' . $user_id);
    update_field('working_hours', sanitize_text_field($_POST['workingHours']), 'user_' . $user_id);
    update_field('teaching_approach_profile', sanitize_textarea_field($_POST['teachingApproach']), 'user_' . $user_id);
    update_field('childcare_place', sanitize_text_field($_POST['childcarePlace']), 'user_' . $user_id);
    $attachment_id = save_images_ava();
    if ($attachment_id) {
        update_field('avatar_company', $attachment_id, 'user_' . $user_id);
    }

    $gallery_ids = [];
    if (isset($_FILES['photoGallery'])) {
        foreach ($_FILES['photoGallery']['name'] as $key => $value) {
            if ($_FILES['photoGallery']['error'][$key] == UPLOAD_ERR_OK) {
                $upload_dir = wp_upload_dir();
                $file_name = $_FILES['photoGallery']['name'][$key];
                $file_tmp = $_FILES['photoGallery']['tmp_name'][$key];
                $file_type = $_FILES['photoGallery']['type'][$key];
                $hashed_filename = md5($file_name . microtime()) . '_' . $file_name;
                $full_path = $upload_dir['path'] . '/' . $hashed_filename;

                if (move_uploaded_file($file_tmp, $full_path)) {
                    $attachment = [
                        'post_mime_type' => $file_type,
                        'post_title' => preg_replace('/\.[^.]+$/', '', basename($hashed_filename)),
                        'post_content' => '',
                        'post_status' => 'inherit',
                        'guid' => $upload_dir['url'] . '/' . basename($hashed_filename)
                    ];

                    $attachment_id = wp_insert_attachment($attachment, $full_path);
                    require_once (ABSPATH . 'wp-admin/includes/image.php');
                    $attach_data = wp_generate_attachment_metadata($attachment_id, $full_path);
                    wp_update_attachment_metadata($attachment_id, $attach_data);
                    $gallery_ids[] = $attachment_id;
                }
            }
        }
    }

    if (!empty($gallery_ids)) {
        update_field('company_page_gallery', $gallery_ids, 'user_' . $user_id);
    }


    wp_send_json_success(array('message' => 'Profile updated successfully'));

}

add_action('wp_ajax_handle_company_profile_update', 'handle_company_profile_update');

//Contact person settings
function save_avatar_user()
{
  
    if (isset($_FILES['user-avatar']) && $_FILES['user-avatar']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = wp_upload_dir();
        $file = $_FILES['user-avatar'];
        $filename = $file['name'];
        $file_type = $file['type'];
        $hashed_filename = md5($filename . microtime()) . '_' . $filename;
        $full_path = $upload_dir['path'] . '/' . $hashed_filename;

        if (move_uploaded_file($file['tmp_name'], $full_path)) {
            $attachment = [
                'post_mime_type' => $file_type,
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($hashed_filename)),
                'post_content' => '',
                'post_status' => 'inherit',
                'guid' => $upload_dir['url'] . '/' . basename($hashed_filename)
            ];

            $attachment_id = wp_insert_attachment($attachment, $full_path);
            require_once (ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata($attachment_id, $full_path);
            wp_update_attachment_metadata($attachment_id, $attach_data);

            return $attachment_id;
        }
    }
    return null;
}
function handle_user_profile_update()
{

    $user_id = get_current_user_id();

    $firstName = isset($_POST['firstName']) ? sanitize_text_field($_POST['firstName']) : '';
    $lastName = isset($_POST['lastName']) ? sanitize_text_field($_POST['lastName']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $jobTitle = isset($_POST['jobTitle']) ? sanitize_text_field($_POST['jobTitle']) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';

    update_user_meta($user_id, 'first_name', $firstName);
    update_user_meta($user_id, 'last_name', $lastName);
    update_field('company_email', $email, 'user_' . $user_id);
    update_field('title_job', $jobTitle, 'user_' . $user_id);
    update_field('phone_number', $phone, 'user_' . $user_id);
    $attachment_id = save_avatar_user();
    if ($attachment_id) {
        update_field('user_avatar', $attachment_id, 'user_' . $user_id);
    }

    wp_send_json_success(array('message' => 'Profile updated successfully'));
}

add_action('wp_ajax_handle_user_profile_update', 'handle_user_profile_update');

//delete account
function delete_user_account() {
    if (is_user_logged_in()) {
        require_once(ABSPATH.'wp-admin/includes/user.php' );
        $user_id = get_current_user_id();
        wp_delete_user($user_id);
        wp_send_json_success(['message' => 'Account deleted successfully']);
    } else {
        wp_send_json_error(['message' => 'User not logged in']);
    }
}
add_action('wp_ajax_delete_user_account', 'delete_user_account');


//for active post
function handle_get_save_posts() {
    if (!empty($_POST['ids']) && is_array($_POST['ids'])) {
        $current_locale = isset($_POST['current_locale']) ? sanitize_text_field($_POST['current_locale']) : 'en';
        $paged = isset($_POST['currentPage']) ? intval($_POST['currentPage']) : 1;

        $args = array(
            'post_type' => 'job-offer',
            'posts_per_page' => 2,
            'post__in' => array_map('intval', $_POST['ids']),
            'lang' => $current_locale,
            'suppress_filters' => false,
            'paged' => $paged,
        );
        $query = new WP_Query($args);

        // Pagination links
        $pagination = paginate_links(
            array(
                'base' => home_url('/my-job-offers/%_%'),
                'format' => 'page/%#%',
                'current' => max(1, $paged),
                'total' => $query->max_num_pages,
                'add_args' => false
            )
        );
        $pagination = str_replace('<a class="prev page-numbers"', '<a class="prev page-numbers" data-paged="prev"', $pagination);
        $pagination = str_replace('<a class="next page-numbers"', '<a class="next page-numbers" data-paged="next"', $pagination);

        // Setting query var so we can pass offers list into template part
        $data = array(
            'query' => $query,
            'pages' => $pagination,
        );
        set_query_var('data', $data);

        // Capture the output of the template part
        ob_start();
        get_template_part('template-parts/offers-loop', null, $data);
        $output = ob_get_clean();

        // Return the captured output along with pagination
        wp_send_json_success(array('content' => $output, 'pagination' => $pagination));

        wp_reset_postdata();
        wp_die();
    } else {
        wp_send_json_error('Invalid IDs');
    }
}

add_action('wp_ajax_get_save_posts', 'handle_get_save_posts');
add_action('wp_ajax_nopriv_get_save_posts', 'handle_get_save_posts');

function handle_get_hidden_posts() {
    if (!empty($_POST['ids']) && is_array($_POST['ids'])) {
        $current_locale = isset($_POST['current_locale']) ? sanitize_text_field($_POST['current_locale']) : 'en';
        $paged = isset($_POST['currentPage']) ? intval($_POST['currentPage']) : 1;

        $args = array(
            'post_type' => 'job-offer',
            'posts_per_page' => 2,
            'post__in' => array_map('intval', $_POST['ids']),
            'lang' => $current_locale,
            'suppress_filters' => false,
            'paged' => $paged,
        );
        $query = new WP_Query($args);

        // Pagination links
        $pagination = paginate_links(
            array(
                'base' => home_url('/my-job-offers/%_%'),
                'format' => 'page/%#%',
                'current' => max(1, $paged),
                'total' => $query->max_num_pages,
                'add_args' => false
            )
        );
        $pagination = str_replace('<a class="prev page-numbers"', '<a class="prev page-numbers" data-paged="prev"', $pagination);
        $pagination = str_replace('<a class="next page-numbers"', '<a class="next page-numbers" data-paged="next"', $pagination);

        // Setting query var so we can pass offers list into template part
        $data = array(
            'query' => $query,
            'pages' => $pagination,
        );
        set_query_var('data', $data);

        // Capture the output of the template part
        ob_start();
        get_template_part('template-parts/offers-loop', null, $data);
        $output = ob_get_clean();

        // Return the captured output along with pagination
        wp_send_json_success(array('content' => $output, 'pagination' => $pagination));

        wp_reset_postdata();
        wp_die();
    } else {
        wp_send_json_error('Invalid IDs');
    }
}

add_action('wp_ajax_get_hidden_posts', 'handle_get_hidden_posts');
add_action('wp_ajax_nopriv_get_hidden_posts', 'handle_get_hidden_posts');












