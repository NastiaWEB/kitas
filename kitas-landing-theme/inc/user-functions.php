<?php

//custom displaying of 'First name' field in user registration form
add_action('user_register', 'kitas_user_register');
function kitas_user_register($user_id){
	if (!empty($_POST['first_name'])) {
		update_user_meta($user_id, 'first_name', sanitize_text_field($_POST['first_name']));
	}
}

add_filter('registration_errors', 'kitas_registration_errors', 10, 3);
function kitas_registration_errors($errors, $sanitized_user_login, $user_email){
	if (empty($_POST['first_name']) || !empty($_POST['first_name']) && trim($_POST['first_name']) == '') {
		$errors->add('first_name_error', sprintf('<strong>%s</strong>: %s', __('ERROR', 'kitas'), __('Please fill your name.', 'kitas')));
	}
	return $errors;
}

//creating custom user role "Company"
add_role(
	'company',
	__('Company'),
	array(
		'read' => true,
		'delete_posts' => true,
		'delete_published_posts' => true,
		'edit_posts' => true,
		'publish_posts' => true,
		'edit_published_posts' => true,
		'upload_files' => true
	)
);

//adding capabilities for Company to create Job Offers
function job_offer_caps(){
	$role = get_role('company');
	$role->add_cap('read');
	$role->add_cap('read_job-offer');
	$role->add_cap('read_private_job-offer');
	$role->add_cap('edit_job-offer');
	$role->add_cap('edit_published_job-offer');
	$role->add_cap('publish_job-offer');
	$role->add_cap('delete_private_job-offer');
	$role->add_cap('delete_published_job-offer');
}

add_action('admin_init', 'job_offer_caps', 5);



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
function create_user_company(){

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



//if user is not logged in, redirect to registration page
function restrict_edit_company_page()
{
	if (is_page('edit-company-page')) {
		if (!is_user_logged_in()) {
			wp_redirect(home_url('/registrations/'));
			exit;
		}
	}
}
add_action('template_redirect', 'restrict_edit_company_page');

function restrict_edit_company_page_de()
{
	if (is_page('unternehmensseite-bearbeiten')) {
		if (!is_user_logged_in()) {
			wp_redirect(home_url('/de/anmeldungen//'));
			exit;
		}
	}
}
add_action('template_redirect', 'restrict_edit_company_page_de');

//redirect from registration page if user is logged in
function redirect_logged_in_users()
{
	if (is_user_logged_in() && !current_user_can('administrator')) {

		$current_url = home_url(add_query_arg(null, null));

		$redirect_url_en = home_url('/my-profile/');
		$redirect_url_de = home_url('/de/mein-profil/');

		if (strpos($current_url, '/registrations/') !== false) {
			wp_redirect($redirect_url_en);
			exit;
		} elseif (strpos($current_url, '/de/anmeldungen/') !== false) {
			wp_redirect($redirect_url_de);
			exit;
		}
	}
}
add_action('template_redirect', 'redirect_logged_in_users');


//redirect to login page if user is not logged in
function redirect_if_not_logged_in()
{
	if (!is_user_logged_in()) {
		$current_url = home_url($_SERVER['REQUEST_URI']);

		$protected_pages = array(
			home_url('/contact-person-settings/'),
			home_url('/my-profile/')
		);
		foreach ($protected_pages as $page) {
			if (strpos($current_url, $page) !== false) {
				wp_redirect(home_url('/registrations/'));
				exit();
			}
		}
	}
}
add_action('template_redirect', 'redirect_if_not_logged_in');

//hide admin bar for users/companies
function hide_admin_bar_for_subscribers()
{
	if (current_user_can('subscriber')) {
		add_filter('show_admin_bar', '__return_false');
	}
}
add_action('after_setup_theme', 'hide_admin_bar_for_subscribers');
