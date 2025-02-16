<?php
/*

 */

get_header();

global $post;
$user_id = $post->post_author;

$first_name = get_user_meta($user_id, 'first_name', true);
$last_name = get_user_meta($user_id, 'last_name', true);
$user_avatar = get_field('user_avatar', 'user_' . $user_id);
$company_email = get_field('company_email', 'user_' . $user_id);
$title_job = get_field('title_job', 'user_' . $user_id);
$company_phone = get_field('phone_number', 'user_' . $user_id);

$author_url = get_author_posts_url($user_id);


function getJobCountByAuthor($id)
{
    $args = array(
        'author' => $id,
        'post_type' => 'job-offer',
        'posts_per_page' => -1,
        'fields' => 'ids'
    );

    $query = new WP_Query($args);
    $author_post_count = $query->post_count;

    return $author_post_count;
}

$jobCount = getJobCountByAuthor(get_post_field('post_author'));


$url = $_SERVER['REQUEST_URI'];
$lang = 'en';

if (str_contains($url, '/de')) {
    $lang = 'de';
}
$args = array(
    'post_type' => 'job-offer',
    'lang' => $lang
);

function convert_date_to_english($date_string)
{
    $months = array(
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

    return strtr($date_string, $months);
}

function convert_date_to_german($date_string)
{
    $months = array(
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

    return strtr($date_string, $months);
}

function format_date($date_string, $lang)
{
    if ($lang === 'de-DE') {
        $date_string = convert_date_to_german($date_string);
        $timestamp = strtotime($date_string);
        if ($timestamp === false) {
            return $date_string;
        }
        return date('d. F Y', $timestamp);
    } else {
        $date_string = convert_date_to_english($date_string);
        $timestamp = strtotime($date_string);
        if ($timestamp === false) {
            return $date_string;
        }
        return date('d F Y', $timestamp);
    }
}

$product_id = get_the_ID();

$apply_by_date = get_field('apply_by', $product_id);
//
$apply_by_date_english = convert_date_to_english($apply_by_date);
$timestamp2 = strtotime($apply_by_date_english);
$formatted_date = date('d.m.Y', $timestamp2);
//

$apply_by_timestamp = strtotime($formatted_date);


$current_timestamp = date('d.m.Y');

$current_timestamp_str = strtotime($current_timestamp);

$apply_by_date_id = '';
if ($apply_by_timestamp >= $current_timestamp_str) {
    $apply_by_date_id = 'date_valid';
} else {
    $apply_by_date_id = 'date_no_valid';
}

?>

<main id="primary" class="site-main">
    <div class="main-container">
        <div class="main-job-page">
            <div class="header-down">
                <div class="breadcrumbs-category breadcrumbs">
                    <?php
                    get_breadcrumb();
                    ?>
                </div>

                <div class="action-bar">
                    <?php if ($apply_by_date_id === 'date_valid') { ?>
                        <button class="button color-teal applicationToggle job-offer-button" id="" role="button"
                            data-authormail="<?php
                            $author_id = get_post_field('post_author', get_the_ID());
                            echo get_the_author_meta('user_email', $author_id); ?>">
                            <?php
                            esc_html_e('Apply', 'kitas-landing-theme');
                            ?>
                        </button>

                        <div class="reactions">
                            <div class="save-job featuredToggle">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/bookmark.svg" alt="save-job"
                                    class="bookmark-icon">
                            </div>
                            <div class="dislike-job ">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/dislike.svg" alt="dislike-job"
                                    class="dislike-icon">
                            </div>
                        </div>
                    <?php } elseif ($apply_by_date_id === 'date_no_valid') {

                        echo '<div class="top-tag "> <a href="#block-similar-jobs-down" class="link-button-scroll"> Search similar jobs </a> </div>';


                    } ?>
                </div>

            </div>

            <div class="job-details">
                <div class="job-card-main " data-postid="<?php echo get_the_ID(); ?>"
                    id="<?php echo $apply_by_date_id; ?>">
                    <div class="card-tags">
                        <div class="job-description-tags">

                            <?php
                            if ($apply_by_date_id === 'date_valid') {
                                $types = get_the_terms(get_the_ID(), 'employment-type');

                                $show_block = false;
                                if (is_array($types)) {
                                    foreach ($types as $type) {
                                        if ($type->slug != 'temporary' && $type->slug != 'immediate') {
                                            $show_block = true;
                                            break;
                                        }
                                    }
                                }

                                // if ($show_block) {
                                //     echo "<div class='top-tag color-seashell'>";
                                //     foreach ($types as $type) {
                                //         if ($type->slug != 'temporary' && $type->slug != 'immediate' && $type->slug != 'apprenticeship') {
                                //             echo '<p>' . $type->name . '</p>';
                                //         }
                                //     }
                                //     echo "</div>";
                                // }
                                if (has_term('internship', 'employment-type', get_the_ID())) {
                                    $internship_obj = get_term_by('slug', 'internship', 'employment-type');
                                    echo '
                                    <div class="top-tag color-seashell">
                                        <p>' . $internship_obj->name . '</p>
                                    </div>';
                                }

                                if (has_term('apprenticeship', 'employment-type', get_the_ID())) {
                                    $apprenticeship_obj = get_term_by('slug', 'apprenticeship', 'employment-type');
                                    echo '
                                    <div class="top-tag color-azure">
                                        <p>' . $apprenticeship_obj->name . '</p>
                                    </div>';
                                }


                                if (has_term('temporary', 'employment-type', get_the_ID())) {
                                    $temp_obj = get_term_by('slug', 'temporary', 'employment-type');
                                    echo '
                        <div class="top-tag color-alice-blue">
                            <p>' . $temp_obj->name . '</p>
                            </div>';
                                }
                                if (has_term('immediate', 'employment-type', get_the_ID())) {
                                    $imm_obj = get_term_by('slug', 'immediate', 'employment-type');

                                    echo '
                            <div class="top-tag color-blush">
                            <p>' . $imm_obj->name . '</p>
                        </div>';
                                }

                                if (get_field('immediate', get_the_ID())) {
                                    echo "<div class='top-tag color-blush'><p>Immediate</p></div>";

                                } else {
                                    echo "";
                                }

                            } elseif ($apply_by_date_id === 'date_no_valid') {


                                echo '<div class="top-tag color-gray"><p>Job expired</p></div>';

                            }
                            ?>
                        </div>
                    </div>
                    <div class="offer-details">
                        <div class="job-offer-title" style="margin-top: 39px">
                            <h2><a class="text-link" href="#">
                                    <?php
                                    echo the_title() . ' | ';
                                    if (get_field('workload', get_the_ID())) {
                                        echo get_field('workload', get_the_ID()) . ' - ' . get_field('max_workload', get_the_ID()) . '%';
                                    }
                                    ?>
                                </a></h2>
                        </div>


                        <div class="salary-info">
                            <span class="job-offer-value">CHF
                                <?php echo get_field('salary', get_the_ID()); ?>
                            </span>
                            <span class="job-offer-period">
                                <?php
                                if ($lang == 'en') {
                                    echo 'gross/year';
                                } else {
                                    echo 'brutto/Jahr';
                                }
                                ?>
                            </span>
                        </div>

                        <div class="apply-time-frame">
                            <div class="start-job"><img class="apply-time-frame-img"
                                    src="<?php echo get_template_directory_uri(); ?>/img/Calendar.svg" alt="calendar">
                                <p>
                                    <?php
                                    $starts_on = get_field('starts_on');
                                    $startson_date = format_date(get_field('starts_on'), $lang);
                                    echo '' . esc_html__("Start work", 'kitas-landing-theme') . ': ' . $startson_date; ?>
                                </p>
                            </div>

                            <div class="apply-job"><img class="apply-time-frame-img"
                                    src="<?php echo get_template_directory_uri(); ?>/img/mail.png" alt="timer">
                                <p>
                                    <?php
                                    $apply_by = get_field('apply_by');
                                    $apply_by_date = format_date(get_field('apply_by'), $lang);
                                    echo '' . esc_html__("Apply deadline", 'kitas-landing-theme') . ': ' . $apply_by_date; ?>
                                </p>
                            </div>

                        </div>
                    </div>

                    <div class="job-overview">
                        <h2 class="job-overview-title"><?php esc_html_e('Job summary', 'kitas-landing-theme'); ?></h2>

                        <div class="job-overview-table">
                            <table>
                                <tr class="table-row">
                                    <td class="overview-table-info-side">
                                        <?php

                                        $approach = get_field_object('teaching_approach');

                                        // echo $approach["label"];
                                        esc_html_e('Pedagogy', 'kitas-landing-theme');
                                        ?>
                                    </td>
                                    <td class="overview-table-detail-side">
                                        <?php
                                        if (get_field('teaching_approach')) {
                                            echo get_field('teaching_approach');

                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr class="table-row">
                                    <td class="overview-table-info-side">
                                        <?php
                                        $age = get_field_object('kids_age');

                                        //echo $age["label"];
                                        esc_html_e('Kids age in group', 'kitas-landing-theme');
                                        ?>
                                    </td>
                                    <td class="overview-table-detail-side dis-flex">
                                        <?php
                                        if (get_field('kids_age')) {
                                            echo get_field('kids_age');



                                        }
                                        if ($apply_by_date_id === 'date_no_valid') {
                                            echo '<span class="age-not-available">Job expired</span>';
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr class="table-row">
                                    <td class="overview-table-info-side">
                                        <?php $work_time = get_field_object('work_start_time');

                                        // echo $work_time["label"];
                                        esc_html_e('Working hours', 'kitas-landing-theme');
                                        ?>
                                    </td>
                                    <td class="overview-table-detail-side">
                                        <?php
                                        if (get_field('work_start_time')) {
                                            echo get_field('work_start_time') . ' - ' . get_field('work_end_time');
                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr class="table-row">
                                    <td class="overview-table-info-side">
                                        <?php
                                        $load = get_field_object('workload');

                                        //echo $load["label"];
                                        esc_html_e('Workload', 'kitas-landing-theme');
                                        ?>
                                    </td>
                                    <td class="overview-table-detail-side">
                                        <?php
                                        if (get_field('workload')) {
                                            echo get_field('workload') . '%';

                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr class="table-row">
                                    <td class="overview-table-info-side">
                                        <?php
                                        $vac = get_field_object('vacation');

                                        //echo $vac["label"];
                                        esc_html_e('Vacation', 'kitas-landing-theme');
                                        ?>
                                    </td>
                                    <td class="overview-table-detail-side">
                                        <?php
                                        if (get_field('vacation')) {
                                            echo get_field('vacation');

                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr class="table-row">
                                    <td class="overview-table-info-side">
                                        <?php
                                        $lang = get_field_object('languages');

                                        // echo $lang["label"];
                                        esc_html_e('Languages', 'kitas-landing-theme');
                                        ?>
                                    </td>
                                    <td class="overview-table-detail-side">
                                        <?php
                                        if (get_field('languages')) {
                                            echo get_field('languages');

                                        }
                                        ?>
                                    </td>
                                </tr>

                                <tr class="table-row">
                                    <td class="overview-table-info-side">
                                        <?php
                                        $benefits = get_field_object('other_benefits');

                                        //echo $benefits["label"];
                                        esc_html_e('Other benefits', 'kitas-landing-theme');
                                        ?>
                                    </td>
                                    <td class="overview-table-detail-side">
                                        <?php
                                        if (get_field('other_benefits')) {
                                            echo get_field('other_benefits');

                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="job-overview-details">
                            <h2 class="job-overview-title">
                                <?php esc_html_e('Job description', 'kitas-landing-theme'); ?>
                            </h2>
                            <div class="post-content-overview">
                                <h3>
                                    <?php
                                    $second_field = get_field_object('about_company');
                                    if (!empty($second_field["value"])) {

                                        // echo $second_field["label"];
                                        esc_html_e('About company', 'kitas-landing-theme');
                                    }
                                    ?>
                                </h3>
                                <p>
                                    <?php
                                    echo the_field('about_company');
                                    ?>
                                </p>
                            </div>
                            <div class="post-content-overview">
                                <h3>
                                    <?php
                                    $third_field = get_field_object('requirements');

                                    if (!empty($third_field["value"])) {

                                        //echo $third_field["label"];
                                        esc_html_e('Requirements', 'kitas-landing-theme');
                                    }
                                    ?>
                                </h3>
                                <ul class="general-list">
                                    <?php
                                    $list_content = array_filter(explode("\n", $third_field["value"]));
                                    foreach ($list_content as $list_item) {
                                        echo '<li>' . $list_item . '</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="post-content-overview">
                                <h3>
                                    <?php
                                    $fourth_field = get_field_object('nice_to_have');
                                    if (!empty($fourth_field["value"])) {

                                        //echo $fourth_field["label"];
                                        esc_html_e('Nice to have', 'kitas-landing-theme');
                                    }
                                    ?>
                                </h3>
                                <ul class="general-list">
                                    <?php
                                    $list_content = array_filter(explode("\n", $fourth_field["value"]));
                                    foreach ($list_content as $list_item) {
                                        echo '<li>' . $list_item . '</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="post-content-overview">
                                <h3>
                                    <?php
                                    $fifth_field = get_field_object('responsibilities');
                                    if (!empty($fifth_field["value"])) {

                                        //echo $fifth_field["label"];
                                        esc_html_e('Responsibilities', 'kitas-landing-theme');
                                    }
                                    ?>
                                </h3>
                                <p>
                                    <?php
                                    echo the_field('responsibilities');
                                    ?>
                                </p>
                            </div>
                            <div class="post-content-overview">
                                <h3>
                                    <?php
                                    $sixth_field = get_field_object('benefits');
                                    if (!empty($sixth_field["value"])) {

                                        //echo $sixth_field["label"];
                                        esc_html_e('Benefits', 'kitas-landing-theme');
                                    }
                                    ?>
                                </h3>
                                <ul class="general-list">
                                    <?php
                                    $list_content = array_filter(explode("\n", $sixth_field["value"]));
                                    foreach ($list_content as $list_item) {
                                        echo '<li>' . $list_item . '</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="post-content-overview">
                                <h3>
                                    <?php
                                    $seventh_field = get_field_object('applying_process');



                                    if (!empty($seventh_field["value"])) {

                                        //echo $seventh_field["label"];
                                        esc_html_e('Applying process', 'kitas-landing-theme');
                                    }
                                    ?>
                                </h3>
                                <p>
                                    <?php
                                    echo the_field('applying_process');
                                    ?>
                                </p>
                            </div>

                            <?php if ($apply_by_date_id === 'date_valid') { ?>
                                <div class="post-content-overview">
                                    <h3>
                                        <?php
                                        $eighth_field = get_field_object('other_details');

                                        if (!empty($eighth_field["value"])) {

                                            // echo $eighth_field["label"];
                                            esc_html_e('Other details', 'kitas-landing-theme');
                                        }


                                        ?>
                                    </h3>
                                    <p>
                                        <?php
                                        echo the_field('other_details');
                                        ?>
                                    </p>

                                </div>

                                <div class="post-content-overview">
                                    <div class="report-bar">
                                        <button class="button color-teal applicationToggle job-offer-button" id=""
                                            role="button" data-authormail="<?php
                                            $author_id = get_post_field('post_author', get_the_ID());
                                            echo get_the_author_meta('user_email', $author_id); ?>">
                                            <?php
                                            esc_html_e('Apply', 'kitas-landing-theme');
                                            ?>
                                        </button>

                                        <div class="reactions">
                                            <div class="save-job featuredToggle">
                                                <img src="<?php echo get_template_directory_uri(); ?>/img/bookmark.svg"
                                                    alt="save-job" class="bookmark-icon">
                                            </div>
                                            <div class="dislike-job ">
                                                <img src="<?php echo get_template_directory_uri(); ?>/img/dislike.svg"
                                                    alt="dislike-job" class="dislike-icon">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } elseif ($apply_by_date_id === 'date_no_valid') {

                                echo '<div class="block-job-not-available"> <h3 class="job-not-available">This offer is not available right now, but you can look at other similar vacancies.</h3> </div> ';

                            } ?>

                            <div class="post-content-overview">
                                <div class="report-message">
                                    <p class="report-text">
                                        <?php esc_html_e('Have you noticed a description discrepancy or mismatch', 'kitas-landing-theme'); ?>?
                                    </p>
                                    <div class="report-block">
                                        <img src="<?php echo get_template_directory_uri(); ?>/img/report.png"
                                            alt="report">
                                        <p class="report-text"><?php esc_html_e('Report', 'kitas-landing-theme'); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="job-card-pic job-page-layout-pic">
                    <div class="pic-info">
                        <div class="views-number">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/eye-open.svg" alt="eye">
                            <p class="pic-info-text">
                                <?php
                                $views = get_post_meta(get_the_ID(), 'post_views_count', true);
                                echo $views . ' views';
                                ?>
                            </p>
                        </div>
                        <div class="views-number">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/clock.svg" alt="eye">
                            <p class="pic-info-text">
                                <?php
                                echo human_time_diff(get_post_time('U', false, get_the_ID()), current_time('timestamp'));
                                ?>
                                ago
                            </p>
                        </div>
                    </div>
                    <div class="company-details-wrapper">
                        <div class="card-pic">
                            <div class="your-class gallery-img">
                                <?php
                                $images = get_field('media_gallery', get_the_ID());

                                if (empty($images)) {
                                    echo get_the_post_thumbnail($product_id, 'full');
                                } else {


                                    foreach ($images as $image) {
                                        //echo '<img class="" src="'.$image.'">';
                                        if (is_numeric($image)) {
                                            echo wp_get_attachment_image($image, 'full');
                                        } else {
                                            echo '<img class="" src="' . esc_url($image) . '">';
                                        }
                                    }
                                }


                                ?>
                            </div>
                        </div>


                        <div class="company-details">
                            <div class="company-name verified text-link company-details-name">
                                <?php
                                $author_id = get_post_field('post_author');

                                if (get_the_author_meta('verified', $author_id)) {
                                    echo ' <img src="' . get_template_directory_uri() . '/img/verified.svg" alt="verified">';
                                }

                                echo get_the_author_meta('display_name', $author_id);
                                ?>
                            </div>

                            <div class="company-address text-link company-details-address">
                                <?php
                                // echo ' <img src="' . get_template_directory_uri() . '/img/address.svg" alt="address">';
                                $adress_for_link = get_field('address');
                                $parts_adress_for_link = explode(' - ', $adress_for_link);
                                $address_before_dash = $parts_adress_for_link[0];

                                ?>

                                <a href="https://maps.google.com/?q=<?php echo $address_before_dash; ?>"
                                    target="_blank">
                                    <?php echo get_field('address'); ?>
                                </a>
                          
                            </div>
                        </div>

                        <?php if ($apply_by_date_id === 'date_valid') { ?>
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

                                    <?php
                                    $checkFieldsTrueFalseForShowInfo = get_field('check-fields-true-false-for-show-info', 'user_' . $user_id);
                                    if (!$checkFieldsTrueFalseForShowInfo) { ?>

                                        <div class="line-blue-block"></div>
                                        <div class="user-block-info-profile-fields-plus">
                                            <img src="<?php echo get_template_directory_uri(); ?>/img/email.svg" alt="email">
                                            <p class="user-show-email"> <?php echo $company_email ?></p>
                                        </div>
                                        <div class="user-block-info-profile-fields-plus">
                                            <img src="<?php echo get_template_directory_uri(); ?>/img/phone.svg" alt="phone">
                                            <p class="user-show-phone"><?php echo $company_phone ?></p>
                                        </div>

                                        <?php
                                    }
                                    ?>


                                </div>
                            </div>
                        <?php } ?>
                        <div class="see-other-jobs">

                            <a href="<?php echo esc_url($author_url); ?>">
                                <h3 class="see-other-jobs-title"><?php esc_html_e('See', 'kitas-landing-theme'); ?>
                                    <?php echo $jobCount; ?> <?php esc_html_e('other jobs', 'kitas-landing-theme'); ?>
                                    ->
                                </h3>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <?php
            if ($apply_by_date_id === 'date_no_valid') { ?>

                <div class="block-similar-post" id="block-similar-jobs-down">
                    <h2 class="job-overview-title">Similar jobs</h2>

                    <?php

                    $args = array(
                        'post_type' => 'job-offer',
                        'posts_per_page' => 2,
                        'post__not_in' => array(get_the_ID())
                    );

                    $query = new WP_Query($args);


                    // Setting query var so we can pass offers list into template part
                    $data = array(
                        'query' => $query,
                    );
                    set_query_var('data', $data);

                    // Capture the output of the template part
                    ob_start();

                    get_template_part('template-parts/offers-loop', null, $data);



                    ?>

                </div>

            <?php }
            ?>
        </div>
        <?php
        setThemeimPostViews(get_the_ID());
        ?>
    </div>

</main><!-- #main -->
<?php
get_footer();
?>
<div class="modal" id="applicationModal">
    <div class="modal-content" id="applicationForm">
        <div class="modal-header">
            <h2>
                <?php echo get_field('application_form_title', 'options'); ?>
            </h2>
            <span class="close">&times;</span>
        </div>
        <?php
        if (is_user_logged_in()) {
            echo do_shortcode('[contact-form-7 id="eb8bf77" title="Application" form destination-email=""]');
        } else {
            echo do_shortcode('[login-with-ajax registration="1"]');
        }
        ?>
    </div>
</div>