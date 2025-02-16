<?php
//save avatar user
function save_avatar_user_edit_profile() {
    if (isset($_FILES['edit-user-avatar']) && $_FILES['edit-user-avatar']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = wp_upload_dir();
        $file = $_FILES['edit-user-avatar'];
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
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata($attachment_id, $full_path);
            wp_update_attachment_metadata($attachment_id, $attach_data);

            return $attachment_id;
        }
    }
    return null;
}

//edit profile user
function edit_profile_user() {
    $user_id = get_current_user_id();
    if (!$user_id) {
        wp_send_json_error('User not logged in.');
    }

    if (isset($_POST['first_name'])) {
        $first_name = sanitize_text_field($_POST['first_name']);
        $last_name = sanitize_text_field($_POST['last_name']);
        $email = sanitize_email($_POST['email']);
        $city = sanitize_text_field($_POST['city']);
        $zip_code = sanitize_text_field($_POST['zip_code']);
        $phone = sanitize_text_field($_POST['phone']);

        wp_update_user(array(
            'ID' => $user_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'user_email' => $email
        ));

        update_user_meta($user_id, 'address_profile', $city);
        update_user_meta($user_id, 'zip_code', $zip_code);
        update_user_meta($user_id, 'phone_number', $phone);

        $attachment_id = save_avatar_user_edit_profile();
        if ($attachment_id) {
            update_user_meta($user_id, 'user_avatar', $attachment_id);
        }

        wp_send_json_success('Profile updated successfully.');
    } else {
        wp_send_json_error('Invalid form data.');
    }
}
add_action('wp_ajax_edit_profile_user', 'edit_profile_user');
add_action('wp_ajax_nopriv_edit_profile_user', 'edit_profile_user');

//redirect from user-edit-profile.php
function redirect_non_logged_in_users() {
    if (!is_user_logged_in() && is_page('user-edit-profile')) {

        wp_redirect(home_url('/registrations'));
        exit();
    }
}
add_action('template_redirect', 'redirect_non_logged_in_users');


//save job title + category 
function save_job_data() {
    if (!isset($_POST['job_data']) || !is_array($_POST['job_data'])) {
        error_log('Invalid data format');
        wp_send_json_error('Invalid data');
        return;
    }

    $job_data = $_POST['job_data'];
    $user_id = get_current_user_id();

    if (!$user_id) {
        error_log('User not logged in');
        wp_send_json_error('User not logged in');
        return;
    }



    $deleted = delete_field('job_title', 'user_' . $user_id);
    if ($deleted) {
        error_log('Old data deleted successfully');
    } else {
        error_log('Failed to delete old data');
    }

    foreach ($job_data as $index => $data) {
        if (isset($data['title']) && isset($data['category'])) {
            $row = [
                'job_title' => sanitize_text_field($data['title']),
                'job_category' => sanitize_text_field($data['category']),
            ];
            $added = add_row('job_title', $row, 'user_' . $user_id);
            if ($added) {
                error_log("Data added successfully for index $index");
            } else {
                error_log("Failed to add data for index $index");
            }
        }
    }

    wp_send_json_success('Data saved successfully');
}

add_action('wp_ajax_save_job_data', 'save_job_data');
add_action('wp_ajax_nopriv_save_job_data', 'save_job_data'); 


//save location
function save_location_data() {
    if (!isset($_POST['location_data']) || !is_array($_POST['location_data'])) {
        error_log('Invalid data format');
        wp_send_json_error('Invalid data');
        return;
    }

    $location_data = $_POST['location_data'];
    $user_id = get_current_user_id();

    if (!$user_id) {
        error_log('User not logged in');
        wp_send_json_error('User not logged in');
        return;
    }

    $deleted = delete_field('job_location', 'user_' . $user_id);
    if ($deleted) {
        error_log('Old data deleted successfully');
    } else {
        error_log('Failed to delete old data');
    }

    foreach ($location_data as $index => $data) {
        if (!empty($data['city']) && !empty($data['cantone'])) {
            $row = [
                'job_city' => sanitize_text_field($data['city']),
                'job_location' => (int) $data['cantone'], 
            ];
            $added = add_row('job_location', $row, 'user_' . $user_id);
            if ($added) {
                error_log("Data added successfully for index $index");
            } else {
                error_log("Failed to add data for index $index");
            }
        }
    }

    wp_send_json_success('Data saved successfully');
}

