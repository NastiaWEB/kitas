<?php

/**
 * Template name: Edit company page
 */

get_header();

$user_id = get_current_user_id();

$first_name = get_user_meta($user_id, 'first_name', true);
$last_name = get_user_meta($user_id, 'last_name', true);
$user_avatar = get_field('user_avatar', 'user_' . $user_id);

$company_name = get_field('company_name', 'user_' . $user_id);
$location_company = get_field('location', 'user_' . $user_id);
$name_location = get_term_by('id', $location_company, 'location');
$company_email = get_field('company_email', 'user_' . $user_id);
$title_job = get_field('title_job', 'user_' . $user_id);
$company_phone = get_field('phone_number', 'user_' . $user_id);

$address_profile_company = get_field('address_profile', 'user_' . $user_id);
$address_street_company = get_field('address_street', 'user_' . $user_id);
$building_company = get_field('building', 'user_' . $user_id);
$zip_code_company = get_field('zip_code', 'user_' . $user_id);
$website_company = get_field('company_website', 'user_' . $user_id);
$company_size = get_field('company_size_profile', 'user_' . $user_id);
$childcare_place = get_field('childcare_place', 'user_' . $user_id);
$working_hours = get_field('working_hours', 'user_' . $user_id);
$teaching_approach_profile = get_field('teaching_approach_profile', 'user_' . $user_id);
$avatar_company = get_field('avatar_company', 'user_' . $user_id);
$company_page_gallery = get_field('company_page_gallery', 'user_' . $user_id);

$name_company_size = '';
if ($company_size <= 10) {
    $name_company_size = 'Small';
} elseif ($company_size <= 50) {
    $name_company_size = 'Medium';
} else {
    $name_company_size = 'Large';
}

$current_url = $_SERVER['REQUEST_URI'];
$parsed_url = parse_url($current_url);
$path = $parsed_url['path'];

$current_tab = '';

$current_tab = '';

$current_language = (strpos($path, '/de/') === 0) ? 'de' : 'en';

if ($current_language === 'de') {
    switch ($path) {
        case '/de/unternehmensseite-bearbeiten/':
            $current_tab = 'edit-company-page';
            break;
        case '/de/ansprechpartnereinstellungen/':
            $current_tab = 'contact-person-settings';
            break;
        case '/de/meine-stellenangebote/':
            $current_tab = 'my-job-offers';
            break;
        default:
            $current_tab = 'edit-company-page';
            break;
    }

    $tabs = [
        'edit-company-page' => ['name' => 'Unternehmensprofil', 'url' => '/de/unternehmensseite-bearbeiten/'],
        'contact-person-settings' => ['name' => 'Ansprechpartner-Einstellungen', 'url' => '/de/ansprechpartnereinstellungen/'],
        'my-job-offers' => ['name' => 'Meine Jobangebote', 'url' => '/de/meine-stellenangebote/'],
    ];
} else {
    switch ($path) {
        case '/edit-company-page/':
            $current_tab = 'edit-company-page';
            break;
        case '/contact-person-settings/':
            $current_tab = 'contact-person-settings';
            break;
        case '/my-job-offers/':
            $current_tab = 'my-job-offers';
            break;
        default:
            $current_tab = 'edit-company-page';
            break;
    }

    $tabs = [
        'edit-company-page' => ['name' => 'Company profile', 'url' => '/edit-company-page/'],
        'contact-person-settings' => ['name' => 'Contact person settings', 'url' => '/contact-person-settings/'],
        'my-job-offers' => ['name' => 'My job offers', 'url' => '/my-job-offers/'],
    ];
}

//count post
$author_id = get_post_field('post_author');

function getJobCountByAuthor($author_id)
{
    $args = array(
        'author' => $author_id,
        'post_type' => 'job-offer',
        'posts_per_page' => -1,
        'fields' => 'ids'
    );

    $query = new WP_Query($args);
    $author_post_count = $query->post_count;



    return $author_post_count;
}

