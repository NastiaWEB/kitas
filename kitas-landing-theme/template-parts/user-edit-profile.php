<?php

/**
 * Template name: User edit profile page
 */

get_header();

$user_id = get_current_user_id();

$first_name = get_user_meta($user_id, 'first_name', true);
$last_name = get_user_meta($user_id, 'last_name', true);
$email = get_userdata($user_id)->user_email;
$city = get_user_meta($user_id, 'address_profile', true);
$zip_code = get_user_meta($user_id, 'zip_code', true);
$phone = get_user_meta($user_id, 'phone_number', true);
$user_avatar = get_field('user_avatar', 'user_' . $user_id);
?>

<main id="primary" class="user-edit-profile">
    <div class="main-container">
        <div class="main-informations">
            <div class="left-block">
                <div class="edit-main-profile">
                    <a href="#" class="user-edit-details">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/EditVectoro.svg" alt="">
                    </a>

                    <div class="user-photo">
                        <?php
                        if ($user_avatar == '') {
                            echo '<div class="upload-logo-block">';
                            //echo '<h5>Upload logo</h5><span class="warning-info">Only .jpg or .png images<br> Max 4MB</span>';
                            echo '<img src="' . get_template_directory_uri() . "/img/camera.svg" . '" class="avatar-user-b" alt="">';
                            echo '</div>';

                        } else {

                            echo '<img src="' . $user_avatar . '" class="avatar-user-b" alt="">';
                        }
                        ?>

                        <img src="<?php echo get_template_directory_uri(); ?>/img/camera.svg" alt=""
                            class="camera-right-b">
                    </div>

                    <div class="user-info">
                        <div class="user-block-info">
                            <?php
                            if ($first_name == '' && $last_name == '') {
                                echo '<h4 class="user-name"> ' . esc_html__( "Add your name", 'kitas-landing-theme' ) . '</h4>';
                            } else {
                                echo '<h4 class="user-name">' . $first_name . ' ' . $last_name . '</h4>';
                            }
                            ?>
                        </div>
                        <div class="user-block-info">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/mail-w.svg" alt="email">
                            <p class="your-user-email"> <?php echo $email; ?> </p>
                        </div>
                        <div class="user-block-info"> <img src="<?php echo get_template_directory_uri(); ?>/img/pin.svg"
                                alt="pin">

                            <?php
                            if ($city != '') {
                                echo '<p class="your-user-location">' . $city . '</p>';
                            } else {
                                echo '<p class="your-user-location green">' . esc_html__( "Add your location", 'kitas-landing-theme' ) . '</p>';
                            }
                            ?>
                        </div>
                        <div class="user-block-info"> <img
                                src="<?php echo get_template_directory_uri(); ?>/img/phone-w.svg" alt="phone">

                            <?php
                            if ($phone != '') {
                                echo '<p class="your-user-phone">' . $phone . '</p>';
                            } else {
                                echo '<p class="your-user-phone green">' . esc_html__( "Add your phone number", 'kitas-landing-theme' ) . '</p>';
                            }
                            ?>
                        </div>
                    </div>


                </div>

                <div class="edit-main-profile-open">
                    <div class="user-photo">
                        <?php
                        if ($user_avatar == '') {
                            echo '<div class="upload-logo-block" id="upload-logo-user-avatar">';
                            echo '<h5>Upload logo</h5><span class="warning-info">' . esc_html__( "Only .jpg or .png images", 'kitas-landing-theme' ) . ' <br> ' . esc_html__( " Max 4MB", 'kitas-landing-theme' ) . ' </span>';
       
                            echo '</div>';
                            echo '<input type="file" id="edit-user-avatar" name="edit-user-avatar" style="display: none;">';

                        } else {
                            echo '<div class="upload-logo-block" id="upload-logo-user-avatar">';

                            echo '<img src="' . $user_avatar . '" class="avatar-user-b" alt="">';
                            echo '</div>';
                            echo '<input type="file" id="edit-user-avatar" name="edit-user-avatar" style="display: none;">';
                        }
                        ?>

                        <img src="<?php echo get_template_directory_uri(); ?>/img/camera.svg" alt=""
                            class="camera-right-b">
                    </div>

                    <form action="edit-prodile-user">
                        <div class="edit-field">
                            <label for="first-name"><?php esc_html_e( "First name", 'kitas-landing-theme' ); ?><span>*</span></label>
                            <input type="text" id="first-name" name="first-name" value="<?php echo $first_name; ?>"
                                placeholder="<?php esc_html_e( "First name", 'kitas-landing-theme' ); ?>">
                        </div>

                        <div class="edit-field">
                            <label for="last-name"><?php esc_html_e( "Last name", 'kitas-landing-theme' ); ?><span>*</span></label>
                            <input type="text" id="last-name" name="last-name" value="<?php echo $last_name; ?>"
                                placeholder="<?php esc_html_e( "Last name", 'kitas-landing-theme' ); ?>">
                        </div>
                        <div class="edit-field">
                            <label for="email"><?php esc_html_e( "Email", 'kitas-landing-theme' ); ?><span>*</span></label>
                            <input type="email" id="email" name="email" value="<?php echo $email; ?>"
                                placeholder="<?php esc_html_e( "Email", 'kitas-landing-theme' ); ?>">
                        </div>

                        <div class="edit-field">
                            <label for="city"><?php esc_html_e( "City", 'kitas-landing-theme' ); ?></label>
                            <input type="text" id="city" name="city" value="<?php echo $city; ?>" placeholder="<?php esc_html_e( "City", 'kitas-landing-theme' ); ?>">
                        </div>
                        <div class="edit-field">
                            <label for="zip-code"><?php esc_html_e( "Zip code", 'kitas-landing-theme' ); ?></label>
                            <input type="text" id="zip-code" name="zip-code" value="<?php echo $zip_code; ?>"
                                placeholder="<?php esc_html_e( "Zip code", 'kitas-landing-theme' ); ?>">
                        </div>

                        <div class="edit-field">
                            <label for="phone"><?php esc_html_e( "Phone number", 'kitas-landing-theme' ); ?></label>
                            <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>"
                                placeholder="<?php esc_html_e( "Phone number", 'kitas-landing-theme' ); ?>r">
                        </div>

                        <div class="submit-block-edit-profile">
                            <input type="submit" value="Save changes" id="save-changes-button" style="display: none;">
                            <a href="#" class="button-save-changes"><?php esc_html_e( "Save changes", 'kitas-landing-theme' ); ?></a>
                            <a href="#" class="button-cancel"><?php esc_html_e( "Cancel", 'kitas-landing-theme' ); ?></a>

                        </div>
                    </form>
                </div>

                <div class="job-alert">
                    <h3><?php esc_html_e( "Job alert", 'kitas-landing-theme' ); ?></h3>
                    <p><?php esc_html_e( "Want to receive updates/notifications/news", 'kitas-landing-theme' ); ?>?</p>
                    <div class="job-alert-info">

                        <form action="send-alert-info" id="job-alert-info-form">
                            <input type="text" id="job-title" placeholder="<?php esc_html_e( "Job title", 'kitas-landing-theme' ); ?>">
                            <input type="text" id="job-location" placeholder="<?php esc_html_e( "Job location", 'kitas-landing-theme' ); ?>">
                            <input type="email" id="job-email" placeholder="email@example.com">
                            <input type="submit" value="<?php esc_html_e( "Subscribe", 'kitas-landing-theme' ); ?>" id="send-alert-info-button">

                        </form>

                    </div>
                </div>
            </div>

            <div class="edit-job-preferences">
                <h2><?php esc_html_e( "Job preferences", 'kitas-landing-theme' ); ?></h2>
                <p><?php esc_html_e( "What kind of a job are you looking for", 'kitas-landing-theme' ); ?>?</p>
                <p><?php esc_html_e( "Update your job preferences to get the most relevant jobs for you", 'kitas-landing-theme' ); ?>.</p>

                <a href="#" class="block-open-for-edit-job-preferences">
                    <img src="/wp-content/themes/kitas-landing-theme/img/EditVectoro.svg" alt="">
                </a>

                <div class="edit-job-location">
                    <div class="edit-job-preferences-block">
                        <?php
                        for ($i = 1; $i <= 3; $i++) {
                            $job_title = '';
                            $job_category = '';

                            if (have_rows('job_title', 'user_' . $user_id)) {
                                the_row();
                                $job_title = get_sub_field('job_title');
                                $job_category = get_sub_field('job_category');
                                if (is_array($job_category)) {
                                    $job_category = $job_category[0];
                                }
                            }
                            ?>

                            <section class="stepBlockShowforJob">
                                <div class="edit-job-preferences-colums">
                                    <div class="edit-job-preferences-colum">
                                        <label class="label-hide">
                                           <?php esc_html_e( "Job title", 'kitas-landing-theme' ); ?>
                                        </label>
                                        <input type="text" class="job-title" name="job-title"
                                            value="<?php echo esc_attr($job_title); ?>" placeholder="<?php esc_html_e( "E.g., Co-educator", 'kitas-landing-theme' ); ?>">

                                    </div>

                                    <div class="edit-job-preferences-colum">
                                        <?php
                                        $terms = get_terms(
                                            array(
                                                'taxonomy' => 'job_category',
                                                'hide_empty' => false,
                                            )
                                        );

                                        if (!empty($terms) && !is_wp_error($terms)) {
                                            
                                            echo '<label class="label-hide"> ' . esc_html__( "Job category", 'kitas-landing-theme' ) . ' </label>';

                                            echo '<select name="job_category" class="job_category">';
                                            echo '<option value=""> ' .esc_html__( "Select a job category from a dropdown", 'kitas-landing-theme' ) . '</option>';

                                            foreach ($terms as $term) {
                                                $selected = ($term->term_id == $job_category) ? 'selected' : '';
                                                echo '<option value="' . esc_attr($term->term_id) . '" ' . $selected . '>' . esc_html($term->name) . '</option>';
                                            }

                                            echo '</select>';
                                        } else {
                                            echo '<p>No job categories found.</p>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="add-another-job-title delete">
                                    <span class="remove-button" style="display: none;"> ⨯  <?php esc_html_e( "Remove this job title", 'kitas-landing-theme' ); ?> </span>
                                </div>
                                <div class="add-another-job-title">
                                    <span class="add-button"> +  <?php esc_html_e( "Add another job title", 'kitas-landing-theme' ); ?> </span>
                                </div>
                            </section>

                            <?php
                        }
                        ?>


                    </div>

                    <div class="hr-gray"></div>

                    <div class="edit-location-preferences-block">
                        <?php
                        $locations = array();
                        if (have_rows('job_location', 'user_' . $user_id)) {
                            while (have_rows('job_location', 'user_' . $user_id)) {
                                the_row();
                                $job_location = get_sub_field('job_location');
                                $job_city = get_sub_field('job_city');
                                if (is_array($job_location)) {
                                    $job_location = $job_location[0];
                                }
                                $locations[] = array('location' => $job_location, 'city' => $job_city);
                            }
                        }

                        for ($i = 1; $i <= 5; $i++) {
                            $job_location = isset($locations[$i - 1]['location']) ? $locations[$i - 1]['location'] : '';
                            $job_city = isset($locations[$i - 1]['city']) ? $locations[$i - 1]['city'] : '';
                            ?>
                            <section class="stepBlockShowforLocation">
                                <div class="edit-job-preferences-colums mt-55">
                                    <div class="edit-job-preferences-colum">
                                        <label class="label-hide"><?php esc_html_e( "Job location", 'kitas-landing-theme' ); ?></label>
                                        <?php
                                        $terms = get_terms(
                                            array(
                                                'taxonomy' => 'location',
                                                'hide_empty' => false,
                                            )
                                        );

                                        if (!empty($terms) && !is_wp_error($terms)) {
                                            echo '<select name="location" class="location">';
                                            echo '<option value="">' . esc_html__( "Cantone", 'kitas-landing-theme' ) . '</option>';

                                            foreach ($terms as $term) {
                                                $selected = ($term->term_id == $job_location) ? 'selected' : '';
                                                echo '<option value="' . esc_attr($term->term_id) . '" ' . $selected . '>' . esc_html($term->name) . '</option>';
                                            }

                                            echo '</select>';
                                        } else {
                                            echo '<p>' . esc_html__( "No job categories found", 'kitas-landing-theme' ) . '.</p>';
                                        }
                                        ?>
                                    </div>
                                    <div class="edit-job-preferences-colum">
                                        <input type="text" class="job-cantone" name="job-cantone"
                                            value="<?php echo esc_attr($job_city); ?>" placeholder="<?php esc_html_e( "All cities", 'kitas-landing-theme' ); ?>">
                                    </div>
                                </div>

                                <div class="add-another-job-title delete">
                                    <span class="remove-another-location" style="display: none;"> ⨯  <?php esc_html_e( "Remove this location", 'kitas-landing-theme' ); ?>
                                    </span>
                                </div>

                                <div class="add-another-job-title">
                                    <span class="add-another-location"> + <?php esc_html_e( "Add another location", 'kitas-landing-theme' ); ?> </span>
                                </div>
                            </section>
                            <?php
                        }
                        ?>


                    </div>

                    <div class="submit-block-job-preferences">

                        <a href="#" class="button-save-block-job-preferences"><?php esc_html_e( "Save changes", 'kitas-landing-theme' ); ?></a>
                        <a href="#" class="button-cancel-block-job-preferences"><?php esc_html_e( "Cancel", 'kitas-landing-theme' ); ?></a>

                    </div>
                </div>

                <div class="show-job-location">

                    <div class="show-job-preferences-block">
                        <?php

                        $job_titles = [];
                        $job_categories = [];

                        for ($i = 0; $i <= 3; $i++) {
                            $job_title = '';
                            $job_category = '';

                            if (have_rows('job_title', 'user_' . $user_id)) {
                                the_row();
                                $job_title = get_sub_field('job_title');
                                $job_category = get_sub_field('job_category');
                                if (is_array($job_category)) {
                                    $job_category = $job_category[0];
                                }
                            }


                            $job_titles[] = $job_title;


                            if ($job_category) {
                                $job_category_term = get_term($job_category, 'job_category');
                                if (!is_wp_error($job_category_term)) {
                                    $job_categories[] = $job_category_term->name;
                                }
                            }
                        }
                        ?>

                        <div class="show-job-preferences-colums">
                            <div class="show-job-preferences-colum">
                                <label>
                                    <?php esc_html_e( "Job title", 'kitas-landing-theme' ); ?>
                                </label>
                                <?php

                                $filtered_job_titles = array_filter($job_titles, function ($value) {
                                    return !empty($value);
                                });

                                if (empty($filtered_job_titles)) {
                                    echo '<p class="p-show-job-preferences-colum">' . esc_html__( "Add your job title", 'kitas-landing-theme' ) . '.</p>';
                                } else {
                                    foreach ($filtered_job_titles as $title) {
                                        echo '<p class="p-show-job-preferences-colum">' . esc_html($title) . '</p>';
                                    }
                                }
                                ?>

                                <?php ?>

                            </div>

                            <div class="show-job-preferences-colum">
                                <label>
                                    <?php esc_html_e( "Job category", 'kitas-landing-theme' ); ?>
                                </label>
                                <?php foreach ($job_categories as $category): ?>
                                    <p class="p-show-job-preferences-colum"><?php echo esc_html($category); ?></p>
                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>

                    <div class="show-job-preferences-block">
                        <?php

                        $job_cities = [];
                        $job_locations = [];

                        if (have_rows('job_location', 'user_' . $user_id)) {
                            while (have_rows('job_location', 'user_' . $user_id)) {
                                the_row();
                                $job_city = get_sub_field('job_city');
                                $job_location = get_sub_field('job_location');
                                if (is_array($job_location)) {
                                    $job_location = $job_location[0];
                                }

                                $job_cities[] = $job_city;

                                if ($job_location) {
                                    $job_location_term = get_term($job_location, 'location');
                                    if (!is_wp_error($job_location_term)) {
                                        $job_locations[] = $job_location_term->name;
                                    } else {
                                        $job_locations[] = '';
                                    }
                                } else {
                                    $job_locations[] = '';
                                }
                            }
                        }


                        ?>

                        <div class="show-job-preferences-colums">
                            <div class="show-job-preferences-colum">
                                <label><?php esc_html_e( "Job location", 'kitas-landing-theme' ); ?></label>
                                <?php for ($i = 0; $i < count($job_locations); $i++): ?>
                                    <p class="p-show-job-preferences-colum">
                                        <?php
                                        echo esc_html($job_locations[$i]);
                                        echo ' ';
                                        echo esc_html($job_cities[$i]);
                                        ?>
                                    </p>
                                <?php endfor;
                                if (count($job_locations) == 0) {
                                    echo '<p class="p-show-job-preferences-colum">' . esc_html__( "Add your job location", 'kitas-landing-theme' ) . '.</p>';

                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="experience-doc">
                    <h2><?php esc_html_e( "Experience", 'kitas-landing-theme' ); ?></h2>
                    <a href="#" class="block-open-for-experience-block" style="display: block;">
                        <img src="/wp-content/themes/kitas-landing-theme/img/EditVectoro.svg" alt="">
                    </a>

                    <div class="show-experience-block">
                        <?php
                        $user_id = get_current_user_id();
                        if (!$user_id) {
                            return;
                        }

                        $files_found = false;

                        if (have_rows('file_experience', 'user_' . $user_id)) {
                            while (have_rows('file_experience', 'user_' . $user_id)) {
                                the_row();
                                $file = get_sub_field('experience');
                                if ($file) {
                                    $files_found = true;
                                    if (is_array($file)) {
                                        $file_url = $file['url'];
                                        $file_name = $file['filename'];
                                    } else {
                                        $file_url = $file;
                                        $file_name = basename($file);
                                    }
                                    echo '<div class="file-entry">';
                                    echo '<a href="' . esc_url($file_url) . '" target="_blank">' . esc_html($file_name) . '</a>';
                                    echo '</div>';
                                }
                            }
                        }

                        if (!$files_found) {
                            echo '<p class="p-show-job-preferences-colum">' . esc_html__( "No files found", 'kitas-landing-theme' ) . '.</p>';
                        }
                        ?>
                    </div>


                    <div class="show-block-experience">

                        <div class="show-documents-for-experience-block">
                            <?php
                            $user_id = get_current_user_id();
                            if (!$user_id) {
                                return;
                            }

                            if (have_rows('file_experience', 'user_' . $user_id)) {
                                while (have_rows('file_experience', 'user_' . $user_id)) {
                                    the_row();
                                    $file = get_sub_field('experience');
                                    if ($file) {
                                        if (is_array($file)) {
                                            $file_url = $file['url'];
                                            $file_name = $file['filename'];
                                        } else {
                                            $file_url = $file;
                                            $file_name = basename($file);
                                        }
                                        echo '<div class="file-name">';
                                        echo '<a href="' . esc_url($file_url) . '" target="_blank">' . esc_html($file_name) . '</a>';
                                        echo '<span class="delete-doc-for-experience"> </span>';
                                        echo '</div>';
                                    }
                                }
                            }
                            ?>
                        </div>
                        <div class="upload-doc" id="upload-doc-click-for-experience">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/camera-button.png" alt="">

                            <div class="block-text-upload">
                                <h4><?php esc_html_e( "Drag and drop a resume file to upload", 'kitas-landing-theme' ); ?></h4>
                                <p> <?php esc_html_e( "Your resume will be private. You can use it to submit your job", 'kitas-landing-theme' ); ?> <br>
                                 <?php esc_html_e( "applications via Easy Apply", 'kitas-landing-theme' ); ?>. </p>
                                <span class="warning-info">.pdf, .doc, .docx, .odt, .jpg, .jpeg, .png, .xls, .xlsx,
                                    .ods,
                                    .txt,
                                    .rtf <br>
                                    Max 4MB</span>
                            </div>

                            <input type="file" id="experience-file-upload" multiple="" style="display:none;">
                            <span class="select-file-for-experience-company"><?php esc_html_e( "Select files", 'kitas-landing-theme' ); ?></span>
                        </div>

                        <div class="block-for-save-experience">
                            <a href="#" class="button-save-block-experience"><?php esc_html_e( "Save changes", 'kitas-landing-theme' ); ?></a>
                            <a href="#" class="button-cancel-block-experience"><?php esc_html_e( "Cancel", 'kitas-landing-theme' ); ?></a>
                        </div>
                    </div>


                </div>

                <div class="additional-documents">
                    <h2><?php esc_html_e( "Additional documents", 'kitas-landing-theme' ); ?></h2>
                    <a href="#" class="block-open-for-additional-block" style="display: block;">
                        <img src="/wp-content/themes/kitas-landing-theme/img/EditVectoro.svg" alt="">
                    </a>

                    <div class="show-additional-documents-block">
                        <?php
                        $user_id = get_current_user_id();
                        if (!$user_id) {
                            return;
                        }

                        $files_found = false;

                        if (have_rows('file_additional', 'user_' . $user_id)) {
                            while (have_rows('file_additional', 'user_' . $user_id)) {
                                the_row();
                                $file = get_sub_field('additional');
                                if ($file) {
                                    $files_found = true;
                                    if (is_array($file)) {
                                        $file_url = $file['url'];
                                        $file_name = $file['filename'];
                                    } else {
                                        $file_url = $file;
                                        $file_name = basename($file);
                                    }
                                    echo '<div class="file-name">';
                                    echo '<a href="' . esc_url($file_url) . '" target="_blank">' . esc_html($file_name) . '</a>';
                                    echo '<span class="delete-doc-for-additional"> </span>';
                                    echo '</div>';
                                }
                            }
                        }

                        if (!$files_found) {
                            echo '<p class="p-show-job-preferences-colum">' . esc_html__( "No files found", 'kitas-landing-theme' ) . '.</p>';
                        }
                        ?>
                    </div>

                    <div class="show-block-additional">

                        <div class="show-documents-for-additional-block">
                            <?php
                            $user_id = get_current_user_id();
                            if (!$user_id) {
                                return;
                            }

                            if (have_rows('file_additional', 'user_' . $user_id)) {
                                while (have_rows('file_additional', 'user_' . $user_id)) {
                                    the_row();
                                    $file = get_sub_field('additional');
                                    if ($file) {
                                        if (is_array($file)) {
                                            $file_url = $file['url'];
                                            $file_name = $file['filename'];
                                        } else {
                                            $file_url = $file;
                                            $file_name = basename($file);
                                        }
                                        echo '<div class="file-name">';
                                        echo '<a href="' . esc_url($file_url) . '" target="_blank">' . esc_html($file_name) . '</a>';
                                        echo '<span class="delete-doc-for-additional" data-index="' . $key . '" data-type="existing"> </span>';
                                        echo '</div>';
                                    }
                                }
                            }
                            ?>
                        </div>
                        <div class="upload-doc" id="upload-doc-click-for-additional">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/camera-button.png" alt="">

                            <div class="block-text-upload">
                                <h4><?php esc_html_e( "Drag and drop your files to upload", 'kitas-landing-theme' ); ?></h4>
                                <p> <?php esc_html_e( "Your documents will be private. You can use them to submit", 'kitas-landing-theme' ); ?>
                                    <br> <?php esc_html_e( "your job applications via Easy Apply", 'kitas-landing-theme' ); ?>.</p>
                                <span class="warning-info">.pdf, .doc, .docx, .odt, .jpg, .jpeg, .png, .xls, .xlsx,
                                    .ods, .txt, .rtf <br> Max 4MB</span>
                            </div>

                            <input type="file" id="additional-file-upload" multiple="" style="display:none;">
                            <span class="select-file-for-additional-documents"><?php esc_html_e( "Select files", 'kitas-landing-theme' ); ?></span>
                        </div>

                        <div class="block-for-save-additional">
                            <a href="#" class="button-save-block-additional"><?php esc_html_e( "Save changes", 'kitas-landing-theme' ); ?></a>
                            <a href="#" class="button-cancel-block-additional"><?php esc_html_e( "Cancel", 'kitas-landing-theme' ); ?></a>
                        </div>
                    </div>
                </div>



                <div class="delete-account">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/trash.svg" alt="trash">
                    <span class="button-delete-account">  <?php esc_html_e( "Delete account", 'kitas-landing-theme' ); ?></span>
                </div>
            </div>


        </div>
    </div>
</main>

<div class="delete-account-popup-custom-yes-no-for-ajax-del">
    <div class="popup-account-for-user-yes-no">
    <span class="modal-close"></span>
        <h2><?php esc_html_e( "Delete account", 'kitas-landing-theme' ); ?></h2>
        <div class="popup-account-for-user-yes-no-text">
            <h3><?php esc_html_e( "Are you sure you wan to delete your account", 'kitas-landing-theme' ); ?>?</h3>
            <p> <?php esc_html_e( "If you delete your account, you will permanently lose your profile, candidates and other data", 'kitas-landing-theme' ); ?></p>
            <div class="check-yes-for-delete-account">
                <input type="checkbox" id="yes" name="delete-account" value="yes">
                <span><?php esc_html_e( "I understand that all my data will be removed permanently", 'kitas-landing-theme' ); ?>.</span>
            </div>
            <div class="buttons-for-delete-ac-for-ajax">
                <span class="delete-account" id="yes-ajax-delete-ac-for-user"><?php esc_html_e( "Delete account", 'kitas-landing-theme' ); ?></span>
                <span class="cancel-account"><?php esc_html_e( "Cancel", 'kitas-landing-theme' ); ?></span>
            </div>
        </div>
        <span class="by-proceeding"><?php esc_html_e( "By proceeding, you agree to our Terms of use and our Privacy policy", 'kitas-landing-theme' ); ?>.
        </span>

    </div>

    <div class="success-block-after-delete-account">
    <span class="modal-close"></span>
        <h2><?php esc_html_e( "Account deleted", 'kitas-landing-theme' ); ?></h2>
        <p><?php esc_html_e( "Thank you! Your data has been removed", 'kitas-landing-theme' ); ?>.</p>

        <span class="to-job-board"> <a href="<?php echo home_url(); ?>"> <?php esc_html_e( "To job board", 'kitas-landing-theme' ); ?></a></span>
    </div>

</div>

<?php
get_footer();

