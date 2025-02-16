<?php

/**
 * Template name: Contact Page DE
 */

get_header(); ?>

<main id="primary" class="site-main">
    <div class="main-container">
        <div class="contact-main-block">
            <div class="half-block">

                <h2>Kontakt</h2>
                <h4>Schreiben Sie uns eine Nachricht und wir melden uns so schnell wie möglich bei Ihnen</h4>
                <?php echo do_shortcode('[cf7form cf7key="contact-form-en_copy"]'); ?>

            </div>
            <div class="half-block">
                <div class="block-maps">
                    <div class="half-block-maps">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d86478.51475398171!2d8.532167!3d47.364065!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x479aa74575ec8049%3A0xc567c3f4f9cdb369!2sChinagarten%20Z%C3%BCrich!5e0!3m2!1sen!2sus!4v1711016633831!5m2!1sen!2sus"
                            width="440" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="half-block-info">

                        <p> <span>Carejobs</span>
                        Tessinerpl. 7
                        8002 Zürich</p>

                        <p> hello@emrg.capital
                            +41445860037</p>

                        <p> <span>Geschäftszeiten</span>
                        Montag – Freitag
                            10:00 – 7:00 Uhr</p>

                    </div>

                </div>
            </div>
        </div>

    </div>
</main>

<?php
get_footer();
