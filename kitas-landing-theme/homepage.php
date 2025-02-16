<?php
/**
 * Template name: Homepage
 */

get_header();
?>
<?php
//getting all the query vars
$current_locale = isset($_GET['current_locale']) ? $_GET['current_locale'] : 'en';
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
?>
<main id="primary" class="site-main">
    <div class="main-container">
        <div class="main-content">
            <div class="search-panel">
                <div class="company-search dropdown">
                    <div class="prefix bold">What</div>
                    <input type="text" class="dropbtn" placeholder="Job title, keyword, or company" id="whatInput"
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
                    <div class="prefix bold">Where</div>
                    <input type="text" class="dropBtn" placeholder="City or ZIP code" id="whereInput"
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
                                    echo '<a id="" href="">';
                                    echo $loc->name . ' <span class="hintCaption"> - ' . $loc->slug . '</span>';
                                    echo '</a>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="button button-search-panel color-teal filtersConfirm" role="button" id="searchConfirm">
                    <p class="button-text">Search</p>
                </button>
            </div>

            <div class="filters">
                <ul class="filters-list">
                    <li class="hidden-list"><a href="#" aria-haspopup="true">Category
                            <div class="caret"></div>
                        </a>
                        <ul class="dropdown-wrapper" aria-label="category">
                            <li>
                                <div class="filter-dropdown">
                                    <?php
                                    $cats = get_terms([
                                        'post_type' => 'job-offer',
                                        'taxonomy' => 'job_category',
                                        'hide_empty' => false,
                                    ]);
                                    $cats_left = array_slice($cats, 0, 8);
                                    $cats_right = array_slice($cats, 8);
                                    ?>
                                    <div class="filter-job cat-filter-left">
                                        <?php
                                        foreach ($cats_left as $cat) {
                                            ?>
                                            <label class="filter-job-container label-container">
                                                <p class="item-title" data-term="<?php echo $cat->slug; ?>">
                                                    <?php
                                                    echo $cat->name;
                                                    ?>
                                                </p>
                                                <div class="filter-tag tag-filled">
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
                                            <label class="filter-job-container label-container">
                                                <p class="item-title" data-term="<?php echo $cat->slug ?>">
                                                    <?php
                                                    echo $cat->name;
                                                    ?>
                                                </p>
                                                <div class="filter-tag tag-filled">
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
                                <button class="filtersConfirm" id="catConfirm">
                                    <?php echo the_field('apply_filter_button_title', 'options'); ?>
                                </button>
                            </li>
                        </ul>
                    </li>

                    <li id="employmentDropdown"><a href="#" aria-haspopup="true">
                            <?php echo the_field('employment_type_filter_title', 'options'); ?>
                            <div class="caret"></div>
                        </a>
                        <ul class="dropdown-wrapper" aria-label="employment-type">
                            <li>
                                <div class="filter-dropdown">
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
                                                <p class="item-title" data-term="<?php echo $type->slug ?>">
                                                    <?php
                                                    echo $type->name;
                                                    ?>
                                                </p>
                                                <div class="filter-tag tag-filled">
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

                                        <button class="filtersConfirm" id="employmentTypeConfirm">
                                            <?php echo the_field('apply_filter_button_title', 'options'); ?>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li><a href="#" aria-haspopup="true">Location
                            <div class="caret"></div>
                        </a>
                        <ul class="dropdown-wrapper" aria-label="location">
                            <li>
                                <div class="filter-dropdown">
                                    <div class="filter-job">
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
                                            ?>
                                            <label class="filter-job-container label-container">
                                                <p class="item-title" data-term="<?php echo $loc->slug ?>">
                                                    <?php echo $loc->name; ?>
                                                </p>
                                                <div class="filter-tag tag-filled">
                                                    <?php echo $loc->count; ?>
                                                </div>
                                                <input type="checkbox" <?php if (str_contains($search_where, $loc->slug)) {
                                                    echo 'checked';
                                                } ?>>
                                                <span class="checkmark"></span>
                                            </label>
                                            <?php
                                            $children = get_term_children($loc->term_id, 'location');
                                            if (count($children) > 0) {
                                                foreach ($children as $child) {
                                                    $term = get_term_by('id', $child, 'location');
                                                    ?>
                                                    <label class="filter-job-container label-container child-container">
                                                        <p class="item-title" data-term="<?php echo $term->slug ?>">
                                                            <?php echo $term->name; ?>
                                                        </p>
                                                        <div class="filter-tag tag-filled">
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
                                            <?php
                                        }
                                        ?>
                                        <button class="filtersConfirm" id="locationsConfirm">
                                            <?php echo the_field('apply_filter_button_title', 'options'); ?>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li><a href="#" aria-haspopup="true">
                            <?php echo the_field('start_after_filter_title', 'options'); ?>
                            <div class="caret"></div>

                        </a>
                        <ul class="dropdown-wrapper" aria-label="startsafter">
                            <li>
                                <div class="filter-dropdown">
                                    <div class="filter-job">
                                        <?php echo '<input id="startDate" class="form-control" type="date" placeholder="Starts after: " min="1970-01-01" />'; ?>
                                        <button class="filtersConfirm" id="startsAfterConfirm">
                                            <?php echo the_field('apply_filter_button_title', 'options'); ?>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>


                    <li><a href="#" aria-haspopup="true">
                            <?php echo the_field('language_filter_title', 'options'); ?>
                            <div class="caret"></div>
                        </a>
                        <ul class="dropdown-wrapper" aria-label="language">
                            <li>
                                <div class="filter-dropdown">
                                    <div class="filter-job">
                                        <?php
                                        $languages = get_terms([
                                            'post_type' => 'job-offer',
                                            'taxonomy' => 'offer_language',
                                            'hide_empty' => false,
                                        ]);

                                        foreach ($languages as $lang) {
                                            ?>
                                            <label class="filter-job-container label-container">
                                                <p class="item-title" data-term="<?php echo $lang->slug ?>">
                                                    <?php
                                                    echo $lang->name;
                                                    ?>
                                                </p>
                                                <div class="filter-tag tag-filled">
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
                                        <button class="filtersConfirm" id="langConfirm">
                                            <?php echo the_field('apply_filter_button_title', 'options'); ?>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li><a href="#" aria-haspopup="true">
                            <?php echo the_field('time_posted_filter_title', 'options'); ?>
                            <div class="caret"></div>
                        </a>
                        <ul class="dropdown-wrapper" aria-label="time-posted">
                            <li>
                                <div class="filter-dropdown">
                                    <div class="filter-job">
                                        <label class="filter-job-container label-container">
                                            <p class="item-title lastDay">
                                                <?php echo the_field('posted_in_last_24_hours', 'options'); ?>
                                            </p>
                                            <input type="checkbox" id="lastDayFilter" <?php if (str_contains($selected_period, 'after-1-day-ago')) {
                                                echo 'checked';
                                            } ?>>
                                            <span class="checkmark"></span>
                                        </label>

                                        <label class="label-container">
                                            <p class="item-title lastWeek">
                                                <?php echo the_field('posted_in_last_week', 'options'); ?>
                                            </p>
                                            <input type="checkbox" id="lastWeekFilter" <?php if (str_contains($selected_period, 'after-1-week-ago')) {
                                                echo 'checked';
                                            } ?>>
                                            <span class="checkmark"></span>
                                        </label>

                                        <label class="label-container">
                                            <p class="item-title moreThanWeek">
                                                <?php echo the_field('posted_more_than_a_week_ago', 'options'); ?>
                                            </p>
                                            <input type="checkbox" id="moreThanWeekFilter" <?php if (str_contains($selected_period, 'before-1-week-ago')) {
                                                echo 'checked';
                                            } ?>>
                                            <span class="checkmark"></span>
                                        </label>
                                        <button class="filtersConfirm" id="dateOfPostConfirm">
                                            <?php echo the_field('apply_filter_button_title', 'options'); ?>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li><a href="#" aria-haspopup="true">
                            <?php echo the_field('workload_filter_title', 'options'); ?>
                            <div class="caret"></div>
                        </a>
                        <ul class="dropdown-wrapper dropdown-end" aria-label="workload">
                            <li>
                                <div class="filter-dropdown">
                                    <div class="filter-job">
                                        <p>
                                            <label for="amount">Workload:</label>
                                            <input type="text" id="amount" readonly
                                                style="border:0; color:blue; font-weight:bold;">
                                        </p>

                                        <div id="slider-range"></div>
                                        <button class="filtersConfirm" id="workloadConfirm">
                                            <?php echo the_field('apply_filter_button_title', 'options'); ?>
                                        </button>
                                    </div>

                                </div>
                            </li>

                        </ul>
                    </li>

                </ul>


                <div id="sortList">
                    <span class="sort-title-sort-more">Sort by Most recent </span>
                    <div class="dropdown-sort-most">
                        <div class="dropdown-content-sort-most">
                            <a href="#" id="sort-most-recent">Most recent</a>
                            <a href="#" id="sort-earliest-start-date">Earliest start date</a>
                            <!-- <a href="#" id="sort-top-rated">Top-rated</a> -->
                        </div>

                    </div>
                </div>


            </div>
            <div id="postFilters">
                <div class="job-card-tags">
                </div>
            </div>
            <img id="preloader" src="<?php echo get_template_directory_uri() . '/img/Spinning arrows.gif'; ?>">
            <div id="jobsList">
                <!--Getting only needed posts on load -->
                <?php
                //default array with args
                $orderBy = '';
                $metaKey = '';
                $paged = isset($_GET['currentPage']) ? $_GET['currentPage'] : '';
                if (isset($_POST['orderby'])) {
                switch ($_POST['orderby']) {
                    case 'sort-most-recent':
                        $orderBy = 'date';
                        break;
                    case 'sort-earliest-start-date':
                        $orderBy = 'meta_value_num';
                        $metaKey = 'work_start_time';
                        break;
                    default:
                        $orderBy = 'date';
                        break;
                }
            }

                $args = array(
                    'posts_per_page' => 2,
                    'search_name' => $search_name, //query var
                    'paged' => $paged, //query var
                    'orderby' => $orderBy,
                    'order' => $order,
                    'meta_query' => array(
                        'relation' => 'AND',
                    ),
                    'tax_query' => array(
                        'relation' => 'AND',
                    ),
                    'date_query' => array(
                        'relation' => 'OR',
                    ),
                    'post_type' => 'job-offer',
                    'lang' => $current_locale, //query var
                    'suppress_filters' => false,
                );

                if (!empty($metaKey)) {
                    $args['meta_key'] = $metaKey;
                    $args['meta_type'] = 'TIME';
                }




                //checking if location from search bar exists
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

                //filter by type on load
                if (strlen($selected_type) > 0) {
                    $selected_type = explode('|', $selected_type);
                    $type_filter = array(
                        'taxonomy' => 'employment-type',
                        'field' => 'slug',
                        'terms' => $selected_type
                    );
                    array_push($args['tax_query'], $type_filter);
                }

                //filter by category on load
                if (strlen($categories) > 0) {
                    $categories = explode('|', $categories);
                    $cat_filter = array(
                        'taxonomy' => 'job_category',
                        'field' => 'slug',
                        'terms' => $categories
                    );
                    array_push($args['tax_query'], $cat_filter);
                }

                //filter by date on load
                if (strlen($selected_date) > 0) {
                    $date_filter = array(
                        'key' => 'starts_on',
                        'compare' => '>',
                        'value' => $selected_date,
                        'type' => 'DATETIME',
                    );
                    array_push($args['meta_query'], $date_filter);
                }

                //filter by lang on load
                if (strlen($selected_langs) > 0) {
                    $selected_langs = explode('|', $selected_langs);
                    $lang_filter = array(
                        'taxonomy' => 'offer_language',
                        'field' => 'slug',
                        'terms' => $selected_langs
                    );
                    array_push($args['tax_query'], $lang_filter);
                }

                //filter by loc on load
                if (strlen($search_where) > 0) {
                    $search_where = explode('|', $search_where);
                    $loc_filter = array(
                        'taxonomy' => 'location',
                        'field' => 'slug',
                        'terms' => $search_where
                    );
                    array_push($args['tax_query'], $loc_filter);
                }

                //filter by workload on page load
                if (strlen($min_load) > 0) {
                    $minload_filter = array(
                        'key' => 'workload',
                        'compare' => '>=',
                        'value' => intval($min_load),
                        'type' => 'NUMERIC'
                    );
                    array_push($args['meta_query'], $minload_filter);
                }

                if (strlen($max_load) > 0) {
                    $maxload_filter = array(
                        'key' => 'max_workload',
                        'compare' => '<=',
                        'value' => intval($max_load),
                        'type' => 'NUMERIC'
                    );
                    array_push($args['meta_query'], $maxload_filter);
                }

                //filter by time of post on load
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

                //filter by author on load
                if ($search_by == 'company') {
                    $args['author_name'] = $search_name;
                }


                //getting filtered offers and applying search term
                if ($search_by == 'job' || $search_by == '') {
                    add_filter('posts_where', 'search_by_name', 10);
                }

                $query = new WP_Query($args);
                if ($search_by == 'job' || $search_by == '') {
                    remove_filter('posts_where', 'search_by_name', 10);
                }

                //pagination links
                $pagination = paginate_links(
                    array(
                        'base' => home_url('/%_%'),
                        'format' => 'page/%#%',
                        'current' => max(1, $paged),
                        'total' => $query->max_num_pages,
                        'add_args' => $args
                    )
                );
                $pagination = str_replace('<a class="prev page-numbers"', '<a class="prev page-numbers" data-paged="prev"', $pagination);
                $pagination = str_replace('<a class="next page-numbers"', '<a class="prev page-numbers" data-paged="next"', $pagination);

                //setting query var so we can pass offers list into template part
                $data = array(
                    'query' => $query,
                    'pages' => $pagination
                );
                set_query_var('data', $data);

                //posts loop output
                if ($paged > $query->max_num_pages) {
                    echo '<h1 class="noMore">No more jobs!</h1>';
                } else {
                    get_template_part('template-parts/offers-loop', null, $data);
                    echo '<div class="pagination-links">' . $pagination . '</div>';
                }

                ?>
            </div>
            <div class="load-more">
                <button class="button color-teal" role="button">Load more</button>
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
            <h2>
                <?php echo get_field('application_form_title', 'options'); ?>
            </h2>
            <span class="close">&times;</span>
        </div>
        <?php
        if (is_user_logged_in()) {
            echo do_shortcode('[cf7form cf7key="apply" form destination-email=""]');
        } else {
            echo do_shortcode('[login-with-ajax registration="1"]');
        }
        ?>
    </div>
</div>
