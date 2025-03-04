<?php

function login_block_registration_shortcode()
{
    ?>
    <div class="registr-block" style="width: 100%;">
        <div class="registr-block-row" id="registr-form">
            <div class="registr-block-row-flex">
                <h2>Create a profile</h2>

                <div class="link-google-auth"> <img src="/wp-content/uploads/2024/03/image-103.jpg" alt="">
                    <span>Continue with Google</span>
                </div>

                <div class="container-line">
                    <div class="line"></div>
                    <div class="or">or</div>
                    <div class="line"></div>
                </div>

                <div class="login-em-pas">
                    <input type="text" id="fullname" placeholder="Full name">
                    <input type="email" id="email" placeholder="Email address">
                    <input type="password" id="password" placeholder="Password">
                    <span class="login-em-pas-submit" id="button-create-an-account">Create an account</span>
                </div>

                <div class="login-sign-block">
                    <p>Already have an account? </p>
                    <span class="button-sign-in" id="block-sign-in">Sign in</span>
                    <p>By proceeding, you agree to our Terms of use and our <br> Privacy policy.
                    </p>

                </div>

                <div id="message"></div>
            </div>
        </div>

        <div class="registr-block-row" id="login-form" style="display: none;">
            <div class="registr-block-row-flex">
                <h2>Sign in</h2>

                <div class="link-google-auth"> <img src="/wp-content/uploads/2024/03/image-103.jpg" alt="">
                    <span>Continue with Google</span>
                </div>

                <div class="container-line">
                    <div class="line"></div>
                    <div class="or">or</div>
                    <div class="line"></div>
                </div>

                <div class="login-em-pas">
                    <input type="email" id="email" placeholder="Email address">
                    <input type="password" id="password" placeholder="Password">
                    <span class="button-sign-in" id="sign-in-account">Sign in</span>
                </div>

                <div class="login-sign-block">
                    <p>No account yet? </p>
                    <span class="block-create-an-account" id="button-create-an-account">Create an account</span>
                    <p>By proceeding, you agree to our Terms of use and our <br> Privacy policy.
                    </p>

                </div>

                <div id="message"></div>
            </div>
        </div>
    </div>

    <?php
}

add_shortcode('login_block_registration', 'login_block_registration_shortcode');


