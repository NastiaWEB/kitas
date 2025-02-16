<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Kitas_Landing_Theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#primary">
            <?php esc_html_e('Skip to content', 'kitas-landing-theme'); ?>
        </a>
        <header class="kitas-site-header">
            <div class="main-container">
                <div class="header-content">
                    <div class="header-content-logo">
                        <!-- <?php the_custom_logo(); ?> -->
                      <div class="logo_title">
                        <a href="<?php echo home_url(); ?>"><?php esc_html_e('Carejobs', 'kitas-landing-theme'); ?></a>
                      </div>
                    </div>
                    <div class="header-content-menu" id="menu">
                        <div class="header-content-menu-left">
                            <ul class="header-content-menu-list">
                                <?php wp_nav_menu(array('theme_location' => 'menu-1', 'container_class' => 'header-menu-2-class')); ?>
                            </ul>
                        </div>
                        <div class="header-content-menu-right">
                            <ul class="header-content-menu-list">
                              <?php if (is_user_logged_in()) { wp_nav_menu(array('theme_location' => 'header-menu-3', 'container_class' => 'header-menu-login-class'));  } ?>

                                <div id="menu-container">
                                    <?php
                                    if (is_user_logged_in()) {
                                      $current_user = wp_get_current_user();
                                      $first_name = $current_user->first_name;
                                      $last_name = $current_user->last_name;
                                      $user_email = $current_user->user_email;
                                      $roles = $current_user->roles;
                                      ?>
                                        <div class="user-header-menu-wrapper">
                                          <a href="#" class="user-header-menu-icon">
                                            <img style="display:none;" src="/wp-content/themes/kitas-landing-theme/img/user_icon.svg" alt="">
                                            <img style="display:none;" src="/wp-content/themes/kitas-landing-theme/img/active_user_icon.svg" alt="">
                                          </a>
                                          <div class="menu-header-hide">
                                            <div class="flex-container-header_menu">
                                              <div class="header-avatar-title">
                                                <span class="user_name"><?= $first_name . ' ' . $last_name; ?> </span>
                                                <span class="user_email"><?= $user_email; ?> </span>
                                                <?php
                                                 if (in_array("company", $roles)) {
                                                  ?>  <button class="user_menu_btn">  <?php esc_html_e('Post a job', 'kitas-landing-theme'); ?></button> <?php
                                                 }else {
                                                  ?>  <a href="/my-profile/" class="user_menu_btn"> <?php esc_html_e('Upload resume', 'kitas-landing-theme'); ?> </a> <?php
                                                  } ?>

                                              </div>
                                              <hr>
                                              <div class="header-link-menu">
                                              <?php
                                               if (in_array("company", $roles)) {
                                                  wp_nav_menu(array('theme_location' => 'header-menu-hidden-company'));
                                               }else {
                                                  wp_nav_menu(array('theme_location' => 'header-menu-hidden-user'));
                                                } ?>
                                                <a href="#" class="header-signout-button" title="Sign-out"><img src="/wp-content/themes/kitas-landing-theme/img/signout.svg" alt="">Sign out</a>
                                              </div>
                                              <hr>
                                              <a href="#"><?php esc_html_e('Support', 'kitas-landing-theme'); ?></a>
                                            </div>
                                          </div>
                                        </div>
                                        <?php



                                    } else {
                                        // wp_nav_menu(array('theme_location' => 'header-menu-3', 'container_class' => 'header-menu-login-class'));
                                        wp_nav_menu(array('theme_location' => 'header-menu-2', 'container_class' => 'header-menu-2-class'));
                                    }
                                    ?>
                                </div>
<!--
                                <div class="menu-header-hide">

                                    <?php
                                    if (is_user_logged_in()) {
                                      $current_user = wp_get_current_user();
                                      $first_name = $current_user->first_name;
                                      $last_name = $current_user->last_name;
                                      $user_email = $current_user->user_email;

                                      echo $first_name . ' ' . $last_name;
                                      echo '<br>';
                                      echo $user_email;
                                      echo '<br>';
                                      echo '<span id="upload-resume-in-account" class="user_menu_btn">Upload resume</span>';

                                      wp_nav_menu(array('theme_location' => 'header-menu-4', 'container_class' => 'hide-menu-class'));
                                    }
                                    ?>
                                </div> -->
                            </ul>
                        </div>
                    </div>
                    <div class="hamburger-menu" onclick="toggleMenu()">
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                    </div>
                </div>
            </div>
        </header><!-- #masthead -->
