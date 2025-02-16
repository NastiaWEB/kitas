<?php
/**
 * Template name: Search Jobs
 */

get_header();
?>
<?php
//getting all the query vars
// $current_locale = isset($_GET['current_locale']) ? $_GET['current_locale'] : 'en';
$url = $_SERVER['REQUEST_URI'];
$current_locale = 'en';

if (str_contains($url, '/de')) {
    $current_locale = 'de';
}
$selected_type = isset($_GET['employment_type']) ? $_GET['employment_type'] : '';
$selected_date = isset($_GET['dateFilter']) ? $_GET['dateFilter'] : '';
$selected_langs = isset($_GET['langFilter']) ? $_GET['langFilter'] : '';
$selected_period = isset($_GET['periodFilter']) ? $_GET['periodFilter'] : '';
$search_name = isset($_GET['searchNameFilter']) ? $_GET['searchNameFilter'] : '';
$search_by = isset($_GET['whatTermFilter']) ? $_GET['whatTermFilter'] : '';
$search_where = isset($_GET['locFilter']) ? $_GET['locFilter'] : '';
$min_load = isset($_GET['minLoadFilter']) ? $_GET['minLoadFilter'] : '';
$max_load = isset($_GET['maxLoadFilter']) ? $_GET['maxLoadFilter'] : '';
$categories = isset($_GET['catFilter']) ? $_GET['catFilter'] : '';
$paged = isset($_GET['currentPage']) ? $_GET['currentPage'] : '';
$search_bar_where = isset($_GET['locSearch']) ? $_GET['locSearch'] : '';
$orderBy = '';
$selected_workloads = isset($_GET['workloadFilter']) ? $_GET['workloadFilter'] : '';
?>
<main id="primary" class="site-main">
    <div class="main-container">
        <div class="main-content">
            <?php
            //   Custom breadcrumbs
            function custom_breadcrumbs()
            {
                $before = '<div class="breadcrumb">'; // Tag before the breadcrumb block
                $after = '</div>'; // Tag after the breadcrumb block
            
                // Get the current page title
                $current_page_title = get_the_title();

                // Display breadcrumbs
                echo $before . ' / ' . $current_page_title . $after;
            }

            custom_breadcrumbs();
            ?>

            <div class="search-panel">
                <div class="company-search dropdown">
                    <div class="prefix bold"><?php esc_html_e( "What", 'kitas-landing-theme' ); ?></div>
                    <input type="text" class="dropbtn" placeholder="<?php esc_html_e( "Job title, keyword, or company", 'kitas-landing-theme' ); ?>" id="whatInput"
                        autocomplete="one-time-code">
                    <div id="whatDropdown" class="dropdown-content">
                        <div id="whatUnfiltered">
                            <div id="jobs">
                                <?php
                                $url = $_SERVER['REQUEST_URI'];
                                $lang = 'en';

                                if (str_contains($url, '/de')) {
                                    $lang = 'de';
                                }

                                $args = array(
                                    'post_type' => 'job-offer',
                                    'lang' => $lang,
                                );

                                $offers = get_posts($args);

                                foreach ($offers as $offer) {
                                    echo '<a id="' . $offer->post_name . '" href="' . $offer->ID . '">';
                                    echo get_the_title($offer->ID) . ' <span class="hintCaption">- job</span>';
                                    echo '</a>';
                                }
                                ?>
                            </div>
                            <div id="companies">
                                <?php
                                $companies = get_users();

                                foreach ($companies as $company) {
                                    echo '<a id="" href="">';
                                    echo $company->display_name . ' <span class="hintCaption">- company</span>';
                                    echo '</a>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="location-search">
                    <div class="prefix bold"><?php esc_html_e( "Where", 'kitas-landing-theme' ); ?></div>
                    <input type="text" class="dropBtn" placeholder="<?php esc_html_e( "City or ZIP code", 'kitas-landing-theme' ); ?>" id="whereInput"
                        autocomplete="one-time-code">
                    <div id="whereDropdown" class="dropdown-content">
                        <div id="whereUnfiltered">
                            <div id="locations">
                                <?php
                                $locs = get_terms(
                                    array(
                                        'taxonomy' => 'location',
                                        'hide_empty' => false,
                                    )
                                );

                                foreach ($locs as $loc) {
                                    $post_count = get_term($loc->term_id, 'location')->count;
                                    echo '<a id="" href="">';
                                    echo $loc->name . ' <span class="hintCaption"> (' . $post_count . ')</span>';
                                    echo '</a>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="button button-search-panel color-teal filtersConfirm" role="button" id="searchConfirm">
                    <p class="button-text"><?php esc_html_e( "Search", 'kitas-landing-theme' ); ?></p>
                </button>
            </div>

            <div class="filters">
                <ul class="filters-list">
                    <li class="category-list"><a href="#" aria-haspopup="true"><?php esc_html_e( "Category", 'kitas-landing-theme' ); ?>
                            <div class="caret"></div>
                        </a>
                        <ul class="dropdown-wrapper" aria-label="category">
                            <li>
                                <div class="wc-box">
                                    <div class="close"></div>
                                </div>
                                <div class="filter-dropdown" id="catConfirm">
                                    <?php
                                    $cats = get_terms([
                                        'post_type' => 'job-offer',
                                        'taxonomy' => 'job_category',
                                        'hide_empty' => false,
                                    ]);
                                    $cats_left = array_slice($cats, 0, 5);
                                    $cats_right = array_slice($cats, 5);
                                    ?>
                                    <div class="filter-job cat-filter-left">
                                        <?php
                                        foreach ($cats_left as $cat) {
                                            ?>
                                            <label class="label-container">
                                                <p class="item-title label-text" data-term="<?php echo $cat->slug; ?>">
                                                    <?php
                                                    echo $cat->name;
                                                    ?>
                                                </p>
                                                <div
                                                    class="filter-tag <?php echo $cat->count > 0 ? 'tag-filled' : ($cat->count == 0 ? 'tag-empty' : ''); ?>">
                                                    <?php echo $cat->count; ?>
                                                </div>
                                                <input type="checkbox" <?php if (str_contains($categories, $cat->slug)) {
                                                    echo 'checked';
                                                } ?>>
                                                <span class="checkmark"></span>
                                            </label>
                                            <?php
                                        }
                                        ?>

                                    </div>
                                    <div class="filter-job-right cat-filter-right">
                                        <?php
                                        foreach ($cats_right as $cat) {
                                            ?>
                                            <label class="label-container">
                                                <p class="item-title label-text" data-term="<?php echo $cat->slug ?>">
                                                    <?php
                                                    echo $cat->name;
                                                    ?>
                                                </p>
                                                <div
                                                    class="filter-tag <?php echo $cat->count > 0 ? 'tag-filled' : ($cat->count == 0 ? 'tag-empty' : ''); ?>">
                                                    <?php echo $cat->count; ?>
                                                </div>
                                                <input type="checkbox" <?php if (str_contains($categories, $cat->slug)) {
                                                    echo 'checked';
                                                } ?>>
                                                <span class="checkmark"></span>
                                            </label>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <!-- <button class="filtersConfirm" id="catConfirm">
                                    <?php //echo the_field('apply_filter_button_title', 'options'); ?>
                                </button> -->
                            </li>
                        </ul>
                    </li>

                    <li class="category-list" id="employmentDropdown"><a href="#" aria-haspopup="true">
                            <?php echo the_field('employment_type_filter_title', 'options'); ?>
                            <div class="caret"></div>
                        </a>
                        <ul class="dropdown-wrapper" aria-label="employment-type">
                            <li>
                                <div class="wc-box">
                                    <div class="close"></div>
                                </div>
                                <div class="filter-dropdown" id="employmentTypeConfirm">
                                    <div class="filter-job">
                                        <?php
                                        $employment_types = get_terms([
                                            'post_type' => 'job-offer',
                                            'taxonomy' => 'employment-type',
                                            'hide_empty' => false,
                                        ]);

                                        foreach ($employment_types as $type) {
                                            ?>
                                            <label class="filter-job-container label-container">
                                                <p class="item-title label-text" data-term="<?php echo $type->slug ?>">
                                                    <?php
                                                    echo $type->name;
                                                    ?>
                                                </p>
                                                <div
                                                    class="filter-tag <?php echo $type->count > 0 ? 'tag-filled' : ($type->count == 0 ? 'tag-empty' : ''); ?>">
                                                    <?php echo $type->count; ?>
                                                </div>
                                                <input type="checkbox" <?php if (str_contains($selected_type, $type->slug)) {
                                                    echo 'checked';
                                                } ?>>
                                                <span class="checkmark"></span>
                                            </label>
                                            <?php
                                        }
                                        ?>

                                        <!-- <button class="filtersConfirm" id="employmentTypeConfirm">
                                            <?php //echo the_field('apply_filter_button_title', 'options'); ?>
                                        </button> -->
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="category-list"><a href="#" aria-haspopup="true"><?php esc_html_e( "Location", 'kitas-landing-theme' ); ?>
                            <div class="caret"></div>
                        </a>
                        <ul class="dropdown-wrapper" aria-label="location">
                            <li>
                                <div class="wc-box">
                                    <div class="close"></div>
                                </div>
                                <div class="filter-dropdown" id="locationsConfirm">
                                    <div class="filter-job">
                                        <dl class="accordion collapsable">
                                            <?php
                                            $locs = get_terms(
                                                array(
                                                    'post_type' => 'job-offer',
                                                    'taxonomy' => 'location',
                                                    'hide_empty' => false,
                                                    'parent' => 0,
                                                    'lang' => $lang
                                                )
                                            );

                                            foreach ($locs as $loc) {
                                                $children = get_term_children($loc->term_id, 'location');
                                                ?>
                                                <dt>
                                                    <label class="filter-job-container label-container">
                                                        <p class="item-title label-text"
                                                            data-term="<?php echo $loc->slug ?>">
                                                            <?php echo $loc->name; ?>
                                                        </p>

                                                        <div class="container-tag-caret">
                                                            <div
                                                                class="filter-tag <?php echo $loc->count > 0 ? 'tag-filled' : ($loc->count == 0 ? 'tag-empty' : ''); ?>">
                                                                <?php echo $loc->count; ?>
                                                            </div>
                                                            <input type="checkbox" <?php if (str_contains($search_where, $loc->slug)) {
                                                                echo 'checked';
                                                            } ?>>
                                                            <span class="checkmark"></span>
                                                            <?php if (count($children) > 0) { ?>
                                                                <div class="dropdown-caret"></div>
                                                            <?php } ?>
                                                        </div>

                                                    </label>
                                                </dt>
                                                <dd style="display: none">
                                                    <?php
                                                    $children = get_term_children($loc->term_id, 'location');
                                                    if (count($children) > 0) {
                                                        foreach ($children as $child) {
                                                            $term = get_term_by('id', $child, 'location');
                                                            ?>
                                                            <label class="label-container child-container">
                                                                <p class="item-title label-text"
                                                                    data-term="<?php echo $term->slug ?>">
                                                                    <?php echo $term->name; ?>
                                                                </p>
                                                                <div
                                                                    class="filter-tag <?php echo $term->count > 0 ? 'tag-filled' : ($term->count == 0 ? 'tag-empty' : ''); ?>">
                                                                    <?php echo $term->count; ?>
                                                                </div>
                                                                <input type="checkbox" <?php if (str_contains($search_where, $term->slug)) {
                                                                    echo 'checked';
                                                                } ?>>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </dd>
                                                <?php
                                            }
                                            ?>
                                        </dl>

                                        <!-- <button class="filtersConfirm" id="locationsConfirm">
                                            <?php // echo the_field('apply_filter_button_title', 'options'); ?>
                                        </button> -->
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="category-list" id="calendar-open"><a href="#" aria-haspopup="true">
                            <?php echo the_field('start_after_filter_title', 'options'); ?>
                            <?php echo '<input id="startDateQ" class="form-control" type="date" placeholder="Starts after: " min="1970-01-01" />'; ?>
                            <div class="caret"></div>

                        </a>
                        <ul class="dropdown-wrapper" aria-label="startsafter" style="opacity: 0;">
                            <li>
                                <div class="wc-box">
                                    <div class="close"></div>
                                </div>
                                <div class="filter-dropdown">
                                    <div class="filter-job">
                                        <?php echo '<input id="startDate" class="form-control" type="date" placeholder="Starts after: " min="1970-01-01" />'; ?>
                                        <button class="filtersConfirm" id="startsAfterConfirm" style="display: none;">
                                            <?php echo the_field('apply_filter_button_title', 'options'); ?>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>


                    <li class="category-list"><a href="#" aria-haspopup="true">
                            <?php echo the_field('language_filter_title', 'options'); ?>
                            <div class="caret"></div>
                        </a>
                        <ul class="dropdown-wrapper" aria-label="language">
                            <li>
                                <div class="wc-box">
                                    <div class="close"></div>
                                </div>
                                <div class="filter-dropdown" id="langConfirm">
                                    <div class="filter-job">
                                        <?php
                                        $languages = get_terms([
                                            'post_type' => 'job-offer',
                                            'taxonomy' => 'offer_language',
                                            'hide_empty' => false,
                                        ]);

                                        foreach ($languages as $lang) {
                                            ?>
                                            <label class="label-container">
                                                <p class="item-title label-text" data-term="<?php echo $lang->slug ?>">
                                                    <?php
                                                    echo $lang->name;
                                                    ?>
                                                </p>
                                                <div
                                                    class="filter-tag <?php echo $lang->count > 0 ? 'tag-filled' : ($lang->count == 0 ? 'tag-empty' : ''); ?>">
                                                    <?php echo $lang->count; ?>
                                                </div>
                                                <input type="checkbox" <?php if (str_contains($selected_langs, $lang->slug)) {
                                                    echo 'checked';
                                                } ?>>
                                                <span class="checkmark"></span>
                                            </label>
                                            <?php
                                        }
                                        ?>
                                        <!-- <button class="filtersConfirm" id="langConfirm">
                                            <?php // echo the_field('apply_filter_button_title', 'options'); ?>
                                        </button> -->
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="category-list"><a href="#" aria-haspopup="true">
                            <?php echo the_field('time_posted_filter_title', 'options'); ?>
                            <div class="caret"></div>
                        </a>
                        <ul class="dropdown-wrapper" aria-label="time-posted">
                            <li>
                                <div class="wc-box">
                                    <div class="close"></div>
                                </div>
                                <div class="filter-dropdown" id="dateOfPostConfirm">
                                    <div class="filter-job">
                                        <label class="label-container">
                                            <p class="item-title label-text lastDay" data-term="after-1-day-ago">
                                                <?php echo the_field('posted_in_last_24_hours', 'options'); ?>
                                            </p>
                                            <input type="checkbox" id="lastDayFilter" <?php
                                            if (str_contains($selected_period, 'after-1-day-ago')) {
                                                echo 'checked';
                                            }
                                            ?>>
                                            <span class="checkmark"></span>
                                        </label>

                                        <label class="label-container">
                                            <p class="item-title label-text lastWeek" data-term="after-1-week-ago">
                                                <?php echo the_field('posted_in_last_week', 'options'); ?>
                                            </p>
                                            <input type="checkbox" id="lastWeekFilter" <?php
                                            if (str_contains($selected_period, 'after-1-week-ago')) {
                                                echo 'checked';
                                            }
                                            // ?>>
                                            <span class="checkmark"></span>
                                        </label>

                                        <label class="label-container">
                                            <p class="item-title label-text moreThanWeek" data-term="before-1-week-ago">
                                                <?php echo the_field('posted_more_than_a_week_ago', 'options'); ?>
                                            </p>
                                            <input type="checkbox" id="moreThanWeekFilter" <?php if (str_contains($selected_period, 'before-1-week-ago')) {
                                                echo 'checked';
                                            } ?>>
                                            <span class="checkmark"></span>
                                        </label>
                                        <!-- <button class="filtersConfirm" id="dateOfPostConfirm">
                                            <?php // echo the_field('apply_filter_button_title', 'options'); ?>
                                        </button> -->
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li class="category-list"><a href="#" aria-haspopup="true">
                            <?php echo the_field('workload_filter_title', 'options'); ?>
                            <div class="caret"></div>
                        </a>
                        <ul class="dropdown-wrapper dropdown-end" aria-label="workload">
                            <li>
                                <div class="wc-box">
                                    <div class="close"></div>
                                </div>
                                <div class="filter-dropdown" id="workloadSelect">
                                    <div class="filter-job">
                                        <?php

                                        $workload_ranges = array(
                                            'up_to_50_percent' => 'Up to 50%',
                                            '50_to_80_percent' => '50 - 80%',
                                            'over_80_percent' => 'Over 80%'
                                        );

                                        $percent_ranges = array(
                                            'up_to_50_percent' => '0-50',
                                            '50_to_80_percent' => '50-80',
                                            'over_80_percent' => '80-100'
                                        );


                                        function get_post_count_in_range($min, $max)
                                        {
                                            $args = array(
                                                'post_type' => 'job-offer',
                                                'meta_query' => array(
                                                    'relation' => 'AND',
                                                    array(
                                                        'key' => 'workload',
                                                        'value' => array($min, $max),
                                                        'type' => 'NUMERIC',
                                                        'compare' => 'BETWEEN'
                                                    ),
                                                    array(
                                                        'key' => 'max_workload',
                                                        'value' => array($min, $max),
                                                        'type' => 'NUMERIC',
                                                        'compare' => 'BETWEEN'
                                                    )
                                                )
                                            );
                                            $query = new WP_Query($args);
                                            return $query->found_posts;
                                        }

                                        foreach ($workload_ranges as $slug => $label) {
                                            $range = explode('-', $percent_ranges[$slug]);
                                            $minValue = $range[0];
                                            $maxValue = $range[1];
                                            $count = get_post_count_in_range($minValue, $maxValue);
                                            ?>
                                            <label class="label-container">
                                                <p class="item-title label-text" data-term="<?php echo esc_attr($slug); ?>"
                                                    data-min="<?php echo esc_attr($minValue); ?>"
                                                    data-max="<?php echo esc_attr($maxValue); ?>">
                                                    <?php echo esc_html($label); ?>
                                                </p>
                                                <div
                                                    class="filter-tag <?php echo $count > 0 ? 'tag-filled' : 'tag-empty'; ?>">
                                                    <?php echo $count; ?>
                                                </div>
                                                <input type="checkbox" value="<?php echo esc_attr($slug); ?>" <?php if (isset($selected_workloads) && str_contains($selected_workloads, $slug)) {
                                                       echo 'checked';
                                                   } ?>>
                             <span class="checkmark"></span>
                                            </label>
                                            <?php
                                        }
                                        ?>
                                    </div>

                                </div>

                            </li>

                        </ul>
                    </li>



                </ul>

                <div id="postFilters">
                    <div class="block-reset-all">
                        <button class="reset-all-chips">
                            <p class="button-text"><?php esc_html_e( "Reset all", 'kitas-landing-theme' ); ?></p>
                        </button>
                    </div>
                    <div class="job-card-tags">

                    </div>

                </div>


                <div id="sortList" class="sorts-list">
                    <div class="sort-more">
                        <span class="sort-title-sort-more"> <?php esc_html_e( "Sort by", 'kitas-landing-theme' ); ?><span style="font-weight: 600;"
                                id="active-sort-word"><?php esc_html_e( "Most recent", 'kitas-landing-theme' ); ?></span></span>
                        <div class="caret"></div>
                        <div class="dropdown-sort-most">
                            <div class="dropdown-content-sort-most">
                                <div class="sort-item" href="#" id="sort-most-recent"><?php esc_html_e( "Most recent", 'kitas-landing-theme' ); ?></div>
                                <div class="sort-item" href="#" id="sort-earliest-start-date"><?php esc_html_e( "Earliest start date", 'kitas-landing-theme' ); ?></div>
                                <!-- <div class="sort-item" href="#" id="sort-top-rated">Top-rated</div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div id="jobsList">
                <?php
                function get_user_dislike_list($user_id)
                {
                    $dislike_list = get_field('hide_post_dislike', 'user_' . $user_id);

                    if (!$dislike_list) {
                        return [];
                    }

                    $post_ids = [];
                    foreach ($dislike_list as $item) {
                        if (isset($item['hide_post_dislike_id'])) {
                            $post_ids[] = intval($item['hide_post_dislike_id']);
                        }
                    }

                    return $post_ids;
                }


                $user_id = get_current_user_id();
                $dislike_list = get_user_dislike_list($user_id);

                $metaKey = '';
                $paged = isset($_GET['currentPage']) ? $_GET['currentPage'] : 1;
                $orderBy = 'date'; // Default value
                $order = 'DESC'; // Default value
                $today = date('Ymd');
                

                if (isset($_POST['orderby'])) {
                    switch ($_POST['orderby']) {
                        case 'sort-most-recent':
                            $orderBy = 'date';
                            break;
                        case 'sort-earliest-start-date':
                            $orderBy = 'meta_value_num';
                            $metaKey = 'starts_on';
                            break;
                        case 'sort-apply-by-date':
                            $orderBy = 'meta_value';
                            $metaKey = 'apply_by';
                            $order = 'ASC'; // Optional: Change order to ASC for apply_by date
                            break;
                        default:
                            $orderBy = 'date';
                            break;
                    }
                }

                $args = array(
                    'posts_per_page' => -1,
                    'search_name' => $search_name, // query var
                    'orderby' => array(
                        'meta_value' => 'DESC', // Sorting by meta value first (true/false)
                        'date' => 'DESC' // Then by date
                    ),
                    'meta_key' => 'checkactivevacationtruefalse', // Meta key for the first orderby clause
                    'order' => $order,
                    'meta_query' => array(
                        'relation' => 'AND',
                        array(
                            'key' => 'checkactivevacationtruefalse',
                            'compare' => 'EXISTS' // Ensure the meta key exists
                        )
                    ),
                    'tax_query' => array(
                        'relation' => 'AND',
                    ),
                    'post_type' => 'job-offer',
                    'lang' => $current_locale, // query var
                    'suppress_filters' => false,
                    'post__not_in' => $dislike_list, // Exclude disliked posts
                    
                );

                // Checking if location from search bar exists
                $locs = get_terms(
                    array(
                        'post_type' => 'job-offer',
                        'taxonomy' => 'location',
                        'hide_empty' => false,
                        'lang' => $current_locale
                    )
                );

                foreach ($locs as $loc) {
                    if (str_contains($loc->name, $search_bar_where) && strlen($search_bar_where) > 0) {
                        if (strlen($search_where) > 0) {
                            $search_where .= '|';
                            $search_where .= $loc->slug;
                        } else {
                            $search_where = $loc->slug;
                        }
                    }
                }

                // Filter by type on load
                if (strlen($selected_type) > 0) {
                    $selected_type = explode('|', $selected_type);
                    $type_filter = array(
                        'taxonomy' => 'employment-type',
                        'field' => 'slug',
                        'terms' => $selected_type
                    );
                    array_push($args['tax_query'], $type_filter);
                }

                // Filter by category on load
                if (strlen($categories) > 0) {
                    $categories = explode('|', $categories);
                    $cat_filter = array(
                        'taxonomy' => 'job_category',
                        'field' => 'slug',
                        'terms' => $categories
                    );
                    array_push($args['tax_query'], $cat_filter);
                }

                // Filter by date on load
                if (strlen($selected_date) > 0) {
                    $date_filter = array(
                        'key' => 'starts_on',
                        'compare' => '>',
                        'value' => $selected_date,
                        'type' => 'DATETIME',
                    );
                    array_push($args['meta_query'], $date_filter);
                }

                // Filter by lang on load
                if (strlen($selected_langs) > 0) {
                    $selected_langs = explode('|', $selected_langs);
                    $lang_filter = array(
                        'taxonomy' => 'offer_language',
                        'field' => 'slug',
                        'terms' => $selected_langs
                    );
                    array_push($args['tax_query'], $lang_filter);
                }

                // New workload (checkbox)
                if (strlen($selected_workloads) > 0) {
                    $selected_workloads = explode('|', $selected_workloads);
                    $workload_filter = array(
                        'taxonomy' => 'workload_percentage',
                        'field' => 'slug',
                        'terms' => $selected_workloads
                    );
                    array_push($args['tax_query'], $workload_filter);
                }

                // Filter by loc on load
                if (strlen($search_where) > 0) {
                    $search_where = explode('|', $search_where);
                    $loc_filter = array(
                        'taxonomy' => 'location',
                        'field' => 'slug',
                        'terms' => $search_where
                    );
                    array_push($args['tax_query'], $loc_filter);
                }

                $args['date_query'] = array();

                // Filter by time of post on load
                if (strlen($selected_period) > 0) {
                    $selected_period = explode('|', $selected_period);
                    if (in_array('after-1-day-ago', $selected_period)) {
                        $period_filter = array(
                            'after' => '1 day ago',
                        );
                        array_push($args['date_query'], $period_filter);
                    }

                    if (in_array('after-1-week-ago', $selected_period)) {
                        $period_filter_2 = array(
                            'after' => '1 week ago',
                        );
                        array_push($args['date_query'], $period_filter_2);
                    }

                    if (in_array('before-1-week-ago', $selected_period)) {
                        $period_filter_3 = array(
                            'before' => '1 week ago',
                        );
                        array_push($args['date_query'], $period_filter_3);
                    }
                }

                // Filter by author on load
                if ($search_by == 'company') {
                    $args['author_name'] = $search_name;
                }

                // Getting filtered offers and applying search term
                if ($search_by == 'job' || $search_by == '') {
                    add_filter('posts_where', 'search_by_name', 10);
                }

                $query = new WP_Query($args);

                if ($search_by == 'job' || $search_by == '') {
                    remove_filter('posts_where', 'search_by_name', 10);
                }

                $total_query = new WP_Query(
                    array(
                        'post_type' => 'job-offer',
                        'post__in' => wp_list_pluck($query->posts, 'ID'),
                        'orderby' => 'post__in',
                        'posts_per_page' => 10,
                        'paged' => $paged
                    )
                );

                // Pagination links
                $pagination = paginate_links(
                    array(
                        'base' => home_url('/%_%'),
                        'format' => 'page/%#%',
                        'current' => max(1, $paged),
                        'total' => $total_query->max_num_pages,
                        'prev_text' => '<img src="/wp-content/themes/kitas-landing-theme/img/caret.svg" class="pagination-icon prev-icon-left" alt="Previous">',
                        'next_text' => '<img src="/wp-content/themes/kitas-landing-theme/img/caret.svg" class="pagination-icon next-icon-right" alt="Previous">',
                        'add_args' => $args // Only necessary args
                    )
                );
                $pagination = str_replace('<a class="prev page-numbers"', '<a class="prev page-numbers" data-paged="prev"', $pagination);
                $pagination = str_replace('<a class="next page-numbers"', '<a class="prev page-numbers" data-paged="next"', $pagination);

                $button_html = '<div class="load-more">
        <button class="button color-teal" role="button">Load more</button>
        </div>';

                // Setting query var so we can pass offers list into template part
                $data = array(
                    'query' => $total_query,
                    'pages' => $pagination
                );
                set_query_var('data', $data);

                // Posts loop output
                if ($paged > $total_query->max_num_pages) {
                    echo '<h1 class="noMore">No more jobs!</h1>';
                } else {
                    get_template_part('template-parts/offers-loop', null, $data);
                    echo '<div class="button-container">' . $button_html . '</div>';

                    echo '<div class="pagination-links">' . $pagination . '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</main><!-- #main -->

<?php
get_footer();
?>
<div class="modal" id="applicationModal">
    <div class="modal-content" id="applicationForm">
        <div class="modal-header">
            <h2><?php echo get_field('application_form_title', 'options'); ?></h2>
            <span class="close">&times;</span>
        </div>
        <?php
        if (is_user_logged_in()) {

            echo do_shortcode('[cf7form cf7key="apply" form destination-email=""]');
        } else {

            echo do_shortcode('[cf7form cf7key="apply" form destination-email=""]');
            echo do_shortcode('[login-with-ajax registration="1"]');
        }
        ?>
    </div>
</div>