<?php
/**
 * Template part for displaying offers loop on jobs search page
 *
 *
 *
 * @package Kitas_Landing_Theme
 */

?>

<?php
//getting post from the main page template      
$offers = $data['query'];

$url = $_SERVER['REQUEST_URI'];
$lang = 'en';

if (str_contains($url, '/de')) {
    $lang = 'de';
}

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



if($offers->have_posts()){
    //output
    while ($offers->have_posts()) {
        $offers->the_post();

        $product_id = $offers->the_post_id;
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

        $author_id = get_post_field('post_author', $offers->the_post_id);
        $author_email = get_the_author_meta('email', $author_id);

        ?>
        <div class="job-card" data-postid="<?php echo get_the_ID(); ?>" id="<?php echo $apply_by_date_id; ?>">
            <div class="job-card-main">
                <div class="job-card-tags">
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
                        //         if ($type->slug != 'temporary' && $type->slug != 'immediate') {
                        //             echo '<p>' . $type->name . '</p>';
                        //         }
                        //     }
                        //     echo "</div>";
                        // }
                
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

                        if (get_field('temporary', get_the_ID())) {
                            echo "<div class='top-tag color-alice-blue'><p>Temporary</p></div>";

                        } else {
                            echo "";
                        }


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



                    } elseif ($apply_by_date_id === 'date_no_valid') {


                        echo '<div class="top-tag color-gray"><p>Job expired</p></div>';

                    }
                    ?>
                </div>
                <div class="job-card-info">
                    <div class="job-card-title">
                        <h1><a class="text-link" href="<?php echo get_the_permalink(); ?>">
                                <?php echo get_the_title(); ?> |
                                <?php
                                if (get_field('workload')) {
                                    echo get_field('workload') . ' - ' . get_field('max_workload') . '%';
                                }
                                ?>
                            </a></h1>
                    </div>

                    <div class="rating-salary">
                        <div class="rating">
                        </div>
                        <div class="salary">
                            <span class="value">CHF
                                <?php echo get_field('salary') ?>
                            </span>
                            <span class="period">
                                <?php
                                if (isset($lang)) {
                                    if ($lang == 'en') {
                                        echo 'gross/year';
                                    } else {
                                        echo 'brutto/Jahr';
                                    }
                                }
                                ?>
                            </span>
                        </div>
                    </div>

                    <div class="company-info">
                        <div class="company-name verified text-link">

                            <?php $author_id = get_post_field('post_author', get_the_ID());

                            // if (get_the_author_meta('verified', $author_id)) {
                            //     echo ' <img src="' . get_template_directory_uri() . '/img/verified.svg" alt="verified">';
                            // }
                        
                            echo '<a href="' . get_author_posts_url($author_id) . '">' . get_the_author_meta('display_name', $author_id) . '</a>';
                            ?>
                        </div>
                        <div class="company-address text-link">

                            <?php
                            echo ' <img src="' . get_template_directory_uri() . '/img/Vector.svg" alt="address" class="tag-icon">';
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

                    <div class="tags">
                        <div class="column-tags">
                            <?php
                            if (get_field('kids_age')) {
                                echo '<div class="tag-description">';
                                echo ' <img src="' . get_template_directory_uri() . '/img/kid.svg" alt="kid" class="tag-icon">';
                                echo 'Group: ' . get_field('kids_age') . '</div>';
                            }
                            ?>
                            <?php
                            if (get_field('languages')) {
                                echo '<div class="tag-description">';
                                echo ' <img src="' . get_template_directory_uri() . '/img/messages.svg" alt="messages" class="tag-icon">';
                                echo get_field('languages') . '</div>';
                            }
                            ?>
                        </div>

                        <div class="column-tags">
                            <?php
                            if (get_field('teaching_approach')) {
                                echo '<div class="tag-description">';
                                echo ' <img src="' . get_template_directory_uri() . '/img/toy.svg" alt="toy" class="tag-icon">';
                                echo get_field('teaching_approach') . '</div>';

                            }
                            ?>
                            <?php
                            if (get_field('vacation')) {
                                echo '<div class="tag-description">';
                                echo ' <img src="' . get_template_directory_uri() . '/img/vacation.svg" alt="vacation" class="tag-icon">';
                                echo get_field('vacation') . '</div>';
                            }
                            ?>
                        </div>

                        <div class="column-tags">
                            <?php
                            if (get_field('starts_on')) {
                                $startson_obj = get_field_object('starts_on');
                                $startson_date = format_date(get_field('starts_on'), $lang);
                                echo '<div class="tag-description">';
                                echo ' <img src="' . get_template_directory_uri() . '/img/Calendar.svg" alt="Calendar" class="tag-icon">';
                                echo $startson_obj['label'] . ': ' . $startson_date . '</div>';
                            }
                            ?>
                            <?php
                            if (get_field('apply_by')) {
                                $finish_obj = get_field_object('apply_by');
                                $apply_by_date = format_date(get_field('apply_by'), $lang);
                                echo '<div class="tag-description">';
                                echo ' <img src="' . get_template_directory_uri() . '/img/gmail.svg" alt="mail" class="tag-icon">';
                                echo $finish_obj['label'] . ': ' . $apply_by_date . '</div>';
                            }
                            ?>
                        </div>





                        <!-- <div class="column-tags">

                            <?php
                            if (get_field('kids_age')) {
                                echo '<div class="tag-description">';
                                echo ' <img src="' . get_template_directory_uri() . '/img/kid.svg" alt="kid">';
                                echo get_field('kids_age') . '</div>';
                            }
                            ?>
                            <?php
                            if (get_field('teaching_approach')) {
                                echo '<div class="tag-description">';
                                echo ' <img src="' . get_template_directory_uri() . '/img/toy.svg" alt="toy">';
                                echo get_field('teaching_approach') . '</div>';

                            } ?>
                            <?php
                            if (get_field('starts_on')) {
                                $startson_obj = get_field_object('starts_on');
                                echo '<div class="tag-description">';
                                echo ' <img src="' . get_template_directory_uri() . '/img/Calendar.svg" alt="Calendar">';
                                echo $startson_obj['label'] . ': ' . get_field('starts_on') . '</div>';
                            }
                            ?>
                        </div>
                        <div class="column-tags">
                            <?php
                            if (get_field('languages')) {
                                echo '<div class="tag-description">';
                                echo ' <img src="' . get_template_directory_uri() . '/img/messages.svg" alt="messages">';
                                echo get_field('languages') . '</div>';
                            }
                            ?>
                            <?php
                            if (get_field('vacation')) {
                                echo '<div class="tag-description">';
                                echo ' <img src="' . get_template_directory_uri() . '/img/vacation.svg" alt="vacation">';
                                echo get_field('vacation') . '</div>';
                            }
                            ?>
                            <?php
                            if (get_field('apply_deadline')) {
                                echo '<div class="tag-description">';
                                echo ' <img src="' . get_template_directory_uri() . '/img/gmail.svg" alt="mail">';
                                echo get_field('apply_deadline') . '</div>';
                            }
                            ?>
                        </div> -->
                    </div>

                    <div class="card-end">
                        <div class="cv-offer">
                            <?php if ($apply_by_date_id === 'date_valid') { ?>
                                <button class="button color-teal applicationToggle" id="" role="button"
                                    hide-email-post="<?php echo $author_email; ?>" data-authormail="<?php
                                    $author_id = get_post_field('post_author', get_the_ID());
                                    echo get_the_author_meta('user_email', get_the_ID()); ?>">
                                    <?php
                                    // echo the_field('send_cv_button_text', 'options');
                                    esc_html_e('Apply', 'kitas-landing-theme');
                                    ?>


                                </button>

                                <?php

                            } elseif ($apply_by_date_id === 'date_no_valid') { ?>

                                <button class="button color-gray-button" id="" role="button"
                                    hide-email-post="<?php echo $author_email; ?>" data-authormail="<?php
                                    $author_id = get_post_field('post_author', get_the_ID());
                                    echo get_the_author_meta('user_email', get_the_ID()); ?>">

                                    <?php
                                    esc_html_e('Expired offer', 'kitas-landing-theme');
                                    ?>
                                </button>

                                <?php

                            }

                            ?>



                        </div>
                        <?php
                        if ($apply_by_date_id === 'date_valid') {
                            if (is_user_logged_in()) {
                                ?>
                                <div class="save-job featuredToggle">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/bookmark.svg" alt="save-job"
                                        class="bookmark-icon">
                                </div>

                                <div class="dislike-job">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/dislike.svg" alt="dislike-job"
                                        class="dislike-icon">
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="no-login-but-ld like">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/bookmark.svg" alt="save-job"
                                        class="bookmark-icon">
                                </div>

                                <div class="no-login-but-ld dislike">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/dislike.svg" alt="dislike-job"
                                        class="dislike-icon">
                                </div>
                                <?php
                            }
                        }
                        ?>


                        <!-- Do not touch -->
                        <div id="get_post_id_offer" style="display: none">
                            <?php echo get_the_ID(); ?>
                        </div>




                    </div>

                    <!-- Block for rewiews for dislike -->
                    <div class="block-for-rewiews-dislike <?php echo get_the_ID(); ?>">
                        <div class="block-for-rewies-dislike-title">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/Check_ring_light.svg" alt="ring-light"
                                class="ring-light-icon">
                            <h4>You won’t see this job offer in your results. <span> Undo</span></h4>
                        </div>

                        <div class="block-for-rewies-dislike-subtitle">
                            <h3>What didn’t you like about this job?</h3>
                        </div>

                        <div class="form-send-block-for-rewies-dislike">
                            <form action="" method="post">
                                <textarea name="review" placeholder="Type here..." rows="2"></textarea>
                                <br>
                                <button type="submit">Submit</button>
                            </form>
                        </div>

                    </div>

                </div>
            </div>

            <div class="job-card-pic">
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
                <div class="card-pic">
                    <div class="your-class gallery-img">
                        <?php
                        $images = get_field('media_gallery');
                        if (is_array($images)) {
                            foreach ($images as $image) {
                                if (is_numeric($image)) {
                                    echo wp_get_attachment_image($image, 'full');
                                } else {
                                    echo '<img class="" src="' . esc_url($image) . '">';
                                }
                            }
                        } else {
                            echo get_the_post_thumbnail($product_id, 'full');
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>
        <?php
    }
}
?>