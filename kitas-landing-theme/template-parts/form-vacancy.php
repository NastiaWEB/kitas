<?php
/**
 * Template name: Form Vacancy
 */
get_header();

$job_categories = get_terms(
    array(
        'taxonomy' => 'job_category',
        'hide_empty' => false,
    )
);

$locations = get_terms(
    array(
        'taxonomy' => 'location',
        'hide_empty' => false,
    )
);

$employments = get_terms(
    array(
        'taxonomy' => 'employment-type',
        'hide_empty' => false,
    )
);

$teachingApproach = get_terms(
    array(
        'taxonomy' => 'teaching-approach',
        'hide_empty' => false,
    )
);

$language = get_terms(
    array(
        'taxonomy' => 'offer_language',
        'hide_empty' => false,
    )
);

$user_id = get_current_user_id();
$location_company = get_field('location', 'user_' . $user_id);
$address_profile_company = get_field('address_profile', 'user_' . $user_id);
$address_street_company = get_field('address_street', 'user_' . $user_id);
$building_company = get_field('building', 'user_' . $user_id);
$zip_code_company = get_field('zip_code', 'user_' . $user_id);

echo '<span class="hide-element-for-form" id="location_company_check">' . $location_company . '</span>';
echo '<span class="hide-element-for-form" id="address_profile_company_check">' . $address_profile_company . '</span>';
echo '<span class="hide-element-for-form" id="address_street_company_check">' . $address_street_company . '</span>';
echo '<span class="hide-element-for-form" id="building_company_check">' . $building_company . '</span>';
echo '<span class="hide-element-for-form" id="zip_code_company_check">' . $zip_code_company . '</span>';

?>

