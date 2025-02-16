<?php

/**
 * Template name: Registrations Page EN
 */

get_header(); ?>

<div class="br-blue">
    <main id="primary" class="site-main">
        <div class="main-container">

            <div class="header-registations">
                <span
                    class="registration-option active"><?php esc_html_e("I'm looking for a job", 'kitas-landing-theme'); ?>
                </span>
                <span class="registration-option"><?php esc_html_e("I'm hiring", 'kitas-landing-theme'); ?></span>
            </div>

            <div class="registr-blocks">
                <div class="registr-block">
                    <h1><?php esc_html_e("Welcome to Carejobs for job seekers", 'kitas-landing-theme'); ?></h1>
                    <h3><?php esc_html_e("Apply for jobs that are right for you", 'kitas-landing-theme'); ?></h3>
                </div>
                <div class="registr-block">
                    <div class="registr-block-row">
                        <div class="registr-block-row-flex">
                            <h2><?php esc_html_e("Create a profile", 'kitas-landing-theme'); ?></h2>

                            <a href="https://kinett.ch/kitas-sign-in/?loginSocial=google" data-plugin="nsl"
                                data-action="connect" data-redirect="current" data-provider="google"
                                data-popupwidth="600" data-popupheight="600">


                                <div class="link-google-auth"> <img src="/wp-content/uploads/2024/03/image-103.jpg"
                                        alt="">
                                    <span><?php esc_html_e("Continue with Google", 'kitas-landing-theme'); ?></span>


                                </div>

                            </a>

                            <?php //echo do_shortcode('[nextend_social_login provider="google" redirect="current"]'); ?>


                            <div class="container-line">
                                <div class="line"></div>
                                <div class="or"><?php esc_html_e("or", 'kitas-landing-theme'); ?></div>
                                <div class="line"></div>
                            </div>

                            <div class="login-em-pas">
                                <input type="email" id="email"
                                    placeholder="<?php esc_html_e("Email address", 'kitas-landing-theme'); ?>">
                                <input type="password" id="password"
                                    placeholder="<?php esc_html_e("Password", 'kitas-landing-theme'); ?>">
                                <span class="login-em-pas-submit"
                                    id="create-account-from-page"><?php esc_html_e("Create an account", 'kitas-landing-theme'); ?></span>
                            </div>

                            <div class="login-sign-block">
                                <p> <?php esc_html_e("Already have an account", 'kitas-landing-theme'); ?>?</p>
                                <span id="sign-in-account"><?php esc_html_e("Sign in", 'kitas-landing-theme'); ?></span>
                                <p> <?php esc_html_e("By proceeding, you agree to our Terms of use and our", 'kitas-landing-theme'); ?><br>
                                    <?php esc_html_e("Privacy policy", 'kitas-landing-theme'); ?> .
                                </p>

                            </div>

                            <div id="message"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="step-2-registr-block">
                <div class="registr-block-form">
                    <h2><?php esc_html_e("Provide contact person details", 'kitas-landing-theme'); ?></h2>
                    <form action="send-info-user" class="form-user-info">
                        <h4><?php esc_html_e("First name", 'kitas-landing-theme'); ?><span>*</span></h4>
                        <input type="text" id="first-name" name="first-name" required>

                        <h4><?php esc_html_e("Last name", 'kitas-landing-theme'); ?> <span>*</span></h4>
                        <input type="text" id="last-name" name="last-name" required>

                        <h4><?php esc_html_e("Your working email", 'kitas-landing-theme'); ?> <span>*</span></h4>
                        <input type="email" id="working-email" name="working-email" required>

                        <h4><?php esc_html_e("Your job position", 'kitas-landing-theme'); ?></h4>
                        <input type="text" id="job-title" name="job-title">

                        <h4><?php esc_html_e("Phone number", 'kitas-landing-theme'); ?></h4>
                        <input type="tel" name="phone" id="phone">
                        <!-- pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" -->

                        <button type="submit" id="submit-form"
                            title="Continue"><?php esc_html_e("Continue", 'kitas-landing-theme'); ?></button>

                    </form>
                </div>

                <div class="registr-block-info">
                    <div class="registr-block-info-title">
                        <span
                            class="info-title"><?php esc_html_e("This is how job seekers will see your personal information", 'kitas-landing-theme'); ?></span>
                        <span
                            class="info-description"><?php esc_html_e("You can hide or change your personal information anytime", 'kitas-landing-theme'); ?></span>
                    </div>
                    <div class="registr-block-info-profile">
                        <div class="registr-block-info-profile-avatar">
                            <div class="user-avatar">
                                <span class="user-avatar-firstname">Y</span>
                                <span class="user-avatar-lastname">N</span>
                            </div>
                        </div>
                        <div class="registr-block-info-profile-fields">
                            <h4 class="first-last-name"><?php esc_html_e("Your Name", 'kitas-landing-theme'); ?></h4>
                            <p class="your-job-title"><?php esc_html_e("Your job title", 'kitas-landing-theme'); ?>
                            </p>
                            <div class="registr-block-info-profile-fields-plus">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/email.svg" alt="email">
                                <p class="your-email"> your.email@example.com</p>
                            </div>
                            <div class="registr-block-info-profile-fields-plus"> <img
                                    src="<?php echo get_template_directory_uri(); ?>/img/phone.svg" alt="phone">
                                <p class="your-phone">+1111111111111111</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="step-3-registr-block">

                <div class="step-3-info-block">
                    <h2><?php esc_html_e("Set up a company profile", 'kitas-landing-theme'); ?></h2>

                    <form action="send-info-company" class="form-user-company">
                        <h4><?php esc_html_e("Company name", 'kitas-landing-theme'); ?><span>*</span></h4>
                        <input type="text" id="company-name" name="company-name" required>

                        <h4><?php esc_html_e("Location", 'kitas-landing-theme'); ?> <span>*</span></h4>
                        <div class="form-block-half">
                            <div class="form-block-half-child">
                                <?php
                                wp_dropdown_categories(
                                    array(
                                        'taxonomy' => 'location',
                                        'name' => 'job_category',
                                        'orderby' => 'name',
                                        'show_option_none' => esc_html_e("Location", 'kitas-landing-theme'),
                                        'selected' => (isset($_POST['job_category']) ? $_POST['job_category'] : ''),
                                        'hide_empty' => false,
                                    )
                                );
                                ?>
                            </div>
                            <div class="form-block-half-child">
                                <input type="text" id="company-city" name="company-city"
                                    placeholder="<?php esc_html_e("City", 'kitas-landing-theme'); ?>">
                            </div>
                            <div class="form-three-colum">
                                <div class="form-block-tt-child">
                                    <input type="text" id="street-and-building" name="street-and-building"
                                        placeholder="<?php esc_html_e("Street and building", 'kitas-landing-theme'); ?>">
                                </div>
                                <div class="form-block-tt-child">
                                    <input type="text" id="building" name="building"
                                        placeholder="<?php esc_html_e("Building", 'kitas-landing-theme'); ?>">
                                </div>
                                <div class="form-block-tt-child">
                                    <input type="text" id="zip-code" name="zip-code"
                                        placeholder="<?php esc_html_e("Zip code", 'kitas-landing-theme'); ?>">
                                </div>
                            </div>


                        </div>

                        <h4> <?php esc_html_e("Company size", 'kitas-landing-theme'); ?><span>*</span></h4>
                        <div class="form-block-half">
                            <div class="form-block-half-child">
                                <input type="number" id="number-of-team-members" name="number-of-team-members"
                                    placeholder="<?php esc_html_e("Number of team members", 'kitas-landing-theme'); ?>">
                            </div>
                            <div class="form-block-half-child">
                                <input type="number" id="number-of-childcare-place" name="number-of-childcare-places"
                                    placeholder="<?php esc_html_e("Number of childcare places", 'kitas-landing-theme'); ?>">
                            </div>
                        </div>

                        <h4><?php esc_html_e("Company website", 'kitas-landing-theme'); ?></h4>
                        <div class="form-block-half">
                            <div class="form-block-half-child">
                                <input type="text" id="company-website" name="company-website"
                                    placeholder="<?php esc_html_e("Company website", 'kitas-landing-theme'); ?>">
                            </div>
                            <div class="form-block-half-child">
                                <button type="submit" id="submit-form-registr-user"
                                    title="Continue"><?php esc_html_e("Continue with Google", 'kitas-landing-theme'); ?></button>
                            </div>
                        </div>



                    </form>
                </div>

            </div>


        </div>
    </main>

</div>


<?php

get_footer();
