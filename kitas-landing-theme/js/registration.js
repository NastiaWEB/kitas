$(document).ready(function () {

    //ajax for create user modal registration
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('login-em-pas-submit')) {

            $('#registr-form .login-em-pas input').on('input', function () {
                if ($(this).val().trim() !== '') {
                    $(this).css('border', '1px solid #A3B4BC');
                } else {
                    $(this).css('border', '1px solid red');
                }
            });


            $('#registr-form').on('click', '.login-em-pas-submit', function (event) {
                let isValid = true;
                let fullName = $('#fullname').val();
                let email = $('#email').val();
                let password = $('#password').val();

                if (!fullName) {
                    $('#fullname').css('border', '1px solid red');
                    isValid = false;
                }
                if (!email) {
                    $('#email').css('border', '1px solid red');
                    isValid = false;
                }
                if (!password) {
                    $('#password').css('border', '1px solid red');
                    isValid = false;
                }

                if (!isValid) {
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: myAjax.ajaxurl,
                    data: {
                        action: 'my_create_user_action',
                        fullName: fullName,
                        email: email,
                        password: password
                    },
                    success: function (response) {
                        if (response.includes("Error:")) {
                            $('#message').text(response).css('color', 'red');
                        } else {
                            $('#message').text(response).css('color', 'green');
                            $('.modal-form-send-cv').removeClass("show");
                            location.reload();
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });

        }
    });


    //ajax for login user
    document.addEventListener('click', function (event) {
        if (event.target.id === 'sign-in-account') {

            let loginForm = document.getElementById('login-form');
            let email = loginForm.querySelector('#email').value;
            let password = loginForm.querySelector('#password').value;

            $.ajax({
                type: 'POST',
                url: myAjax.ajaxurl,
                data: {
                    action: 'login_account',
                    email: email,
                    password: password,
                },
                success: function (response) {
                    console.log(response);

                    let responseData = JSON.parse(response);
                    if (responseData.status === 'error') {
                        let loginSignBlock = $('.login-sign-block');

                        if (loginSignBlock.length) {
                            loginSignBlock.next('.error-message').remove();
                            loginSignBlock.val('');
                            let messageError = $('<div>').text('One or more fields are incorrect. Please ensure all fields are filled in correctly').css('color', 'red').addClass('error-message');
                            loginSignBlock.after(messageError);
                        }

                    } else {
                        $('.modal-form-send-cv').removeClass("show");
                        location.reload();
                    }

                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    });


    //add activ class to the clicked element
    $('span#block-sign-in').on('click', function () {
        $('#registr-form.registr-block-row').css({
            'display': 'none'
        });
        $('#login-form.registr-block-row').css({
            'display': 'block'
        });
    });

    $('.block-create-an-account').on('click', function () {
        $('#registr-form.registr-block-row').css({
            'display': 'block'
        });
        $('#login-form.registr-block-row').css({
            'display': 'none'
        });

    });

    function validateFormOne() {
        $('.login-em-pas input').on('input', function () {
            if ($(this).val().trim() !== '') {
                $(this).css('border', '1px solid #A3B4BC');
            } else {
                $(this).css('border', '1px solid red');
            }
        });

        $('.form-user-info input').on('input', function () {
            if ($(this).val().trim() !== '') {
                $(this).css('border', '1px solid #A3B4BC');
            } else {
                $(this).css('border', '1px solid red');
            }
        });

        let isValidStep1 = true;
        let emailCheck = $('.login-em-pas #email').val();
        let passwordCheck = $('.login-em-pas #password').val();

        if (!emailCheck) {
            $('#email').css('border', '1px solid red');
            isValidStep1 = false;
        }
        if (!passwordCheck) {
            $('#password').css('border', '1px solid red');
            isValidStep1 = false;
        }

        if (!isValidStep1) {

            return;
        }
        $('.header-registations').css('display', 'none');
        $('.registr-blocks').css('display', 'none');
        $('.step-2-registr-block').css('display', 'flex');
    }

    function validateFormTwo() {
        let isValidStep2 = true;
        let firstNameCheck = $('.form-user-info #first-name').val();
        let lastNameCheck = $('.form-user-info #last-name').val();
        let workingEmailCheck = $('.form-user-info #working-email').val();

        if (!firstNameCheck) {
            $('#first-name').css('border', '1px solid red');
            isValidStep2 = false;
        }
        if (!lastNameCheck) {
            $('#last-name').css('border', '1px solid red');
            isValidStep2 = false;
        }

        if (!workingEmailCheck) {
            $('#working-email').css('border', '1px solid red');
            isValidStep2 = false;
        }

        if (!isValidStep2) {
            return;
        }

        //step 2
        $('.step-2-registr-block').css('display', 'none');
        $('.step-3-registr-block').css('display', 'flex');


    }

    function validateFormThree() {
        $('.form-user-company input').on('input', function () {
            if ($(this).val().trim() !== '') {
                $(this).css('border', '1px solid #A3B4BC');
            } else {
                $(this).css('border', '1px solid red');
            }
        });

        $('#job_category').on('change', function () {
            if ($(this).val() !== "-1") {
                $(this).css('border', '1px solid #A3B4BC');
            } else {
                $(this).css('border', '1px solid red');
            }
        });

        let isValidStep3 = true;
        let companyNameCheck = $('.form-user-company #company-name').val();
        let jobCategoryCheck = $('#job_category').val();
        let cityCheck = $('.form-user-company #company-city').val();
        let companyStreetCheck = $('.form-user-company #street-and-building').val();
        let companyStreetAndBuildingCheck = $('.form-user-company #building').val();
        let companyZipCheck = $('.form-user-company #zip-code').val();
        let companySizeCheck = $('.form-user-company #number-of-team-members').val();
        let companyChildcarePlaceCheck = $('.form-user-company #number-of-childcare-place').val();

        if (!companyNameCheck) {
            $('#company-name').css('border', '1px solid red');
            isValidStep3 = false;
        }

        if (jobCategoryCheck === "-1" || !jobCategoryCheck) {
            $('#job_category').css('border', '1px solid red');
            isValidStep3 = false;
        }

        if (!cityCheck) {
            $('#company-city').css('border', '1px solid red');
            isValidStep3 = false;
        }

        if (!companyStreetCheck) {
            $('#street-and-building').css('border', '1px solid red');
            isValidStep3 = false;
        }

        if (!companyStreetAndBuildingCheck) {
            $('#building').css('border', '1px solid red');
            isValidStep3 = false;
        }

        if (!companyZipCheck) {
            $('#zip-code').css('border', '1px solid red');
            isValidStep3 = false;
        }

        if (!companySizeCheck) {
            $('#number-of-team-members').css('border', '1px solid red');
            isValidStep3 = false;
        }

        if (!companyChildcarePlaceCheck) {
            $('#number-of-childcare-place').css('border', '1px solid red');
            isValidStep3 = false;
        }

        if (!isValidStep3) {
            console.log('empty fields in step 3');
            return false;
        } else {
            let userEmail = $('.login-em-pas #email').val();
            let userPassword = $('.login-em-pas #password').val();
            let firstName = $('.form-user-info #first-name').val();
            let lastName = $('.form-user-info #last-name').val();
            let fullName = firstName + ' ' + lastName;
            let titleJob = $('.form-user-info #job-title').val();
            let phoneUser = $('.form-user-info #phone').val();
            let workingEmail = $('.form-user-info #working-email').val();
            let companyName = $('.form-user-company #company-name').val();
            let SelectCity = $('.form-user-company #job_category').val();
            let companyCity = $('.form-user-company #company-city').val();
            let companyStreet = $('.form-user-company #street-and-building').val();
            let companyBuilding = $('.form-user-company #building').val();
            let companyZip = $('.form-user-company #zip-code').val();
            let companyTeamMembers = $('.form-user-company #number-of-team-members').val();
            let companyChildcarePlace = $('.form-user-company #number-of-childcare-place').val();
            let companyWebsite = $('.form-user-company #company-website').val();
    
            $.ajax({
                type: 'POST',
                url: myAjax.ajaxurl,
                data: {
                    action: 'create_user_company',
                    userEmail: userEmail,
                    userPassword: userPassword,
                    firstName: firstName,
                    lastName: lastName,
                    fullName: fullName,
                    titleJob: titleJob,
                    phoneUser: phoneUser,
                    workingEmail: workingEmail,
                    companyName: companyName,
                    SelectCity: SelectCity,
                    companyCity: companyCity,
                    companyStreet: companyStreet,
                    companyBuilding: companyBuilding,
                    companyZip: companyZip,
                    companyTeamMembers: companyTeamMembers,
                    companyChildcarePlace: companyChildcarePlace,
                    companyWebsite: companyWebsite
                },
                success: function (response) {
                   
                    setTimeout(() => {
                        window.location.href = '/edit-company-page/';
                         }, 1500);
                     
    
                },
                error: function (error) { 
                    console.log(error);
    
                } 
            });
        }

       
        return true;
    }

    var options = document.querySelectorAll('.header-registations .registration-option');

    options.forEach(function (option) {
        option.addEventListener('click', function () {
            options.forEach(function (item) {
                item.classList.remove('active');
            });
            this.classList.add('active');
        });
    });

    //Create account for looking a job
    function validateFormForUserRegistration() {
        
        $('.header-registations').css('display', ' flex');
        $('.registr-blocks').css('display', 'flex');
        $('.step-2-registr-block').css('display', 'none');

        let userEmail = document.querySelector('.login-em-pas #email').value;
        let userPassword = document.querySelector('.login-em-pas #password').value;
    
        jQuery.ajax({
            type: 'POST',
            url: myAjax.ajaxurl,
            data: {
                action: 'create_user_for_looking_a_job',
                userEmail: userEmail,
                userPassword: userPassword,
            },
            success: function(response) {
                if (response.success) {
                    setTimeout(() => {
                        window.location.href = '/my-profile/';
                    }, 1500);
                } else {
                    console.log('Error: ' + response.data);
                    alert('Error: ' + response.data);
                }
            },
            error: function(error) { 
                console.log(error);
                alert('An error occurred. Please try again.');
            }
        });
    }


     //auto complete fields
     $('#first-name').on('input', function () {
        let firstName = $('#first-name').val();
        let lastName = $('#last-name').val();
        $('.first-last-name').text(firstName + ' ' + lastName);

        $('.user-avatar-firstname').text(firstName.charAt(0));
    });

    $('#last-name').on('input', function () {
        let firstName = $('#first-name').val();
        let lastName = $('#last-name').val();
        $('.first-last-name').text(firstName + ' ' + lastName);
        $('.user-avatar-lastname').text(lastName.charAt(0));
    });

    $('#working-email').on('input', function () {
        let email = $('#working-email').val();
        $('.your-email').text(email);
    });

    $('#job-title').on('input', function () {
        let companyName = $('#job-title').val();
        $('.your-job-title').text(companyName);
    });

    $('#phone').on('input', function () {
        let phone = $('#phone').val();
        $('.your-phone').text(phone);
    });
    // end auto complete fields

    //ajax for create user page registration
    $('#create-account-from-page').on('click', function () {
        //Select - I'm hiring
        validateFormOne()

        if ($('.header-registations .registration-option').eq(1).hasClass('active')) {
            //step 3
            $('button#submit-form').on('click', function (event) {
                event.preventDefault();
                validateFormTwo();
                $('button#submit-form-registr-user').on('click', function (event) {
                    event.preventDefault();
                    validateFormThree();
                });
            });
        } else {
            //Select - I'm looking for a job
            console.log("1 active.");



            validateFormForUserRegistration();
        }
    });


});