add_action('wp_ajax_save_location_data', 'save_location_data');
add_action('wp_ajax_nopriv_save_location_data', 'save_location_data');

function save_experience_files() {
    if (!isset($_FILES['experience_files']) && !isset($_POST['files_to_delete'])) {
        wp_send_json_error('No files provided');
        return;
    }

    $user_id = get_current_user_id();

    if (isset($_FILES['experience_files'])) {
        $files = $_FILES['experience_files'];
        foreach ($files['name'] as $key => $value) {
            if ($files['name'][$key]) {
                $file = array(
                    'name' => $files['name'][$key],
                    'type' => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error' => $files['error'][$key],
                    'size' => $files['size'][$key]
                );

                $_FILES = array("upload_attachment" => $file);
                foreach ($_FILES as $file => $array) {
                    $newupload = media_handle_upload($file, 0);
                    if (is_wp_error($newupload)) {
                        wp_send_json_error($newupload->get_error_message());
                    } else {
                        add_row('file_experience', ['experience' => $newupload], 'user_' . $user_id);
                    }
                }
            }
        }
    }

    if (isset($_POST['files_to_delete'])) {
        $files_to_delete = $_POST['files_to_delete'];
        foreach ($files_to_delete as $file_url) {
            $file_id = attachment_url_to_postid($file_url);
            if ($file_id) {
                wp_delete_attachment($file_id, true);
            }
        }
    }

    wp_send_json_success('Files saved successfully');
}

add_action('wp_ajax_save_experience_files', 'save_experience_files');

function save_additional_files() {
    if (!isset($_FILES['additional_files']) && !isset($_POST['files_to_delete'])) {
        wp_send_json_error('No files provided');
        return;
    }

    $user_id = get_current_user_id();

    if (isset($_FILES['additional_files'])) {
        $files = $_FILES['additional_files'];
        foreach ($files['name'] as $key => $value) {
            if ($files['name'][$key]) {
                $file = array(
                    'name' => $files['name'][$key],
                    'type' => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error' => $files['error'][$key],
                    'size' => $files['size'][$key]
                );

                $_FILES = array("upload_attachment" => $file);
                foreach ($_FILES as $file => $array) {
                    $newupload = media_handle_upload($file, 0);
                    if (is_wp_error($newupload)) {
                        wp_send_json_error($newupload->get_error_message());
                    } else {
                        add_row('file_additional', ['additional' => $newupload], 'user_' . $user_id);
                    }
                }
            }
        }
    }

    if (isset($_POST['files_to_delete'])) {
        $files_to_delete = $_POST['files_to_delete'];
        foreach ($files_to_delete as $file_url) {
            $file_id = attachment_url_to_postid($file_url);
            if ($file_id) {
                wp_delete_attachment($file_id, true);
            }
        }
    }

    wp_send_json_success('Files saved successfully');
}

add_action('wp_ajax_save_additional_files', 'save_additional_files');




////


function save_acf_field_value() {
    if (!isset($_POST['field_name']) || !isset($_POST['field_value'])) {
        wp_send_json_error('Invalid parameters.');
    }

    $field_name = sanitize_text_field($_POST['field_name']);
    $field_value = filter_var($_POST['field_value'], FILTER_VALIDATE_BOOLEAN);

    $user_id = get_current_user_id();
    if ($user_id) {
        update_field($field_name, $field_value, 'user_' . $user_id);
        wp_send_json_success();
    } else {
        wp_send_json_error('User not logged in.');
    }
}

add_action('wp_ajax_save_acf_field_value', 'save_acf_field_value');
add_action('wp_ajax_nopriv_save_acf_field_value', 'save_acf_field_value');



function get_acf_field_value() {
    if (!isset($_POST['field_name'])) {
        wp_send_json_error('Invalid parameters.');
    }

    $field_name = sanitize_text_field($_POST['field_name']);

    $user_id = get_current_user_id();
    if ($user_id) {
        $field_value = get_field($field_name, 'user_' . $user_id);
        wp_send_json_success(['value' => $field_value]);
    } else {
        wp_send_json_error('User not logged in.');
    }
}

add_action('wp_ajax_get_acf_field_value', 'get_acf_field_value');
add_action('wp_ajax_nopriv_get_acf_field_value', 'get_acf_field_value');