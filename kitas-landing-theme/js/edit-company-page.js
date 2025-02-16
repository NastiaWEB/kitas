$(document).ready(function () {

    let link = new URL(window.location.href);

    // $('.head-block-left-choice .choice-option').on('click', function (e) {
    //     e.preventDefault();

    //     $('.head-block-left-choice .choice-option').removeClass('active');
    //     $(this).addClass('active');

    //     let index = $('.head-block-left-choice .choice-option').index(this);

    //     if (index === 0) {
    //         $('.container.view-info').css('display', 'block');
    //         $('.container.edit-info').css('display', 'none');
    //         $('.container.view-user').css('display', 'none');

    //     } else if (index === 1) {
    //         $('.container.view-info').css('display', 'none');
    //         $('.container.edit-info').css('display', 'none');
    //         $('.container.view-user').css('display', 'block');

    //     }
    // });

    // Edit button
    $('a.company-edit-details').on('click', function () {
        $('.container.view-info').css('display', 'none');
        $('.container.edit-info').css('display', 'block');
    });

    // Cancel button
    $('span.button-cancel').on('click', function () {
        $('.container.view-info').css('display', 'block');
        $('.container.edit-info').css('display', 'none');
    });

    // download image for avatar company
    $('.company-header-avatar-update').on('click', function () {
        $('#file-upload').click();
    });

    // download image for avatar user
    $('#block-info-profile-avatar-update-img').on('click', function () {
        $('#file-upload-user-avatar').click();
    });

    //click on the add_company_click
    $('#add_company_click').on('click', function () {
        $('.container.view-info').css('display', 'none');
        $('.container.edit-info').css('display', 'block');
        document.getElementById('webwite-company').focus();
    });

    //click on the add_working_click
    $('#add_working_click').on('click', function () {
        $('.container.view-info').css('display', 'none');
        $('.container.edit-info').css('display', 'block');
        document.getElementById('working-hours').focus();
    });

    //click on the add_describe_click
    $('#add_describe_click').on('click', function () {
        $('.container.view-info').css('display', 'none');
        $('.container.edit-info').css('display', 'block');
        document.getElementById('teaching-approach').focus();
    });

    //click on the add_photos_click
    $('#add_photos_click').on('click', function () {
        $('.container.view-info').css('display', 'none');
        $('.container.edit-info').css('display', 'block');
        document.getElementById('upload-images-click').focus();
        document.getElementById('upload-images-click').style.outline = '-webkit-focus-ring-color auto 1px';

        let targetScrollPosition = document.body.scrollHeight * 0.4;
        window.scrollTo(0, targetScrollPosition);
    });

    //click on the add_photos_click delete outline 
    $('#upload-images-click').on('click', function () {
        document.getElementById('upload-images-click').style.outline = 'none';
    });


    $('#file-upload').on('change', function () {
        let file = this.files[0];
        if (file) {
            console.log('File:', file.name);
            let reader = new FileReader();

            reader.onload = function (e) {
                let imageUrl = e.target.result;


                $('.company-header-avatar-update img:first-child').remove();

                $('.company-header-avatar-update').prepend('<img src="' + imageUrl + '" alt="Uploaded Image">');
            };
            reader.readAsDataURL(file);
        }
    });

    //download image for user avatar
    $('#file-upload-user-avatar').on('change', function () {
        let fileUserAvatar = this.files[0];
        if (fileUserAvatar) {
            console.log('File:', fileUserAvatar.name);
            let readerUserAvatar = new FileReader();

            readerUserAvatar.onload = function (e) {
                let imageUrl = e.target.result;


                $('#block-info-profile-avatar-update-img img:first-child').remove();

                $('#block-info-profile-avatar-update-img').prepend('<img src="' + imageUrl + '" class="uploaded-image-for-user-avatar" alt="Uploaded Image">');

                $('.user-block-info-profile-avatar img:first-child').remove();

                $('.user-block-info-profile-avatar').prepend('<img src="' + imageUrl + '" class="uploaded-image-for-user-avatar" alt="Uploaded Image">');


            };
            readerUserAvatar.readAsDataURL(fileUserAvatar);
        }
    });

    //gallery
    $('.select-file-for-gallery-company').on('click', function () {
        $('#gallery-file-upload').click();
    });

    $('#gallery-file-upload').on('change', function () {
        $('.gallery-show-download').empty();
        for (let i = 0; i < this.files.length; i++) {
            $('.gallery-show-download').css('display', 'block');
            let file = this.files[i];
            let reader = new FileReader();
            reader.onload = function (e) {
                $('.gallery-show-download').append('<img src="' + e.target.result + '">');
            };
            reader.readAsDataURL(file)
        }
    });

    //validate form step edit company
    function validateFormStepEditCompany() {
        //check input fields
        $('#company-edit-form-info input').on('input', function () {
            if ($(this).val().trim() !== '') {
                $(this).css('border', '1px solid #A3B4BC');
            } else {
                $(this).css('border', '1px solid red');
            }
        });

        $('#teaching-approach').on('input', function () {
            if ($(this).val().trim() !== '') {
                $(this).css('border', '1px solid #A3B4BC');
            } else {
                $(this).css('border', '1px solid red');
            }
        });

        let isValidStepEditForm = true;
        let CompanyNname = $('#company-name').val();
        let Website = $('#webwite-company').val();
        let CompanySize = $('#company-size').val();
        let childcarePlaceSize = $('#childcare_place-size').val();
        let WorkingHours = $('#working-hours').val();
        let TeachingApproach = $('#teaching-approach').val();

        if (!CompanyNname) {
            $('#company-name').css('border', '1px solid red');
            isValidStepEditForm = false;
        }

        if (!Website) {
            $('#webwite-company').css('border', '1px solid red');
            isValidStepEditForm = false;
        }

        if (!CompanySize) {
            $('#company-size').css('border', '1px solid red');
            isValidStepEditForm = false;
        }

        if (!childcarePlaceSize) {
            $('#childcare_place-size').css('border', '1px solid red');
            isValidStepEditForm = false;
        }

        if (!WorkingHours) {
            $('#working-hours').css('border', '1px solid red');
            isValidStepEditForm = false;
        }

        if (!TeachingApproach) {
            $('#teaching-approach').css('border', '1px solid red');
            isValidStepEditForm = false;
        }

        if (isValidStepEditForm) {
            return true;
        }

        return isValidStepEditForm;

    }

    // Save changes 
    $('.button-save-changes').on('click', function (event) {

        if (!validateFormStepEditCompany()) {
            event.preventDefault();
            return false;
        }

        const fileInput = $('#file-upload')[0];
        const formData = new FormData();
        const galleryFiles = $('#gallery-file-upload')[0].files;

        formData.append('action', 'handle_company_profile_update');
        formData.append('companyName', $('#company-name').val());
        formData.append('website', $('#webwite-company').val());
        formData.append('companySize', $('#company-size').val());
        formData.append('workingHours', $('#working-hours').val());
        formData.append('teachingApproach', $('#teaching-approach').val());
        formData.append('childcarePlace', $('#childcare_place-size').val());
        if (fileInput.files[0]) {
            formData.append('avatar_company', fileInput.files[0]);
        }

        for (let i = 0; i < galleryFiles.length; i++) {
            formData.append('photoGallery[]', galleryFiles[i]);
        }

        $.ajax({
            url: myAjax.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log('Data sent successfully', response);
                location.reload();
            },
            error: function (xhr, status, error) {
                console.log('Error sending data', error);
            }
        });
    });

    //Click user-edit-details 
    $('.user-edit-details').on('click', function () {
        $('.show-user-left').css('display', 'none');
        $('.settings-user-block').css('display', 'none');
        $('.update-user-left').css('display', 'flex');
    });



    //Click cancel-user
    $('.button-cancel-user').on('click', function () {
        $('.show-user-left').css('display', 'flex');
        $('.settings-user-block').css('display', 'block');
        $('.update-user-left').css('display', 'none');
    });

    //auto complete field
    $('#first-name-user').on('input', function () {
        let firstName = $('#first-name-user').val();
        let lastName = $('#last-name-user').val();
        $('.user-show-name').text(firstName + ' ' + lastName);
        $('.user-avatar-firstname').text(firstName.charAt(0));
    });

    $('#last-name-user').on('input', function () {
        let firstName = $('#first-name-user').val();
        let lastName = $('#last-name-user').val();
        $('.user-show-name').text(firstName + ' ' + lastName);
        $('.user-avatar-lastname').text(lastName.charAt(0));
    });

    $('#email-user').on('input', function () {
        let email = $('#email-user').val();
        $('.user-show-email').text(email);
    });

    $('#job-title-user').on('input', function () {
        let companyName = $('#job-title-user').val();
        $('.hiring-show-p').text(companyName);
    });

    $('#phone-user').on('input', function () {
        let phone = $('#phone-user').val();
        $('.user-show-phone').text(phone);
    });

    // Save changes user
    $('.button-save-changes-user').on('click', function (event) {

        $('#update-user-form-fields input').on('input', function () {
            if ($(this).val().trim() !== '') {
                $(this).css('border', '1px solid #A3B4BC');
            } else {
                $(this).css('border', '1px solid red');
            }
        });

        let isValid = true;
        ['first-name-user', 'last-name-user', 'email-user'].forEach(function (id) {
            let value = $('#' + id).val().trim();
            if (!value) {
                $('#' + id).css('border', '1px solid red');
                isValid = false;
            } else {
                $('#' + id).css('border', '');
            }
        });

        if (!isValid) {
            event.preventDefault();
            return false;
        }

        const fileInputUserAatar = $('#file-upload-user-avatar')[0];

        const formData = new FormData();
        formData.append('action', 'handle_user_profile_update');
        formData.append('firstName', $('#first-name-user').val().trim());
        formData.append('lastName', $('#last-name-user').val().trim());
        formData.append('email', $('#email-user').val().trim());
        formData.append('jobTitle', $('#job-title-user').val().trim());
        formData.append('phone', $('#phone-user').val().trim());
        if (fileInputUserAatar.files[0]) {
            formData.append('user-avatar', fileInputUserAatar.files[0]);
        }
        $.ajax({
            url: myAjax.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log('Data sent successfully', response);
                location.reload();
            },
            error: function (xhr, status, error) {
                console.log('Error sending data', error);
            }
        });
    });

    //check checkbox Hide contact information
    if (window.location.pathname === '/contact-person-settings/') {
        let checkboxHideContactInformation = document.getElementById('hideContactInfo');

        if (localStorage.getItem('hideContactInfo') === 'true') {
            checkboxHideContactInformation.checked = true;
            applyStyles(true);
        } else {
            applyStyles(false);
        }

        checkboxHideContactInformation.addEventListener('change', function () {
            localStorage.setItem('hideContactInfo', checkboxHideContactInformation.checked);
            applyStyles(checkboxHideContactInformation.checked);
        });
    }


    function applyStyles(isHidden) {
        let fields = document.querySelectorAll('.user-block-info-profile-fields .user-block-info-profile-fields-plus, .user-block-info-profile-fields .line-blue-block');
        if (isHidden) {
            fields.forEach(function (field) {
                field.style.opacity = '0';
            });
        } else {
            fields.forEach(function (field) {
                field.style.opacity = '';
            });
        }
    }

    //delete account
    $('.button-delete-account').on('click', function (event) {
        event.preventDefault();
        $('.delete-account-popup-custom-yes-no-for-ajax-del').css('display', 'flex');
    });

    $('.modal-close, .cancel-account').on('click', function () {
        $('.delete-account-popup-custom-yes-no-for-ajax-del').css('display', 'none');
    });

    $(document).on('click', function (event) {
        if (!$(event.target).closest('.popup-account-for-user-yes-no').length && !$(event.target).closest('.button-delete-account').length) {
            $('.delete-account-popup-custom-yes-no-for-ajax-del').css('display', 'none');
        }
    });

    let checkbox = $('#yes');
    $(".buttons-for-delete-ac-for-ajax span.delete-account").css("pointer-events", "none");
    $(".buttons-for-delete-ac-for-ajax span.delete-account").css("background", "#787878");
    $(checkbox).on('change', function () {
        if (checkbox.is(':checked')) {
            $(".buttons-for-delete-ac-for-ajax span.delete-account").css("pointer-events", "visible");
            $(".buttons-for-delete-ac-for-ajax span.delete-account").css("background", "rgba(0, 74, 116, 1)");
        } else {
            $(".buttons-for-delete-ac-for-ajax span.delete-account").css("pointer-events", "none");
            $(".buttons-for-delete-ac-for-ajax span.delete-account").css("background", "#787878");
        }
    });




    $('#yes-ajax-delete-ac-for-user').on('click', function () {
        if ($('#yes').is(':checked')) {
            jQuery.ajax({
                url: myAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'delete_user_account'
                },
                success: function (response) {
                    if (response.success) {
                        $('.popup-account-for-user-yes-no').css('display', 'none');
                        $('.success-block-after-delete-account').css('display', 'flex');
                        setTimeout(() => {
                            window.location.href = '/';
                        }, 5000);
                    } else {
                        alert(response.data.message);
                    }
                },
                error: function () {
                    alert('Server error: Cannot delete account.');
                }
            });
        } 
    });

    // Check if featured posts are saved in local storage
    function checkFeaturedToggle() {
        let featuredList = localStorage.getItem('featuredList');
        featuredList = featuredList ? featuredList.split(',') : [];

        let originalSrc = "http://104.131.170.77/wp-content/themes/kitas-landing-theme/img/bookmark.svg";
        let newSrc = "http://104.131.170.77/wp-content/themes/kitas-landing-theme/img/bookmark1.svg";

        //handling feature button clicks
        $(document).on("click", '.featuredToggle', function () {
            let data = $(this).closest('.job-card').data('postid').toString();
            let img = $(this).find('img');

            if (!featuredList.includes(data)) {
                featuredList.push(data);
                img.attr('src', newSrc);
            } else {
                featuredList = featuredList.filter(function (e) { return e !== data });
                img.attr('src', originalSrc);
            }

            localStorage.setItem('featuredList', featuredList.join(','));
        });


        //check if job is featured
        $('.job-card').each(function () {
            let postId = $(this).data('postid').toString();
            let img = $(this).find('.featuredToggle img');

            if (featuredList.includes(postId)) {
                img.attr('src', newSrc);
            } else {
                img.attr('src', originalSrc);
            }
        });
    }

    function checkLikeOrDislike() {
        let dislikeList = localStorage.getItem('dislikeList');
        dislikeList = dislikeList ? dislikeList.split(',') : [];

        let originalSrc = "http://104.131.170.77/wp-content/themes/kitas-landing-theme/img/dislike.svg";
        let newSrc = "http://104.131.170.77/wp-content/themes/kitas-landing-theme/img/dislikeblack.svg";

        $(document).on("click", '.dislike-job', function () {
            let data = $(this).closest('.job-card').data('postid').toString();
            let img = $(this).find('img');

            if (!dislikeList.includes(data)) {
                dislikeList.push(data);
                img.attr('src', newSrc);
            } else {
                dislikeList = dislikeList.filter(function (e) { return e !== data });
                img.attr('src', originalSrc);
            }

            localStorage.setItem('dislikeList', dislikeList.join(','));
        });

        $('.job-card').each(function () {
            let postId = $(this).data('postid').toString();
            let img = $(this).find('.dislike-job img');

            if (dislikeList.includes(postId)) {
                img.attr('src', newSrc);
            } else {
                img.attr('src', originalSrc);
            }
        });
    }

    //pagination
    function loadPosts(idsArray, action, postBlock, paginationLinks, titleSpan, page = 1) {
        jQuery.ajax({
            url: myAjax.ajaxurl,
            type: 'POST',
            data: {
                action: action,
                ids: idsArray,
                currentPage: page,
                current_locale: 'en'
            },
            success: function (response) {
                // console.log('AJAX response:', response);
                $('#offers-container-on').css('display', 'block');
                $('.lds-dual-ring').css('display', 'none');
                if (response.success) {
                    jQuery(postBlock).html(response.data.content);
                    jQuery(paginationLinks).html(response.data.pagination);
                    jQuery(titleSpan).text(idsArray.length);
                    checkFeaturedToggle();
                    checkLikeOrDislike();
                    jQuery('.your-class').not('.slick-initialized').slick({
                        dots: true,
                        infinite: true,
                        arrows: true
                    });
                } else {
                    console.log('Error: ', response.data);
                }
            },
            error: function () {
                console.log('Error retrieving posts');
            }
        });
    }

    // Active posts
    let activePostElements = document.querySelectorAll('.active-post li');
    if (activePostElements.length > 0) {
        let idsArray = [];
        activePostElements.forEach(function (element) {
            idsArray.push(element.textContent.trim());
        });

        loadPosts(idsArray, 'get_save_posts', '.active-post-block', '.pagination-links', '.title-for-offers span');


        jQuery(document).on("click", ".pagination-links a.page-numbers", function (e) {
            e.preventDefault();
            let href = jQuery(this).attr('href');
            let pageMatch = href ? href.match(/page\/(\d+)/) : null;
            let page = pageMatch ? pageMatch[1] : 1; // Default to 1 if no match
            loadPosts(idsArray, 'get_save_posts', '.active-post-block', '.pagination-links', '.title-for-offers span', page);
        });
    }

    // Hidden posts
    let hiddenPostElements = document.querySelectorAll('.hiden-post li');
    if (hiddenPostElements.length > 0) {
        let hiddenIdsArray = [];
        hiddenPostElements.forEach(function (element) {
            hiddenIdsArray.push(element.textContent.trim());
        });

        loadPosts(hiddenIdsArray, 'get_hidden_posts', '.hidden-post-block', '.pagination-links-hidden', '.title-for-hidden-offers span');


        jQuery(document).on("click", ".pagination-links-hidden a.page-numbers", function (e) {
            e.preventDefault();
            let href = jQuery(this).attr('href');
            let pageMatch = href ? href.match(/page\/(\d+)/) : null;
            let page = pageMatch ? pageMatch[1] : 1; // Default to 1 if no match
            loadPosts(hiddenIdsArray, 'get_hidden_posts', '.hidden-post-block', '.pagination-links-hidden', '.title-for-hidden-offers span', page);
        });
    }


    //check hide/show "Hide contact information" field value
    $.ajax({
        url: myAjax.ajaxurl,
        type: 'POST',
        data: {
            action: 'get_acf_field_value',
            field_name: 'check-fields-true-false-for-show-info'
        },
        success: function(response) {
            if (response.success) {
                $('#hideContactInfo').prop('checked', response.data.value);
            }
        }
    });

    // Save "Hide contact information" field value
    $('#hideContactInfo').on('change', function() {
        var isChecked = $(this).is(':checked');

        $.ajax({
            url: myAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'save_acf_field_value',
                field_name: 'check-fields-true-false-for-show-info',
                field_value: isChecked
            },
            success: function(response) {
                if (response.success) {
                    console.log('Field value saved successfully.');
                } else {
                    console.log('Failed to save field value.');
                }
            }
        });
    });
});