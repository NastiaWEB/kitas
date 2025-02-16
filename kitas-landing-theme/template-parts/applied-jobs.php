<?php

/**
 * Template name: Applied jobs
 */

get_header();

function render_what_where()
{
    ob_start();
    ?>
    <div class="what-where">
        <h3><?php esc_html_e('You have not saved a job yet', 'kitas-landing-theme'); ?></h3>
        <p class="ww-p"><?php esc_html_e('Save jobs by clicking the bookmark on a job you like', 'kitas-landing-theme'); ?>.</p>
        <a href="http://104.131.170.77" class="link-button ww-b"><?php esc_html_e('Search jobs', 'kitas-landing-theme'); ?></a>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('what_where', 'render_what_where');

$current_tab = 'saved';
$current_url = $_SERVER['REQUEST_URI'];
$parsed_url = parse_url($_SERVER['REQUEST_URI']);
$path = $parsed_url['path'];



$current_tab = '';

$current_language = (strpos($path, '/de/') === 0) ? 'de' : 'en';

if ($current_language === 'de') {
    switch ($path) {
        case '/de/gespeicherte-jobs/':
            $current_tab = 'saved';
            break;
        case '/de/beworbene-jobs/':
            $current_tab = 'applied';
            break;
        case '/de/vorstellungsgespraeche/':
            $current_tab = 'interviews';
            break;
        case '/de/versteckte-angebote/':
            $current_tab = 'hidden-offers';
            break;
        default:
            $current_tab = 'saved';
            break;
    }

    $tabs = [
        'saved' => ['name' => 'Gespeichert', 'url' => '/de/gespeicherte-jobs'],
        'applied' => ['name' => 'Beworben', 'url' => '/de/beworbene-jobs'],
        'interviews' => ['name' => 'Vorstellungsgespräche', 'url' => '/de/vorstellungsgespraeche'],
        'hidden-offers' => ['name' => 'Versteckte Angebote', 'url' => '/de/versteckte-angebote']
    ];
} else {
    switch ($path) {
        case '/saved-jobs/':
            $current_tab = 'saved';
            break;
        case '/applied-jobs/':
            $current_tab = 'applied';
            break;
        case '/interviews/':
            $current_tab = 'interviews';
            break;
        case '/hidden-offers/':
            $current_tab = 'hidden-offers';
            break;
        default:
            $current_tab = 'saved';
            break;
    }

    $tabs = [
        'saved' => ['name' => 'Saved', 'url' => '/saved-jobs'],
        'applied' => ['name' => 'Applied', 'url' => '/applied-jobs'],
        'interviews' => ['name' => 'Interviews', 'url' => '/interviews'],
        'hidden-offers' => ['name' => 'Hidden offers', 'url' => '/hidden-offers']
    ];
}
?>

<main id="primary" class="site-main">
    <div class="main-container applied-jobs">

        <div class="select-tabs-block">
        
                <div class="select-tabs-block">
                    <?php foreach ($tabs as $id => $tabInfo): ?>
                        <?php
                        $active_class = ($id === $current_tab) ? 'active' : '';
                        $count_class = "count-$id";
                        ?>
                        <a href="<?= $tabInfo['url']; ?>" class="select-tab <?= $active_class ?>" id="<?= $id ?>">
                            <div class="select-tab-block">
                                <span class="name-tab"><?= $tabInfo['name'] ?></span>
                                <span class="count-tab <?= $count_class ?>">0</span>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
        </div>

        <hr class="hr-style">

        <div class="search-panel">
            <div class="company-search dropdown">
                <div class="prefix bold"><?php esc_html_e('What', 'kitas-landing-theme'); ?></div>
                <input type="text" class="dropbtn" placeholder="<?php esc_html_e('Job title, keyword, or company', 'kitas-landing-theme'); ?>" id="whatInput"
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
                <div class="prefix bold"><?php esc_html_e('Where', 'kitas-landing-theme'); ?></div>
                <input type="text" class="dropBtn" placeholder="<?php esc_html_e('City or ZIP code', 'kitas-landing-theme'); ?>" id="whereInput"
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
            <button class="button button-search-panel color-teal filtersConfirm" role="button" id="searchConfirm">
                <p class="button-text"><?php esc_html_e('Search', 'kitas-landing-theme'); ?></p>
            </button>
        </div>

        <div class="show-offers" id="show-offers-saved">
            <h3 class="title-for-offers"><span class="count-saved">0</span> <?php esc_html_e('saved offers', 'kitas-landing-theme'); ?></h3>

            <div id="offers-saved">
            </div>

            <div class="empty-show-offer">
                <?php echo do_shortcode('[what_where]'); ?>
            </div>
        </div>
        <div class="show-offers" id="show-offers-applied">
            <h3 class="title-for-offers"><span class="count-applied">0</span> <?php esc_html_e('applied jobs', 'kitas-landing-theme'); ?></h3>

            <div id="offers-applied">
            </div>

            <div class="empty-applied-offer">
                <?php echo do_shortcode('[what_where]'); ?>
            </div>
        </div>
        <div class="show-offers" id="show-offers-interviews">
            <h3 class="title-for-offers"> <?php esc_html_e('In development', 'kitas-landing-theme'); ?> </h3>

            <div class="empty-show-offer">
                <?php echo do_shortcode('[what_where]'); ?>
            </div>
        </div>
        <div class="show-offers" id="show-offers-hidden-offers">
            <h3 class="title-for-offers"><span class="count-hidden-offers">0</span> <?php esc_html_e('hidden jobs', 'kitas-landing-theme'); ?></h3>

            <div id="offers-hidden-offers">
            </div>

            <div class="empty-dislike-offer">
                <?php echo do_shortcode('[what_where]'); ?>
            </div>
        </div>

    </div>
</main>
<?php

get_footer();
