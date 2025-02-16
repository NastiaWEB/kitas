<?php
/**
 * Template name: Featured jobs
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="main-container">
        <div class="main-content">
            <div id="postFilters">
                <div class="job-card-tags">
                </div>
            </div>
            <img id="preloader" src="<?php echo get_template_directory_uri() . '/img/Spinning arrows.gif'; ?>">
            <div id="jobsList">

            

                <?php
                
                $current_locale = isset($_GET['current_locale']) ? $_GET['current_locale'] : 'en';
                $args = array(
                    'post_type' => 'job-offer',
                    'posts_per_page' => -1,
                    'lang' => $current_locale,
                    'suppress_filters' => false,
                );
                $query = new WP_Query($args);

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

                //Checking if there are any featured jobs
                $has_active_featured_jobs = false;
                while ($query->have_posts()) {
                    $query->the_post();
                    if (has_term('active', 'featuredToggle')) {
                        $has_active_featured_jobs = true;
                        break;
                    }
                }
                wp_reset_postdata();

                //If there are no featured jobs, display message
                if (!$has_active_featured_jobs) {

                    ?>
                    <div class="what-where">
                        <div class="search-panel">
                            <div class="company-search dropdown">
                                <div class="prefix bold">What</div>
                                <input type="text" class="dropbtn" placeholder="Job title, keyword, or company"
                                    id="whatInput" autocomplete="one-time-code">
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
                                                $post_count = get_term($loc->term_id, 'location')->count;
                                                echo '<a id="" href="">';
                                                echo $loc->name . ' <span class="hintCaption"> - ' . $loc->slug . ' (' . $post_count . ')</span>';
                                                echo '</a>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="button button-search-panel color-teal filtersConfirm" role="button"
                                id="searchConfirm">
                                
                                <a href="<?php echo get_home_url(); ?>" class="button-text">Search</a>
                            </button>

                           
                        </div>

                        <h3>You have not saved a job yet</h3>

                        <p class="ww-p">Save jobs by clicking the bookmark on a job you like.</p>


                       
                           <a href="<?php echo get_home_url(); ?>" class="link-button ww-b">Search jobs</a>
                 

                    </div>

                    <?php
                } else {
                    if ($paged > $query->max_num_pages) {
                        echo '<h1 class="noMore">No more jobs!</h1>';
                    } else {
                        get_template_part('template-parts/offers-loop', null, $data);
                        echo '<div class="pagination-links">' . $pagination . '</div>';
                    }
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