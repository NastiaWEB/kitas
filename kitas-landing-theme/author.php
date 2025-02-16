<?php
// Set the Current Author Variable $curauth
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));

$user_id = get_the_author_meta('ID');
$zip_code_company = get_field('zip_code', 'user_' . $user_id);
$address_profile_company = get_field('address_profile', 'user_' . $user_id);
$address_street_company = get_field('address_street', 'user_' . $user_id);
$building_company = get_field('building', 'user_' . $user_id);

$url = $_SERVER['REQUEST_URI'];
$lang = 'en';

if (str_contains($url, '/de')) {
    $lang = 'de';
}


get_header();
?>
<main data-author-id="<?php echo get_the_author_meta('ID'); ?>">

    <div class="main-container">
        <div class="main-content">

            <div class="main-content-floating-block">
                <div class="image-container-logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/image.png" alt="">
                    <?php
                    if ($curauth->verified) {
                        echo ' <img class="verification-icon" src="' . get_template_directory_uri() . '/img/verified.svg" alt="verified">';
                    }
                    ?>
                </div>

                <div class="company-page-verified-company">
                    <div class="company-page-name">
                        <p><?php echo $curauth->display_name; ?></p>
                    </div>

                    <div class="company-page-adress">
                        <p><?php
                        // if ($lang == 'en') {
                        //     echo $curauth->address_profile;
                        // } else {
                        //     echo $curauth->address_profile_de;
                        // }
                        ?>
                        <a href="https://maps.google.com/?q=<?php echo $zip_code_company . " " . $address_profile_company . " " . $address_street_company . " " . $building_company  ?>" target="_blank"> 
                            <?php echo $zip_code_company . " " . $address_profile_company . " " . $address_street_company . " " . $building_company  ?>
                        </a>
                    </p>
                    </div>

                    <div class="rating">
                        <p class="rating-number">3.8</p>
                        <div class="rating-star filled"></div>
                        <div class="rating-star filled"></div>
                        <div class="rating-star filled"></div>
                        <div class="rating-star filled"></div>
                        <div class="rating-star"></div>
                        <div class="click-rate"><?php echo the_field('click_to_rate_btn', 'options'); ?></div>
                    </div>

                </div>
            </div>

            <div class="reviews-menu">
                <div class="button button-review color-teal-grey button-text">
                    <div class="button-content"><?php echo the_field('write_a_review_btn', 'options'); ?></div>
                </div>

                <div class="reviews-menu-container">
                    <div class="reviews-menu-tab">
                        <a class="text-link" href="#overview"><?php echo the_field('overview_anchor', 'options'); ?></a>
                    </div>

                    <div class="reviews-menu-tab-and-quantity">
                        <div class="reviews-menu-tab"><a class="text-link" href="#jobs">Jobs</a></div>
                        <div class="reviews-quantity">
                            <?php
                            $args = array(
                                    'post_type' => 'job-offer',
                                    'author' => $user_id,
                                    'lang' => $lang,
                                    'posts_per_page' => -1
                                );
                                $offers = get_posts($args);
                                echo count($offers);
                            ?>
                        </div>
                    </div>

                    <div class="reviews-menu-tab-and-quantity">
                        <div class="reviews-menu-tab"><a class="text-link"
                                href="#reviews"><?php echo the_field('reviews_anchor', 'options'); ?></a></div>
                        <div class="reviews-quantity"></div>
                    </div>

                    <div class="reviews-menu-tab-and-quantity">
                        <div class="reviews-menu-tab"><a class="text-link"
                                href="#q&a"><?php echo the_field('q_and_a_anchor', 'options'); ?></a></div>
                        <div class="reviews-quantity"></div>
                    </div>

                    <div class="reviews-menu-tab-and-quantity">
                        <div class="reviews-menu-tab"><a class="text-link"
                                href="#photos"><?php echo the_field('photos_anchor', 'options'); ?></a></div>
                        <div class="reviews-quantity"><?php
                        $images = get_field('company_page_gallery');
                        if ($images) {
                            echo count($images);
                        }
                        ?></div>
                    </div>
                </div>
            </div>

            <h2 id="overview"><?php echo the_field('company_info_block_title', 'options'); ?></h2>
            <div class="company-profile-block">
                <div class="company-about-block">
                    <div class="company-about-block-base-info">
                        <div class="base-info-work-details">
                            <div class="work-details">
                                <?php
                                if ($lang == 'en') {
                                    echo 'Website';
                                } else {
                                    echo 'Webseite';
                                }
                                ?>
                            </div>
                            <div class="work-details">
                                <?php
                                if ($lang == 'en') {
                                    $size = get_field_object('company_size_profile');

                                    echo $size["label"];
                                } else {
                                    $size = get_field_object('company_size_profile_de');

                                    echo $size["label"];
                                }
                                ?>
                            </div>
                            <div class="work-details">
                                <?php
                                if ($lang == 'en') {
                                    $shifts = get_field_object('work_shifts_and_holidays_profile');

                                    echo $shifts["label"];
                                } else {
                                    $shifts = get_field_object('work_shifts_and_holidays_profile_de');

                                    echo $shifts["label"];
                                }
                                ?>
                            </div>
                        </div>
                        <div class="base-info-key-info">
                            <div class="key-info"><?php echo $curauth->user_url; ?></div>
                            <div class="key-info"><?php
                            if ($lang == 'en') {
                                echo $curauth->company_size_profile;
                            } else {
                                echo $curauth->company_size_profile_de;
                            }
                            ?></div>
                            <div class="key-info"><?php
                            if ($lang == 'en') {
                                echo $curauth->work_shifts_and_holidays_profile;
                            } else {
                                echo $curauth->work_shifts_and_holidays_profile_de;
                            }
                            ?></div>
                        </div>
                    </div>

                    <div class="company-about-description">
                        <h5>
                            <?php
                            if ($lang == 'en') {
                                $approach = get_field_object('teaching_approach_profile');

                                echo $approach["label"];
                            } else {
                                $approach = get_field_object('teaching_approach_profile_de');

                                echo $approach["label"];
                            }
                            ?>
                        </h5>
                        <p class="description-text"><?php
                        if ($lang == 'en') {
                            echo $curauth->teaching_approach_profile;
                        } else {
                            echo $curauth->teaching_approach_profile_de;
                        }
                        ?></p>
                    </div>
                </div>
                <div class="company-about-map">
                    <?php
                    if ($curauth->google_maps_embed_url) {
                        ?>
                        <iframe src="<?php
                        if ($lang == 'en') {
                            echo $curauth->google_maps_embed_url;
                        } else {
                            echo $curauth->google_maps_embed_url_de;
                        }
                        ?>" width="510" height="288" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                    }
                    ?>
                </div>

            </div>

            <h2 id="jobs"><?php echo the_field('jobs_block_title', 'options') . ' ' . $curauth->display_name; ?></h2>
            <div>
                <?php  
                    get_template_part('template-parts/author-offers-loop');
                ?>
            </div>

            <h2><?php echo the_field('photo_gallery_block_title', 'options'); ?></h2>
            <div class="photo-gallery" id="photos">
                <?php $images = get_field('company_page_gallery', 'user_' . $curauth->ID); ?>
                <div class="photo-gallery-big-image">
                    <?php
                    if ($images) {
                        echo '<img class="" src="' . $images[0] . '">';
                        unset($images[0]);
                        ?>
                    </div>
                    <div class="photo-gallery-small-images">
                        <?php
                        foreach ($images as $image) {
                            echo '<div class="small-image"><img class="" src="' . $image . '"></div>';
                        }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
?>