$jobCount = getJobCountByAuthor($author_id);





// function get_coordinates($address)
// {
//     $address = urlencode($address);
//     $api_key = 'AIzaSyCCaHM05cahBlQqL_yXDAxnFv3tC9d-n5I';
//     $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address}&key={$api_key}";

//     $response = wp_remote_get($url);
//     if (is_wp_error($response)) {
//         echo 'Error: ' . $response->get_error_message();
//         return false;
//     }

//     $response_body = wp_remote_retrieve_body($response);
//     $data = json_decode($response_body, true);

//     if ($data['status'] === 'OK') {
//         $coordinates = $data['results'][0]['geometry']['location'];
//         return $coordinates;
//     } else {
//         echo 'Error: ' . $data['status'] . ' - ' . (isset($data['error_message']) ? $data['error_message'] : 'No error message provided');
//         return false;
//     }
// }

// $address = $address_profile_company . " " . $address_street_company . " " . $building_company;
// $coordinates = get_coordinates($address);

// if ($coordinates) {
//     $latitude = $coordinates['lat'];
//     $longitude = $coordinates['lng'];
// } else {
//     echo $address . ' No coordinates found';
// }


?>

<div class="main-head-block">
    <div class="head-block-left-choice">
        <?php foreach ($tabs as $tab_key => $tab): ?>
            <a href="<?php echo $tab['url']; ?>"
                class="choice-option <?php echo ($current_tab === $tab_key) ? 'active' : ''; ?>">
                <div>
                    <span><?php echo $tab['name']; ?></span>
                    <?php if ($tab_key === 'my-job-offers'): ?>
                        <span class="count-tab count-my-job-offers"><?php echo $jobCount; ?></span>
                    <?php endif; ?>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>


