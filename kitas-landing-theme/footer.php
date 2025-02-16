<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Kitas_Landing_Theme
 */

 
 $url = $_SERVER['REQUEST_URI'];
 $lang = 'en-US';

 if (str_contains($url, '/de')) {
     $lang = 'de-DE';
 }



?>

<!-- Applied window -->
<div class="applied-window <?php echo $lang; ?>">
    <div class="applied-window-content">
        <img src="/wp-content/themes/kitas-landing-theme/img/check_ring.png" alt="">
        <div class="applied-window-content-text">
            <h4><?php esc_html_e('Applied', 'kitas-landing-theme'); ?></h4>
            <p><?php esc_html_e('You have applied for a job successfully', 'kitas-landing-theme'); ?></p>
        </div>
        <span class="close-applied-window"></span>
    </div>
</div>

<footer>
    <div class="main-container">
        <!-- <?php the_custom_logo(); ?> -->
        <div class="logo_title">
            <a href="<?php echo home_url(); ?>">Carejobs</a>
        </div>
        <div class="footer-content">
            <div class="footer-address-hours">
                <div class="footer-address">
                    <p>Tessinerpl. 7 <br>8002 Zurich</p>

                    <p class="mt-c">hello@emrg.capital <br>+41445860037</p>
                </div>
                <div class="footer-hours">
                    <p class="business-hours">Business hours:</p>
                    <p>Monday - Friday</p>
                    <p>10.00 - 19.00</p>
                </div>
            </div>

            <div class="menu-colum-three-right-custom-for-footer">
                <div class="footer-content-menu-section">
                    <ul class="footer-content-menu-list">
                        <?php wp_nav_menu(array('theme_location' => 'footer-menu-1', 'container_class' => 'header-menu-2-class')); ?>
                    </ul>
                </div>
                <div class="footer-content-menu-section">
                    <ul class="footer-content-menu-list">
                        <?php wp_nav_menu(array('theme_location' => 'footer-menu-2', 'container_class' => 'header-menu-2-class')); ?>
                    </ul>
                </div>
                <div class="footer-content-menu-section">
                    <ul class="footer-content-menu-list">
                        <?php wp_nav_menu(array('theme_location' => 'footer-menu-3', 'container_class' => 'header-menu-2-class')); ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="copyright">
                <p>Copyright
                    <script>document.write(new Date().getFullYear())</script> | EMRG Capital
                </p>
            </div>
            <div class="follow">
                <p>Follow us on</p>
                <img src="/wp-content/uploads/2024/01/image-4.png" alt="social">
            </div>
        </div>
    </div>
</footer><!-- #colophon -->
</div><!-- #page -->

<!-- Form - Send CV -->

<?php
echo '<div class="custom-login-in-ajax-form-true">';
echo do_shortcode('[custom_cv_form]');
echo '</div>';
if (!is_user_logged_in()) {
    echo '<div class="custom-login-in-ajax-form-false" style="display: none;">';
    echo '<div class="custom_cv_form_shortcode_block" style="display: none;">';
    echo do_shortcode('[login_block_registration]');
    echo '</div>';
    echo '</div>';
}

wp_footer(); ?>

<div class="lds-dual-ring"></div>

</body>

</html>