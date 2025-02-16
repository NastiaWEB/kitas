<?php
//create account
function my_create_user_function()
{
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $username = isset($_POST['fullName']) ? $_POST['fullName'] : '';

    $user_id = email_exists($email);

    if ($user_id) {
        echo "Error: Email is already taken!";
        wp_die();
    }

    $user_id = wp_create_user($username, $password, $email);

    if (!is_wp_error($user_id)) {
        $user = new WP_User($user_id);
        $user->set_role('subscriber');
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);

    }


    wp_die();
}

add_action('wp_ajax_my_create_user_action', 'my_create_user_function');
add_action('wp_ajax_nopriv_my_create_user_action', 'my_create_user_function');



//login
function login_account()
{
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $user = wp_authenticate($email, $password);

    if (!is_wp_error($user)) {
        $response = array('status' => 'succes', 'message' => 'Succes.');
        echo json_encode($response);
        wp_set_current_user($user->ID, $user->user_login);
        wp_set_auth_cookie($user->ID);
    } else {
        $response = array('status' => 'error', 'message' => 'Invalid email or password.');
        echo json_encode($response);
    }
    wp_die();
}

add_action('wp_ajax_login_account', 'login_account');
add_action('wp_ajax_nopriv_login_account', 'login_account');


//check user logged in
function check_user_logged_in()
{
    if (is_user_logged_in()) {
        wp_send_json_success(array('logged_in' => true));
    } else {
        wp_send_json_success(array('logged_in' => false));
    }
}

add_action('wp_ajax_check_user_logged_in', 'check_user_logged_in');
add_action('wp_ajax_nopriv_check_user_logged_in', 'check_user_logged_in');

//creat user conmpany
function create_user_company()
{

    $user_email = sanitize_email($_POST['userEmail']);
    $user_password = sanitize_text_field($_POST['userPassword']);
    $first_name = sanitize_text_field($_POST['firstName']);
    $last_name = sanitize_text_field($_POST['lastName']);
    $full_name = sanitize_text_field($_POST['fullName']);
    $title_job = sanitize_text_field($_POST['titleJob']);
    $phone_user = sanitize_text_field($_POST['phoneUser']);
    $working_email = sanitize_email($_POST['workingEmail']);
    $company_name = sanitize_text_field($_POST['companyName']);
    $select_city = sanitize_text_field($_POST['SelectCity']);
    $company_city = sanitize_text_field($_POST['companyCity']);
    $company_street = sanitize_text_field($_POST['companyStreet']);
    $company_building = sanitize_text_field($_POST['companyBuilding']);
    $company_zip = sanitize_text_field($_POST['companyZip']);
    $company_team_members = sanitize_text_field($_POST['companyTeamMembers']);
    $company_childcare_place = sanitize_text_field($_POST['companyChildcarePlace']);
    $company_website = sanitize_text_field($_POST['companyWebsite']);

    //create user
    $user_id = wp_create_user($user_email, $user_password, $user_email);
    if (is_wp_error($user_id)) {
        echo 'Error: ' . $user_id->get_error_message();
        wp_die();
    }

    // update user data
    wp_update_user([
        'ID' => $user_id,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'nickname' => $full_name,
        'display_name' => $full_name
    ]);

    // save custom fields
    update_field('company_name', $company_name, 'user_' . $user_id);
    update_field('location', $select_city, 'user_' . $user_id);
    update_field('address_profile', $company_city, 'user_' . $user_id);
    update_field('company_size_profile', $company_team_members, 'user_' . $user_id);
    update_field('company_website', $company_website, 'user_' . $user_id);
    update_field('company_email', $working_email, 'user_' . $user_id);
    update_field('title_job', $title_job, 'user_' . $user_id);
    update_field('phone_number', $phone_user, 'user_' . $user_id);
    update_field('address_street', $company_street, 'user_' . $user_id);
    update_field('building', $company_building, 'user_' . $user_id);
    update_field('zip_code', $company_zip, 'user_' . $user_id);
    update_field('childcare_place', $company_childcare_place, 'user_' . $user_id);

    $creds = [
        'user_login' => $user_email,
        'user_password' => $user_password,
        'remember' => true
    ];
    $user = wp_signon($creds, false);

    if (is_wp_error($user)) {
        wp_send_json_error(['message' => 'Failed to log in user: ' . $user->get_error_message()]);
    } else {
        wp_send_json_success(['message' => 'User created and logged in successfully']);
    }

    $home_url = home_url();
    wp_redirect($home_url . '/edit-company-page/');

    wp_die();
}

add_action('wp_ajax_create_user_company', 'create_user_company');
add_action('wp_ajax_nopriv_create_user_company', 'create_user_company');


//create user profile
function create_user_for_looking_a_job() {
    
    if (isset($_POST['userEmail']) && isset($_POST['userPassword'])) {
        $email = sanitize_email($_POST['userEmail']);
        $password = sanitize_text_field($_POST['userPassword']);


        if (!is_email($email)) {
            wp_send_json_error('Invalid email address.');
        }

        if (empty($password)) {
            wp_send_json_error('Password cannot be empty.');
        }

        $userdata = array(
            'user_login' => $email,
            'user_email' => $email,
            'user_pass' => $password,
        );

        $user_id = wp_insert_user($userdata);

        if (is_wp_error($user_id)) {
            wp_send_json_error($user_id->get_error_message());
        } else {
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id);
            wp_send_json_success('User created successfully.');
        }
    } else {
        wp_send_json_error('Missing email or password.');
    }
}
add_action('wp_ajax_create_user_for_looking_a_job', 'create_user_for_looking_a_job');
add_action('wp_ajax_nopriv_create_user_for_looking_a_job', 'create_user_for_looking_a_job');