<main id="primary" class="site-main">
    <?php switch ($current_tab):
        case 'edit-company-page': ?>
            <div class="container view-info">
                <div class="head-block">
                    <div class="head-block-left">

                        <div class="company-header">
                            <div class="company-header-avatar">

                                <?php
                                if ($avatar_company == '') {
                                    echo '<img src="/wp-content/themes/kitas-landing-theme/img/camera.svg' . '" alt="">';
                                } else {
                                    echo '<img src="' . $avatar_company . '" alt="">';
                                }
                                ?>

                            </div>
                            <div class="company-header-info">
                                <h2> <?php echo $company_name ?> </h2>
                                <span class="adrres-for-google-map">
                                    <a href="https://maps.google.com/?q=<?php echo $zip_code_company . " " . $address_profile_company . " " . $address_street_company . " " . $building_company  ?>" target="_blank"> <?php echo $zip_code_company . " " . $address_profile_company . " " . $address_street_company . " " . $building_company  ?></a>
                                   
                                    <?php echo $name_location->name; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="head-block-right">
                        <a href="#" class="company-edit-details">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/EditVectoro.svg" alt="">
                            <?php esc_html_e('Edit company details', 'kitas-landing-theme'); ?>
                        </a>
                    </div>
                </div>

                <div class="company-info-block">
                    <div class="company-info-left">
                        <h2><?php esc_html_e('Company info', 'kitas-landing-theme'); ?></h2>
                        <div class="company-info-left-block">
                            <h3><?php esc_html_e('Website', 'kitas-landing-theme'); ?></h3>
                            <?php
                            if ($website_company != '') {
                                echo '<span>' . $website_company . '</span>';
                            } else {
                                echo '<span class="information-false" id="add_company_click">' . esc_html__("Add website company", 'kitas-landing-theme') . '</span>';
                            }
                            ?>

                        </div>
                        <div class="company-info-left-block">
                            <h3><?php esc_html_e('Company size', 'kitas-landing-theme'); ?></h3>
                            <span class="information-true"><?php echo $name_company_size ?>: <?php echo $company_size ?>
                                workers, <?php echo $childcare_place ?> children</span>
                        </div>
                        <div class="company-info-left-block">
                            <h3><?php esc_html_e('Working hours', 'kitas-landing-theme'); ?></h3>
                            <?php
                            if ($working_hours != '') {
                                echo '<span>' . $working_hours . '</span>';
                            } else {
                                echo '<span class="information-false" id="add_working_click">' . esc_html__("Add working hours", 'kitas-landing-theme') . '</span>';
                            }
                            ?>
                        </div>
                        <div class="company-info-left-block top">
                            <h3><?php esc_html_e('Teaching approach', 'kitas-landing-theme'); ?></h3>

                        </div>
                        <div class="ml-40 mr-40">
                            <?php
                            if ($teaching_approach_profile != '') {
                                echo '<span>' . $teaching_approach_profile . '</span>';
                            } else {
                                echo '<span class="information-false" id="add_describe_click">' . esc_html__("Describe this Kita teaching approach", 'kitas-landing-theme') . '</span>';
                            }
                            ?>
                        </div>

                    </div>
                    <?php// if ($coordinates): ?>
                        <!-- <div class="company-info-left-right">
                            <iframe
                                src="https://www.google.com/maps/embed/v1/view?key=AIzaSyCCaHM05cahBlQqL_yXDAxnFv3tC9d-n5I&center=<?php echo $latitude; ?>,<?php echo $longitude; ?>&zoom=18"
                                width="510" height="288" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div> -->
                    <?php //endif; ?>
                </div>

                <div class="photo-gallery">
                    <h2><?php esc_html_e('Photo Gallery', 'kitas-landing-theme'); ?></h2>

                    <?php

                    if (!empty($company_page_gallery)) {
                        echo '<div class="photo-gallery-info-gallery">';
                        if (!empty($company_page_gallery)) {
                            echo "<div class='first-image-block'>";
                            echo "<img src='{$company_page_gallery[0]}' alt='Company Image'>";
                            echo "</div>";

                            if (count($company_page_gallery) > 1) {
                                echo "<div class='other-images-block'>";
                                for ($i = 1; $i < count($company_page_gallery); $i++) {
                                    echo "<img src='{$company_page_gallery[$i]}' alt='Company Image'>";
                                }
                                echo "</div>";
                            }
                        }
                        echo '</div>';
                    } else {
                        echo ' <div class="photo-gallery-info-img"><p>' . esc_html__("You have not upload any photos yet", 'kitas-landing-theme') . '. <br>
                <span class="green-text"> ' . esc_html__("Upload photos", 'kitas-landing-theme') . ' </span> <span class="green-text under" id="add_photos_click">' . esc_html__("here", 'kitas-landing-theme') . '.</span>
            </p></div>';
                    }
                    ?>


                </div>
            </div>

            <div class="container edit-info">
                <form action="send-company-info" id="company-edit-form-info">
                    <div class="head-block">
                        <div class="head-block-left">
                            <div class="company-header">
                                <div class="company-header-avatar-update">
                                    <?php
                                    if ($avatar_company == '') {
                                        echo '<h5>' . esc_html__("Upload logo", 'kitas-landing-theme') . '</h5><span class="warning-info">' . esc_html__("Only .jpg or .png images", 'kitas-landing-theme') . '<br>' . esc_html__(" Max 4MB", 'kitas-landing-theme') . '</span>';

                                    } else {
                                        echo '<img src="' . $avatar_company . '" class="    " alt="">';
                                    }
                                    ?>

                                    <img src="<?php echo get_template_directory_uri(); ?>/img/camera.svg" alt=""
                                        class="camera-right-b">

                                </div>
                                <input type="file" id="file-upload" style="display: none;" accept="image/*">
                                <div class="company-header-info">
                                    <h4><?php esc_html_e('Company name', 'kitas-landing-theme'); ?> <span
                                            class="red-required">*</span></h4>
                                    <input type="text" id="company-name" value="<?php echo $company_name ?>"
                                        placeholder="<?php esc_html_e('Company name', 'kitas-landing-theme'); ?>">
                                    <h4><?php esc_html_e('Company address', 'kitas-landing-theme'); ?> <span
                                            class="red-required">*</span></h4>
                                    <input type="text" id="company-address"
                                        placeholder="<?php esc_html_e('Company address', 'kitas-landing-theme'); ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="company-info-block">
                        <div class="company-info-left">
                            <h2><?php esc_html_e('Company info', 'kitas-landing-theme'); ?></h2>
                            </h2>
                            <div class="company-info-left-block">
                                <h3><?php esc_html_e('Website', 'kitas-landing-theme'); ?> <span class="red-required">*</span>
                                </h3>
                                <input type="text" id="webwite-company" value="<?php echo $website_company ?>"
                                    placeholder="www.globegarden.ch">
                            </div>
                            <div class="company-info-left-block">
                                <h3><?php esc_html_e('Company size', 'kitas-landing-theme'); ?> <span
                                        class="red-required">*</span></h3>
                                <input type="text" id="company-size" value="<?php echo $company_size ?>"
                                    placeholder="<?php esc_html_e('5 team members', 'kitas-landing-theme'); ?>">
                            </div>
                            <div class="company-info-left-block">
                                <h3></h3>
                                <input type="text" id="childcare_place-size" value="<?php echo $childcare_place ?>"
                                    placeholder="<?php esc_html_e('30 childcare places', 'kitas-landing-theme'); ?>">
                            </div>
                            <div class="company-info-left-block">
                                <h3><?php esc_html_e('Working hours', 'kitas-landing-theme'); ?> <span
                                        class="red-required">*</span></h3>
                                <input type="text" id="working-hours" value="<?php echo $working_hours ?>"
                                    placeholder="<?php esc_html_e('Add working hours', 'kitas-landing-theme'); ?>">
                            </div>
                            <div class="company-info-left-block top">
                                <h3><?php esc_html_e('Teaching approach', 'kitas-landing-theme'); ?> <span
                                        class="red-required">*</span></h3>
                            </div>

                            <textarea id="teaching-approach" name="teaching-approach" class="ml-40 mr-40" rows="4" cols="30"
                                placeholder="<?php esc_html_e('Describe this Kita teaching approach', 'kitas-landing-theme'); ?>"><?php echo $teaching_approach_profile ?></textarea>
                        </div>
                        <div class="company-info-left-right">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d22790.162283115184!2d26.0276224!3d44.437874099999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40b1ff427bee28c1%3A0x2b1089f802abaddc!2sPalace%20of%20Parliament!5e0!3m2!1sen!2sro!4v1717058979927!5m2!1sen!2sro"
                                width="510" height="288" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>

                    <div class="photo-gallery-main">
                        <div class="photo-gallery">
                            <h2><?php esc_html_e('Photo Gallery', 'kitas-landing-theme'); ?></h2>
                            <div class="upload-images" id="upload-images-click">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/camera-button.png" alt="">

                                <h4><?php esc_html_e('Drag and drop photos to upload', 'kitas-landing-theme'); ?></h4>
                                <p>
                                    <?php esc_html_e('Upload photos of your company to attract more applicants', 'kitas-landing-theme'); ?>.
                                    <br>
                                    <?php esc_html_e('The photos will be displayed in the company profile', 'kitas-landing-theme'); ?>.
                                </p>
                                <span
                                    class="warning-info"><?php esc_html_e('Only .jpg or .png images ', 'kitas-landing-theme'); ?><br>
                                    Max 4MB</span>

                                <input type="file" id="gallery-file-upload" multiple style="display:none;">
                                <span
                                    class="select-file-for-gallery-company"><?php esc_html_e('Select files', 'kitas-landing-theme'); ?></span>

                            </div>

                        </div>
                        <div class="gallery-show-download" style="display: none"></div>
                    </div>

                    <div class="save-cancel-block">
                        <span class="button-save-changes"><?php esc_html_e('Save changes', 'kitas-landing-theme'); ?></span>
                        <span class="button-cancel"><?php esc_html_e('Cancel', 'kitas-landing-theme'); ?></span>
                    </div>

                    <input type="submit" value="<?php esc_html_e('Submit', 'kitas-landing-theme'); ?>" style="display: none;">

                </form>
            </div>
            <?php
            break;

        case 'contact-person-settings': ?>
            <div class="container view-user">
                <div class="main-show-user">
                    <div class="show-user-left">
                        <a href="#" class="user-edit-details">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/EditVectoro.svg" alt="">
                        </a>
                        <div class="user-photo">
                            <?php
                            if ($user_avatar == '') {
                                echo '<h5>Upload logo</h5><span class="warning-info">' . esc_html__("Only .jpg or .png images", 'kitas-landing-theme') . '<br> Max 4MB</span>';

                            } else {
                                echo '<img src="' . $user_avatar . '" class="avatar-user-b" alt="">';
                            }
                            ?>

                            <img src="<?php echo get_template_directory_uri(); ?>/img/camera.svg" alt="" class="camera-right-b">

                        </div>
                        <div class="user-info">

                            <h4 class="user-name"><?php echo $first_name . " " . $last_name ?></h4>
                            <p class="hiring-p"><?php echo $title_job ?></p>
                            <div class="line-blue-block"></div>
                            <div class="user-block-info-profile-fields-plus">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/email.svg" alt="email">
                                <p class="your-user-email"> <?php echo $company_email ?> </p>
                            </div>
                            <div class="user-block-info-profile-fields-plus"> <img
                                    src="<?php echo get_template_directory_uri(); ?>/img/phone.svg" alt="phone">
                                <p class="your-user-phone"><?php echo $company_phone ?></p>
                            </div>
                        </div>


                    </div>
                    <div class="update-user-left">
                        <form action="update-user-form" id="update-user-form-fields">

                            <div class="user-avatar-change">
                                <div class="user-block-info-profile-avatar" id="block-info-profile-avatar-update-img">
                                    <?php
                                    if ($user_avatar == '') { ?>
                                        <div class="user-avatar">
                                            <span class="user-avatar-firstname"><?php echo $first_name[0]; ?></span>
                                            <span class="user-avatar-lastname"><?php echo $last_name[0]; ?></span>
                                        </div>

                                        <?php
                                    } else {
                                        echo '<img src="' . $user_avatar . '" class="uploaded-image-for-user-avatar" alt="">';
                                    }
                                    ?>

                                    <img src="<?php echo get_template_directory_uri(); ?>/img/camera.svg" alt=""
                                        class="camera-right-b">
                                </div>
                                <input type="file" id="file-upload-user-avatar" style="display: none;" accept="image/*">
                            </div>

                            <h4><?php esc_html_e('First name', 'kitas-landing-theme'); ?> <span class="red">*</span> </h4>
                            <input type="text" id="first-name-user" value="<?php echo $first_name ?>"
                                placeholder="<?php esc_html_e('First name', 'kitas-landing-theme'); ?>">

                            <h4> <?php esc_html_e('Last name', 'kitas-landing-theme'); ?><span class="red">*</span></h4>
                            <input type="text" id="last-name-user" value="<?php echo $last_name ?>"
                                placeholder="<?php esc_html_e('Last name', 'kitas-landing-theme'); ?>">

                            <h4> <?php esc_html_e('Your working email', 'kitas-landing-theme'); ?><span class="red">*</span>
                            </h4>
                            <input type="email" id="email-user" value="<?php echo $company_email ?> "
                                placeholder="<?php esc_html_e('Your working email', 'kitas-landing-theme'); ?>">

                            <h4><?php esc_html_e('Your job position', 'kitas-landing-theme'); ?></h4>
                            <input type="text" id="job-title-user" value="<?php echo $title_job ?>"
                                placeholder="<?php esc_html_e('Your job position', 'kitas-landing-theme'); ?>">

                            <h4><?php esc_html_e('Phone number', 'kitas-landing-theme'); ?></h4>
                            <input type="number" id="phone-user" value="<?php echo $company_phone ?>"
                                placeholder="<?php esc_html_e('Phone number', 'kitas-landing-theme'); ?>">

                            <div class="send-cancel-form-user">
                                <span
                                    class="button-save-changes-user"><?php esc_html_e('Save changes', 'kitas-landing-theme'); ?></span>
                                <span class="button-cancel-user"><?php esc_html_e('Cancel', 'kitas-landing-theme'); ?></span>
                            </div>

                            <input type="submit" value="<?php esc_html_e('Submit', 'kitas-landing-theme'); ?>"
                                style="display: none;">

                        </form>
                    </div>
                    <div class="show-user-right">
                        <div class="user-info-title">
                            <span
                                class="user-info-title-span"><?php esc_html_e('This is how job seekers will see your personal information', 'kitas-landing-theme'); ?></span>
                            <span class="user-info-sub-title-span">
                                <?php esc_html_e('You can hide or change your personal information anytime', 'kitas-landing-theme'); ?></span>
                        </div>

                        <div class="user-info-view-resault">
                            <div class="user-block-info-profile-avatar">
                                <?php
                                if ($user_avatar == '') {
                                    echo ' <div class="user-avatar">
                            <span class="user-avatar-firstname"><?php echo $first_name[0]; ?></span>
                            <span class="user-avatar-lastname"><?php echo $last_name[0]; ?></span>
                        </div>';

                                } else {
                                    echo '<img src="' . $user_avatar . '" class="avatar-user-b" alt="">';
                                }
                                ?>

                            </div>
                            <div class="user-block-info-profile-fields">
                                <h4 class="user-show-name"><?php echo $first_name . " " . $last_name ?></h4>
                                <p class="hiring-show-p"><?php echo $title_job ?></p>
                                <div class="line-blue-block"></div>
                                <div class="user-block-info-profile-fields-plus">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/email.svg" alt="email">
                                    <p class="user-show-email"> <?php echo $company_email ?></p>
                                </div>
                                <div class="user-block-info-profile-fields-plus">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/phone.svg" alt="phone">
                                    <p class="user-show-phone"><?php echo $company_phone ?></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="main-show-user">
                    <div class="settings-user-block">
                        <div class="checkbox-block-main">
                            <input type="checkbox" id="hideContactInfo">
                            <label
                                for="hideContactInfo"><?php esc_html_e('Hide contact information', 'kitas-landing-theme'); ?></label>

                        </div>
                    </div>
                </div>

                <div class="main-show-user-half">
                    <div class="delete-account">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/trash.svg" alt="trash">
                        <span class="button-delete-account"> <?php esc_html_e('Delete account', 'kitas-landing-theme'); ?>
                        </span>
                    </div>
                </div>


            </div>
            <?php break;
        case 'my-job-offers':

            ?>



            <div class="my-job-offers">
                <div class="offers-container" style="display: none">
                    <?php
                    $current_date = date('Ymd');
                    $current_locale = isset($_GET['current_locale']) ? $_GET['current_locale'] : 'en';
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;


                    $args = array(
                        'post_type' => 'job-offer',
                        'posts_per_page' => -1,
                        'paged' => $paged,
                        'lang' => $current_locale,
                        'suppress_filters' => false,
                        'author' => get_current_user_id(),
                        'fields' => 'ids',
                    );

                    $query = new WP_Query($args);
                    $active_posts = [];
                    $closed_posts = [];

                    while ($query->have_posts()) {
                        $query->the_post();
                        $apply_by = get_field('apply_by');
                        $apply_by_date = DateTime::createFromFormat('F j, Y', $apply_by);
                        if ($apply_by_date) {
                            if ($apply_by_date->format('Ymd') >= $current_date) {
                                $active_posts[] = get_the_ID();
                            } else {
                                $closed_posts[] = get_the_ID();
                            }
                        }
                    }

                    wp_reset_postdata();

                    if (!empty($active_posts)) {

                        echo '<ul class="active-post">';
                        foreach ($active_posts as $post_id) {
                            echo '<li>' . $post_id . '</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo '<p>' . esc_html__("No active job offers found", 'kitas-landing-theme') . '</p>';
                    }

                    if (!empty($closed_posts)) {

                        echo '<ul class="hiden-post">';
                        foreach ($closed_posts as $post_id) {
                            echo '<li>' . $post_id . '</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo '<p>' . esc_html__("No closed job offers found", 'kitas-landing-theme') . '</p>';
                    }
                    ?>
                </div>

                <div class="offers-container" id="offers-container-on" style="display: none">
                    <div class="title-plus-link">
                        <h3 class="title-for-offers"> <span>0</span>
                            <?php esc_html_e('posted offers', 'kitas-landing-theme'); ?></h3>
                        <a href="/form-vacancy/"
                            class="post-new-job"><?php esc_html_e('Post a new job', 'kitas-landing-theme'); ?></a>
                    </div>

                    <div class="active-post-block"></div>
                    <div class="pagination-links"></div>

                    <h3 class="title-for-hidden-offers closed"> <span>0</span>
                        <?php esc_html_e('closed offers', 'kitas-landing-theme'); ?></h3>
                    <div class="hidden-post-block"></div>
                    <div class="pagination-links-hidden"></div>
                </div>

                <div class="lds-dual-ring" style="display: block"></div>

            </div>
            <?php break;

    endswitch;
    ?>
</main>

<div class="delete-account-popup-custom-yes-no-for-ajax-del">
    <div class="popup-account-for-user-yes-no">
        <span class="modal-close"></span>
        <h2>Delete account</h2>
        <div class="popup-account-for-user-yes-no-text">
            <h3><?php esc_html_e('Are you sure you wan to delete your account', 'kitas-landing-theme'); ?>?</h3>
            <p><?php esc_html_e('If you delete your account, you will permanently lose your profile, candidates and other data', 'kitas-landing-theme'); ?>
            </p>
            <div class="check-yes-for-delete-account">
                <input type="checkbox" id="yes" name="delete-account" value="yes">
                <span><?php esc_html_e('I understand that all my data will be removed permanently', 'kitas-landing-theme'); ?>.</span>
            </div>
            <div class="buttons-for-delete-ac-for-ajax">
                <span class="delete-account"
                    id="yes-ajax-delete-ac-for-user"><?php esc_html_e('Delete account', 'kitas-landing-theme'); ?></span>
                <span class="cancel-account"><?php esc_html_e('Cancel', 'kitas-landing-theme'); ?></span>
            </div>
        </div>
        <span
            class="by-proceeding"><?php esc_html_e('By proceeding, you agree to our Terms of use and our Privacy policy', 'kitas-landing-theme'); ?>.
        </span>

    </div>

    <div class="success-block-after-delete-account">
        <span class="modal-close"></span>
        <h2><?php esc_html_e('Account deleted', 'kitas-landing-theme'); ?></h2>
        <p><?php esc_html_e('Thank you! Your data has been removed', 'kitas-landing-theme'); ?>.</p>


        <span class="to-job-board"> <a href="<?php echo home_url(); ?>">
                <?php esc_html_e('To job board', 'kitas-landing-theme'); ?></a></span>
    </div>

</div>

<?php
get_footer();

add_filter('gettext', 'my_custom_gettext_translate', 20, 3);
function my_custom_gettext_translate($translated_text, $text, $domain)
{
    if ($text === 'Only .jpg or .png images ' && $domain === 'kitas-landing-theme') {
        return 'Nur .jpg oder .png Bilder';
    }
    return $translated_text;
}