<main id="primary" class="site-main">
    <div class="main-container">

        <?php
        $current_user_id = get_current_user_id();
        $company_name = get_field('company_name', 'user_' . $current_user_id);

        if ($company_name) {
            ?>
            <div class="main-content">
                <div id="multistep-form">
                    <div class="full-steps">
                        <div class="step">1</div>
                        <div class="step">2</div>
                        <div class="step">3</div>
                        <div class="step">4</div>
                        <!-- <div class="step">5</div> -->
                    </div>

                    <form id="submit_custom_form" action="" method="post" enctype="multipart/form-data">
                        <div id="step-1">
                            <h2> <?php esc_html_e( 'Job Basics', 'kitas-landing-theme' ); ?></h2>
                           
                            <div class="full-fields">
                                <h4><?php esc_html_e( 'Job title', 'kitas-landing-theme' ); ?> <span class="red-required"> * </span></h4>
                                <input type="text" id="job-title" name="job-title" maxlength="100">
                                <div id="char-count"><span>0/100</span> <?php esc_html_e( 'symbols used', 'kitas-landing-theme' ); ?></div>
                            </div>
                            <div class="full-fields">
                                <h4> <?php esc_html_e( 'Job Category', 'kitas-landing-theme' ); ?> <span class="red-required"> * </span></h4>
                                <?php if (!empty($job_categories)) {
                                    ?>
                                    <select id="job-category" name="job-category">
                                        <option value=""> <?php esc_html_e( 'Choose a category', 'kitas-landing-theme' ); ?>  </option>
                                        <?php foreach ($job_categories as $category): ?>
                                            <option value="<?php echo $category->term_id; ?>">
                                                <?php echo $category->name; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php
                                }
                                ?>
                            </div>
                            <h4><?php esc_html_e( 'Job location', 'kitas-landing-theme' ); ?> <span class="red-required"> * </span></h4>
                            <div class="half-fields">
                                <div class="flex-item">
                                    <?php if (!empty($locations)): ?>
                                        <select id="job-location" name="job-location">
                                            <option value=""> <?php esc_html_e( 'Select job location', 'kitas-landing-theme' ); ?></option>
                                            <?php foreach ($locations as $location): ?>
                                                <option value="<?php echo $location->term_id; ?>">
                                                    <?php echo $location->name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-item">
                                    <input type="text" id="job-city" name="job-city" placeholder=" ">
                                    <label for="job-city" class="label-for-job-city"><?php esc_html_e( 'City', 'kitas-landing-theme' ); ?></label>
                                </div>
                                <div class="flex-item-3">
                                    <div class="flex-item">
                                        <input type="text" id="job-street" name="job-street" placeholder=" ">
                                        <label for="job-street" class="label-for-job-street"><?php esc_html_e( 'Street', 'kitas-landing-theme' ); ?></label>
                                    </div>
                                    <div class="flex-item">
                                        <input type="text" id="job-building" name="job-building" placeholder=" ">
                                        <label for="job-building" class="label-for-job-building"><?php esc_html_e( 'Building', 'kitas-landing-theme' ); ?></label>
                                    </div>
                                    <div class="flex-item">
                                        <input type="text" id="job-zip-code" name="job-zip-code" placeholder=" ">
                                        <label for="job-zip-code" class="label-for-job-zip-code"><?php esc_html_e( 'ZIP code', 'kitas-landing-theme' ); ?></label>
                                    </div>
                                </div>

                                <div class="same-as-company-location">
                                    <input type="checkbox" id="job-same-as-company" name="job-same-as-company">
                                    <label for="job-same-as-company"><?php esc_html_e( 'The same as the company location', 'kitas-landing-theme' ); ?></label>
                                </div>
                            </div>

                            <div class="full-fields">
                                <h4 id="mt-32"> <?php esc_html_e( 'Start work date', 'kitas-landing-theme' ); ?><span class="red-required"> * </span></h4>
                                <h5> <?php esc_html_e( 'When you expect a candidate to begin work on this position', 'kitas-landing-theme' ); ?></h5>
                                <div class="calender-block-info">
                                    <input type="text" id="selected-date-starts-on" readonly style="display: none;">
                                    <a href="#" class="calendar-button-starts-on" id="calendar-button-starts-on">
                                        <i class="far fa-calendar-alt"></i> <?php esc_html_e( 'Starts on', 'kitas-landing-theme' ); ?>
                                    </a>
                                </div>

                            </div>

                            <div class="full-fields">
                                <h4 id="mt-32">  <?php esc_html_e( 'Apply deadline', 'kitas-landing-theme' ); ?><span class="red-required"> * </span></h4>
                                <h5> <?php esc_html_e( 'Last day when job seekers can apply for this position', 'kitas-landing-theme' ); ?> .</h5>
                                <div class="calender-block">
                                    <input type="text" id="selected-date" readonly style="display: none;">
                                    <a href="#" class="calendar-button" id="calendar-button">
                                        <i class="far fa-calendar-alt"></i> <?php esc_html_e( 'Set a date', 'kitas-landing-theme' ); ?>
                                    </a>
                                </div>
                            </div>

                            <div class="full-fields">
                                <h2 id="mt-32"><?php esc_html_e( 'Additional job specs', 'kitas-landing-theme' ); ?></h2>
                                <div class="check-immediate-offer">
                                    <input type="checkbox" id="immediate-offer" name="immediate-offer">
                                    <label for="immediate-offer"><?php esc_html_e( 'Immediate offer', 'kitas-landing-theme' ); ?></label>
                                </div>

                                <div class="check-temporary-positio">
                                    <input type="checkbox" id="temporary-positio" name="temporary-positio">
                                    <label for="temporary-positio"><?php esc_html_e( 'Temporary position', 'kitas-landing-theme' ); ?></label>
                                </div>


                            </div>

                        </div>

                        <div id="step-2" style="display: none;">
                            <h2><?php esc_html_e( 'Job conditions', 'kitas-landing-theme' ); ?></h2>
                            <div class="full-fields">
                                <h4><?php esc_html_e( 'Contract type', 'kitas-landing-theme' ); ?> <span class="red-required"> * </span></h4>
                                <?php if (!empty($employments)): ?>
                                    <div id="employment-buttons">
                                        <?php foreach ($employments as $employment): ?>
                                            <button class="employment-button" data-value="<?php echo $employment->term_id; ?>">
                                                <span class="button-content">
                                                    <i class="button-icon far fa-plus"></i>
                                                    <?php echo $employment->name; ?>
                                                </span>
                                            </button>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                            </div>
                            <div class="full-fields">
                                <h4> <?php esc_html_e( 'Workload', 'kitas-landing-theme' ); ?><span class="red-required"> * </span></h4>


                                <div class="range-slide">
                                    <div class="slide">
                                        <div class="line" id="line" style="left: 0%; right: 0%;"></div>
                                        <span class="thumb" id="thumbMin" style="left: 0%;"></span>
                                        <span class="thumb" id="thumbMax" style="left: 100%;"></span>
                                    </div>
                                    <input id="rangeMin" type="range" max="100" min="10" step="10" value="0">
                                    <input id="rangeMax" type="range" max="100" min="10" step="10" value="100">
                                </div>
                                <div class="mixer-block">
                                    <input type="number" id="minInput" value="" name="minInput" placeholder="Min %">
                                    <input type="number" id="maxInput" value="" name="maxInput" placeholder="Max %">
                                </div>

                                <h4><?php esc_html_e( 'Working hours', 'kitas-landing-theme' ); ?><span class="red-required"> * </span></h4>
                                <div class="kids-select-time">
                                    <div class="kids-select-time-block left">
                                        <p id="text-for-from-to"><?php esc_html_e( 'From', 'kitas-landing-theme' ); ?></p>
                                        <input type="time" id="time-start-wh" name="time-start-wh" required
                                            placeholder="07:00" />

                                    </div>
                                    <div class="kids-select-time-block right">
                                        <p id="text-for-from-to"><?php esc_html_e( 'Till', 'kitas-landing-theme' ); ?></p>
                                        <input type="time" id="time-finish-wh" name="time-finish-wh" required
                                            placeholder="18:30" />

                                    </div>
                                </div>

                                <div class="title-plus-select">
                                    <h4><?php esc_html_e( 'Salary', 'kitas-landing-theme' ); ?><span class="red-required"> * </span></h4>
                                    <div class="rage-exactAmount">
                                        <label class="text-rage-exactAmount">
                                            <input type="radio" name="amount_type" value="range" class="radio-button"
                                                checked> <?php esc_html_e( 'Range', 'kitas-landing-theme' ); ?>
                                        </label>&nbsp; / &nbsp;
                                        <label class="text-rage-exactAmount">
                                            <input type="radio" name="amount_type" value="exact" class="radio-button"> <?php esc_html_e( 'Exact amount', 'kitas-landing-theme' ); ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="salary-block-from-to">

                                    <div class="salary-block-info">
                                        <p id="text-for-from-to" class="hide-from-for-p"><?php esc_html_e( 'From', 'kitas-landing-theme' ); ?></p>
                                        <div class="block-for-text-for-from-to from">
                                            <input type="number" id="salary-from" name="salary-from" placeholder=" "
                                                required />
                                            <label for="salary-from" class="label-for-salary-from"><?php esc_html_e( 'CHF gross/year', 'kitas-landing-theme' ); ?></label>
                                        </div>

                                    </div>
                                    <div class="salary-block-info" id="salary-block-none">
                                        <p id="text-for-from-to"><?php esc_html_e( 'To', 'kitas-landing-theme' ); ?></p>
                                        <div class="block-for-text-for-from-to to">
                                            <input type="number" id="salary-to" name="salary-to" placeholder=" " required />
                                            <label for="salary-to" class="label-for-salary-to"><?php esc_html_e( 'CHF gross/year', 'kitas-landing-theme' ); ?></label>
                                        </div>
                                    </div>

                                </div>

                                <div class="title-plus-select">
                                    <h4><?php esc_html_e( 'Vacation', 'kitas-landing-theme' ); ?><span class="red-required"> * </span></h4>
                                    <div class="rage-exactDate">
                                        <label class="text-rage-exactDate">
                                            <input type="radio" name="date_type" value="days" class="radio-button" checked>
                                            <?php esc_html_e( 'Days', 'kitas-landing-theme' ); ?>
                                        </label>&nbsp; / &nbsp;
                                        <label class="text-rage-exactDate">
                                            <input type="radio" name="date_type" value="weeks" class="radio-button"> 
                                            <?php esc_html_e( 'Weeks amount', 'kitas-landing-theme' ); ?>
                                        </label>
                                    </div>
                                </div>

                                <div class="vacation-day-weeks-main-block">
                                    <div class="block-for-day-weeks">
                                        <input type="number" name="count-d-w-vacation" id="count-d-w-vacation"
                                            placeholder=" ">
                                        <label for="count-d-w-vacation" class="label-for-count-d-w-vacation"><?php esc_html_e( 'Days', 'kitas-landing-theme' ); ?></label>
                                        <!-- <span>Days</span> -->
                                        <span></span>

                                    </div>
                                    <div class="block-for-comments">
                                        <input type="text" id="input-vacation-distributed" placeholder=" " maxlength="100">
                                        <label for="input-vacation-distributed"
                                            class="label-for-input-vacation-distributed">
                                             <?php esc_html_e( 'Comment: how is vacation distributed over a year', 'kitas-landing-theme' ); ?>?</label>
                                        <span class="count-symbol-for-block-for-comments">0/100 <?php esc_html_e( 'symbols used', 'kitas-landing-theme' ); ?></span>
                                    </div>


                                </div>

                                <div class="other-benefist">
                                    <h4><?php esc_html_e( 'Other benefits', 'kitas-landing-theme' ); ?></h4>

                                    <textarea name="other-benefist-text-area" id="other-benefist-text-area" rows="10"
                                        placeholder=" "></textarea>
                                    <label for="other-benefist-text-area"
                                        class="label-for-other-benefist-text-area">
                                        <?php esc_html_e( 'Describe other benefits of working on this position for this company. E.g., advanced educational training, insurance, or other sorts of support.', 'kitas-landing-theme' ); ?>
                                        </label>
                                </div>
                            </div>
                        </div>

                        <div id="step-3" style="display: none;">
                            <h2><?php esc_html_e( 'Job details', 'kitas-landing-theme' ); ?></h2>
                            <h4><?php esc_html_e( 'Teaching approach', 'kitas-landing-theme' ); ?><span class="red-required"> * </span></h4>
                            <p class="span-info-message"> <?php esc_html_e( 'A pedagogy method/a concept you work with in a Kita', 'kitas-landing-theme' ); ?>.<span
                                    class="check-teaching-approach-error"> <?php esc_html_e( 'You can choose a few options', 'kitas-landing-theme' ); ?>. </span></p>



                            <div class="approach-options check-teaching-approach">

                                <?php
                                if (!empty($teachingApproach)) {
                                    foreach ($teachingApproach as $term) {
                                        ?>
                                        <div class="input-select">
                                            <input type="checkbox" id="checkbox_<?php echo esc_attr($term->term_id); ?>"
                                                name="approaches[]" class="employment-checkbox mixed-approach"
                                                value="<?php echo esc_attr($term->slug); ?>">
                                            <label for="checkbox_<?php echo esc_attr($term->term_id); ?>">
                                                <?php echo esc_html($term->name); ?>
                                            </label><br>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>

                                <div class="approach-options-optional">

                                    <input type="text" id="input-approach" placeholder=" " maxlength="100">
                                    <label for="input-approach" class="label-for-input-approach"> <?php esc_html_e( 'E.g., Montessori should be present in pedagogical work and consciously implemented', 'kitas-landing-theme' ); ?></label>
                                    <span class="symbol-user" id="input-approach-check">0/100 <?php esc_html_e( 'symbols used', 'kitas-landing-theme' ); ?></span>

                                </div>
                            </div>

                            <h4><?php esc_html_e( 'Group and kids', 'kitas-landing-theme' ); ?><span class="red-required"> * </span></h4>
                            <p class="span-info-message"><?php esc_html_e( 'A children age in a group a worker is expected to work with on this position', 'kitas-landing-theme' ); ?>.</p>
                            <div id="employment-buttons">
                                <button class="employment-button-group" data-value="single-peers">
                                    <span class="button-content">
                                        <i class="button-icon far fa-plus"></i>
                                        <?php esc_html_e( 'Peers', 'kitas-landing-theme' ); ?>
                                    </span>
                                </button>
                                <button class="employment-button-group" data-value="mixed-ages">
                                    <span class="button-content">
                                        <i class="button-icon far fa-plus"></i>
                                        <?php esc_html_e( 'Mixed ages', 'kitas-landing-theme' ); ?>
                                    </span>
                                </button>
                            </div>
                            <div class="kids-select-age">
                                <div class="kids-block-from-to">
                                    <div class="kids-select-age-block">
                                        <p id="text-for-from-to"><?php esc_html_e( 'From', 'kitas-landing-theme' ); ?></p>
                                        <div class="text-for-kids-select-age-block-from-to">
                                            <input type="number" id="months-old" name="months-old" placeholder=" "
                                                required="">
                                            <label for="months-old" class="label-for-months-old"><?php esc_html_e( 'years old', 'kitas-landing-theme' ); ?></label>
                                            <!-- <span>years old</span> -->
                                        </div>

                                    </div>
                                    <div class="kids-select-age-block">
                                        <p id="text-for-from-to"><?php esc_html_e( 'To', 'kitas-landing-theme' ); ?></p>
                                        <div class="text-for-kids-select-age-block-to">
                                            <input type="number" id="year-old" name="year-old" placeholder=" " required="">
                                            <label for="year-old" class="label-for-year-old"><?php esc_html_e( 'years old', 'kitas-landing-theme' ); ?></label>
                                            <!-- <span>years old</span> -->
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <h4> <?php esc_html_e( 'Working language', 'kitas-landing-theme' ); ?><span class="red-required"> * </span></h4>
                            <p class="span-info-message"><?php esc_html_e( 'A language you work with in a group with kids or in a Kita', 'kitas-landing-theme' ); ?>. <span
                                    class="check-working-language-error"><?php esc_html_e( 'You can choose a few options', 'kitas-landing-theme' ); ?></span>.</p>
                            <div class="approach-options check-working-language">
                                <?php
                                if (!empty($language)) {
                                    foreach ($language as $term) {
                                        ?>
                                        <div class="input-select">
                                            <input type="checkbox" id="checkbox_<?php echo esc_attr($term->term_id); ?>"
                                                class="employment-checkbox-language" value="<?php echo esc_attr($term->slug); ?>">
                                            <label for="checkbox_<?php echo esc_attr($term->term_id); ?>">
                                                <?php echo esc_html($term->name); ?>
                                            </label><br>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>

                                <input type="checkbox" id="checkbox_other" class="employment-checkbox-language-other">
                                <label for="checkbox_other"><?php esc_html_e( 'Other', 'kitas-landing-theme' ); ?></label><br>
                                <div id="add-language-block-rel">
                                    <input type="text" id="other_language_input" class="other-language-input"
                                        placeholder=" ">
                                    <label for="other_language_input" class="label-for-other-language-input"><?php esc_html_e( 'Add language', 'kitas-landing-theme' ); ?></label>
                                </div>

                            </div>

                        </div>

                        <div id="step-4" style="display: none;">
                            <h2><?php esc_html_e( 'Job description', 'kitas-landing-theme' ); ?></h2>


                            <div class="job-block-textarea">
                                <h4><?php esc_html_e( 'Requirements', 'kitas-landing-theme' ); ?><span class="red-required"> * </span></h4>

                                <span class="placeholder-for-block"><?php esc_html_e( 'Describe the required work experience, education, certification, or other characteristics of the perfect candidate for this role', 'kitas-landing-theme' ); ?> </span>
                                <?php
                                $content_job_description = '';
                                $editor_job_description_id = 'job-description-describe-required-editor';

                                $settings_job_description_id = array(
                                    'textarea_name' => $editor_job_description_id,
                                    'textarea_rows' => 10,
                                    'editor_height' => 300,
                                    'media_buttons' => false,
                                    'quicktags' => false,
                                    'tinymce' => array(
                                        'plugins' => 'wordpress,wpautoresize,wpdialogs,wplink,wptextpattern,wpview',
                                        'toolbar1' => 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,wp_adv',
                                    ),
                                );

                                wp_editor($content_job_description, $editor_job_description_id, $settings_job_description_id);
                                ?>
                            </div>

                            <div class="job-block-textarea">
                                <h4><?php esc_html_e( 'Nice to have', 'kitas-landing-theme' ); ?></h4>
                                <span class="placeholder-for-block"><?php esc_html_e( 'Describe skills and knowledge that would be nice to have for this role, that would be a plus', 'kitas-landing-theme' ); ?> </span>
                                <?php
                                $content_job_description_describe = '';
                                $editor_job_description_describe_id = 'job-description-describe-skills';

                                $settings_job_description_describe_id = array(
                                    'textarea_name' => $editor_job_description_describe_id,
                                    'textarea_rows' => 10,
                                    'editor_height' => 300,
                                    'media_buttons' => false,
                                    'quicktags' => false,
                                    'tinymce' => array(
                                        'plugins' => 'wordpress,wpautoresize,wpdialogs,wplink,wptextpattern,wpview',
                                        'toolbar1' => 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,wp_adv',
                                    ),
                                );

                                wp_editor($content_job_description_describe, $editor_job_description_describe_id, $settings_job_description_describe_id);
                                ?>
                            </div>

                            <div class="job-block-textarea">
                                <h4><?php esc_html_e( 'Responsibilities', 'kitas-landing-theme' ); ?><span class="red-required"> * </span></h4>
                                <span class="placeholder-for-block">
                                <?php esc_html_e( 'Create a list of the daily tasks and duties in this position: <br>• task 1 <br> • task 2', 'kitas-landing-theme' ); ?>
                                </span>
                                <?php
                                $content_job_description_create_list = '';
                                $editor_job_description_create_list_id = 'job-description-describe-create-list';

                                $settings_job_description_create_list_id = array(
                                    'textarea_name' => $editor_job_description_create_list_id,
                                    'textarea_rows' => 10,
                                    'editor_height' => 300,
                                    'media_buttons' => false,
                                    'quicktags' => false,
                                    'tinymce' => array(
                                        'plugins' => 'wordpress,wpautoresize,wpdialogs,wplink,wptextpattern,wpview',
                                        'toolbar1' => 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,wp_adv',
                                    ),
                                );

                                wp_editor($content_job_description_create_list, $editor_job_description_create_list_id, $settings_job_description_create_list_id);
                                ?>
                            </div>

                            <div class="job-block-textarea">
                                <h4><?php esc_html_e( 'Benefits', 'kitas-landing-theme' ); ?><span class="red-required"> * </span></h4>
                                <span class="placeholder-for-block">
                                    <?php esc_html_e( 'Describe benefits of working in this position for this company. E.g., advanced educational training, insurance, or other sorts of support', 'kitas-landing-theme' ); ?></span>
                                <?php
                                $content_job_description_describe_benefits = '';
                                $editor_job_description_describe_benefits_id = 'job-description-describe-benefits';

                                $settings_job_description_describe_benefits_id = array(
                                    'textarea_name' => $editor_job_description_describe_benefits_id,
                                    'textarea_rows' => 10,
                                    'editor_height' => 300,
                                    'media_buttons' => false,
                                    'quicktags' => false,
                                    'tinymce' => array(
                                        'plugins' => 'wordpress,wpautoresize,wpdialogs,wplink,wptextpattern,wpview',
                                        'toolbar1' => 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,wp_adv',
                                    ),
                                );

                                wp_editor($content_job_description_describe_benefits, $editor_job_description_describe_benefits_id, $settings_job_description_describe_benefits_id);
                                ?>
                            </div>

                            <div class="job-block-textarea">
                                <h4><?php esc_html_e( 'Other details', 'kitas-landing-theme' ); ?></h4>
                                <span class="placeholder-for-block"><?php esc_html_e( 'You can mention additional details other details', 'kitas-landing-theme' ); ?></span>
                                <?php
                                $content_job_description_describe_other = '';
                                $editor_job_description_describe_other_id = 'job-description-describe-mention';

                                $settings_job_description_describe_other_id = array(
                                    'textarea_name' => $editor_job_description_describe_other_id,
                                    'textarea_rows' => 10,
                                    'editor_height' => 300,
                                    'media_buttons' => false,
                                    'quicktags' => false,
                                    'tinymce' => array(
                                        'plugins' => 'wordpress,wpautoresize,wpdialogs,wplink,wptextpattern,wpview',
                                        'toolbar1' => 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,wp_adv',
                                    ),
                                );

                                wp_editor($content_job_description_describe_other, $editor_job_description_describe_other_id, $settings_job_description_describe_other_id);
                                ?>
                            </div>

                            <div class="job-block-textarea">
                                <h4> <?php esc_html_e( 'Applying process', 'kitas-landing-theme' ); ?><span class="red-required"> * </span></h4>
                                <span class="placeholder-for-block"><?php esc_html_e( 'You can mention additional details that make you and your company stand out', 'kitas-landing-theme' ); ?></span>
                                <?php
                                $content_job_description_applying_process = '';
                                $editor_job_description_applying_process_id = 'job-description-applying-process';

                                $settings_job_description_applying_process_id = array(
                                    'textarea_name' => $editor_job_description_applying_process_id,
                                    'textarea_rows' => 10,
                                    'editor_height' => 300,
                                    'media_buttons' => false,
                                    'quicktags' => false,
                                    'tinymce' => array(
                                        'plugins' => 'wordpress,wpautoresize,wpdialogs,wplink,wptextpattern,wpview',
                                        'toolbar1' => 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,wp_adv',
                                    ),
                                );

                                wp_editor($content_job_description_applying_process, $editor_job_description_applying_process_id, $settings_job_description_applying_process_id);
                                ?>
                            </div>

                            <div class="job-block-textarea">
                                <h4><?php esc_html_e( 'About company', 'kitas-landing-theme' ); ?></h4>
                                <span class="placeholder-for-block"><?php esc_html_e( 'You can mention additional details about company', 'kitas-landing-theme' ); ?></span>
                                <?php
                                $content_job_description_about_company = '';
                                $editor_job_description_about_company_id = 'job-description-about_company';

                                $settings_job_description_about_company_id = array(
                                    'textarea_name' => $editor_job_description_about_company_id,
                                    'textarea_rows' => 10,
                                    'editor_height' => 300,
                                    'media_buttons' => false,
                                    'quicktags' => false,
                                    'tinymce' => array(
                                        'plugins' => 'wordpress,wpautoresize,wpdialogs,wplink,wptextpattern,wpview',
                                        'toolbar1' => 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,wp_adv',
                                    ),
                                );

                                wp_editor($content_job_description_about_company, $editor_job_description_about_company_id, $settings_job_description_about_company_id);
                                ?>
                            </div>

                            <div class="upload-photo-gallery">
                                <h3><?php esc_html_e( 'Upload photo gallery', 'kitas-landing-theme' ); ?></h3>
                                <button id="upload-photo-gallery-button"><?php esc_html_e( 'Upload photos', 'kitas-landing-theme' ); ?></button>
                                <input type="file" id="photo-input" accept="image/*" multiple style="display: none;">
                                <div id="gallery" class="gallery-image-download"></div>
                            </div>

                            <input type="submit" name="submit_custom_form" value="Save" style="display: none;">
                        </div>

                    </form>

                    <div class="preview-mail-block">

                        <h1><?php esc_html_e( 'Job post preview', 'kitas-landing-theme' ); ?></h1>

                        <div class="preview-mail-block-info">
                            <div class="preview-mail-block-info-sub-title">
                                <h2><?php esc_html_e('Job Basics', 'kitas-landing-theme'); ?></h2>
                                

                                <a href="#" id="first-step"><img src="/wp-content/uploads/2024/03/Vector.jpg" alt=""></a>
                            </div>
                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Job title', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-title-value"></p>
                            </div>

                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Job Category', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-category-value"></p>
                            </div>

                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Location', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-location-value"></p>
                            </div>

                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Start work date', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-start-value"></p>
                            </div>

                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Apply deadline', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-deadline-value"></p>
                            </div>

                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Urgency', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-urgency-value"></p>
                            </div>

                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Temporary position', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-temporary-position-value"></p>
                            </div>

                        </div>

                        <div class="preview-mail-block-info">
                            <div class="preview-mail-block-info-sub-title">
                                <h2><?php esc_html_e( 'Employment', 'kitas-landing-theme' ); ?></h2>
                                <a href="#" id="second-step"><img src="/wp-content/uploads/2024/03/Vector.jpg" alt=""></a>
                            </div>
                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Contract type', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-contract-type-value"></p>
                            </div>
                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Workload', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-workload-value"></p>
                            </div>

                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Working hours', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-working-hours-value"></p>
                            </div>

                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Salary', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-salary-value"></p>
                            </div>

                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Vacation', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-vacation-value"></p>
                            </div>

                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Other benefits', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-other-benefits-value"></p>
                            </div>

                            <!-- <div class="preview-mail-block-info-child">
                                <h4>Duration</h4>
                                <p id="job-duration-value"></p>
                            </div> -->


                        </div>

                        <div class="preview-mail-block-info">
                            <div class="preview-mail-block-info-sub-title">
                                <h2><?php esc_html_e( 'Job details', 'kitas-landing-theme' ); ?></h2>
                                <a href="#" id="tree-step"><img src="/wp-content/uploads/2024/03/Vector.jpg" alt=""></a>
                            </div>
                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Teaching approach', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-approach-value"></p>

                            </div>
                            <div class="preview-mail-block-info-child">
                                <h4></h4>
                                <p id="job-approach-value-additionally"></p>
                            </div>

                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Kids age in a group', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-approach-options-value"></p>
                            </div>

                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Working language(s)', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-language-value"></p>
                            </div>
                        </div>

                        <div class="preview-mail-block-info">
                            <div class="preview-mail-block-info-sub-title">
                                <h2><?php esc_html_e( 'Job description', 'kitas-landing-theme' ); ?></h2>
                                <a href="#" id="fourth-step"><img src="/wp-content/uploads/2024/03/Vector.jpg" alt=""></a>
                            </div>
                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Requirements', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-requirements-value"></p>
                            </div>
                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Nice to have', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-nice-to-have-value"></p>
                            </div>

                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Responsibilities', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-responsibilities-value"></p>
                            </div>

                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Benefits', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-benefits-value"></p>
                            </div>

                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Other details', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-other-details-value"></p>
                            </div>

                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Applying process', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-applying-process-value"></p>
                            </div>

                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'About company', 'kitas-landing-theme' ); ?></h4>
                                <p id="job-about-company-value"></p>
                            </div>

                            <div class="preview-mail-block-info-child">
                                <h4><?php esc_html_e( 'Upload photo gallery', 'kitas-landing-theme' ); ?></h4>
                                <div id="gallery-preview" class="gallery-image-download"></div>
                            </div>
                        </div>

                    </div>

                    <div class="button-back-next">
                        <a href="#" class="button-back"><?php esc_html_e( 'Back', 'kitas-landing-theme' ); ?></a>
                        <div class="button-next-variations">
                            <a href="#" id="preview-button" class="button-preview"><i class="fa fa-eye"></i><?php esc_html_e( 'Preview', 'kitas-landing-theme' ); ?></a>
                            <a href="#" class="button-next-final "><?php esc_html_e( 'Publish', 'kitas-landing-theme' ); ?></a>
                            <a href="#" class="button-next"><?php esc_html_e( 'Next step', 'kitas-landing-theme' ); ?></a>
                        </div>
                    </div>

                    <div class="button-save-publick">
                        <a href="#" class="button-save-draft"><?php esc_html_e( 'Save as draft', 'kitas-landing-theme' ); ?></a>
                        <a href="#" class="button-publish"><?php esc_html_e( 'Publish', 'kitas-landing-theme' ); ?></a>

                    </div>
                </div>
            </div>

            <?php
        } else { ?>
            <div class="registration-form-company">
                <h1>Post a job</h1>
                <p>You need to create a company profile to post a job.</p>
                <br><br>
                <h2>Company profile</h2>
                <form action="" method="post">



                    <div class="full-fields">
                        <h4>Company name<span class="red-required"> * </span></h4>
                        <input type="text" id="company-name" name="company-name">
                    </div>

                    <h4>Location<span class="red-required"> * </span></h4>
                    <div class="half-fields">
                        <div class="flex-item">
                            <?php if (!empty($job_categories)) {
                                ?>
                                <select name="company-canton" id="company-canton">
                                    <option value="">Cantone</option>
                                    <?php foreach ($job_categories as $category): ?>
                                        <option value="<?php echo $category->term_id; ?>">
                                            <?php echo $category->name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="flex-item">
                            <input type="text" id="company-city" name="company-city" placeholder=" ">
                            <label for="company-city" class="label-for-company-city">City</label>
                        </div>
                        <div class="flex-item">
                            <input type="text" id="company-street-and-building" name="company-street-and-building"
                                placeholder=" ">
                            <label for="company-street-and-building" class="label-for-company-street-and-building">Street
                                and building</label>
                        </div>
                        <div class="flex-item">
                            <input type="text" id="company-zip-code" name="company-zip-code" placeholder=" ">
                            <label for="company-zip-code" class="label-for-company-zip-code">ZIP code</label>
                        </div>
                    </div>

                    <h4>Company size<span class="red-required"> * </span></h4>
                    <div class="half-fields">
                        <div class="flex-item">
                            <select id="company-size" name="company-size" placeholder="Number of employees">
                                <option value="1-10">1-10</option>
                                <option value="11-49">11-49</option>
                                <option value="50+">50+</option>
                            </select>
                        </div>
                    </div>

                    <h4>Company website</h4>
                    <div class="half-fields">
                        <div class="flex-item">
                            <input type="text" id="company-website" name="company-website" placeholder=" ">
                            <label for="company-website" class="label-for-company-website">www.</label>
                        </div>
                    </div>
                    <div class="contact-information">
                        <h2>Contact information</h2>
                        <div class="half-fields">
                            <div class="flex-item">
                                <h4>Email<span class="red-required"> * </span></h4>
                                <input type="text" id="company-email" name="company-email" placeholder=" ">
                                <label for="company-email" class="label-for-company-email">email@gmail.com </label>
                            </div>

                            <div class="flex-item">
                                <h4>Full name<span class="red-required"> * </span></h4>

                                <input type="text" id="company-full-name" name="company-full-name" placeholder=" ">
                                <label for="company-full-name" class="label-for-company-full-name">Maria Maier</label>
                            </div>
                            <div class="flex-item">
                                <h4>Phone number</h4>
                                <div class="full-fields">
                                    <input type="text" id="company-phone-number" name="company-phone-number"
                                        placeholder=" ">
                                    <label for="company-phone-number"
                                        class="label-for-company-phone-number">+41445860037</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="reg-create-button">
                        <!-- <a href="#" class="create-a-profile">Create a profile</a> -->
                        <button type="submit" class="create-a-profile">Create a profile</button>
                    </div>
                </form>
            </div>
        <?php }



        ?>
    </div>
</main>

<?php
get_footer();
