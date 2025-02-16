$(document).ready(function () {
    // Edit profile
    $('.user-edit-details').on('click', function (event) {
        event.preventDefault();
        $('.edit-main-profile').css('display', 'none');
        $('.edit-main-profile-open').css('display', 'flow-root');

    });

    // Cancel edit profile
    $('a.button-cancel').on('click', function (event) {
        event.preventDefault();
        $('.edit-main-profile').css('display', 'flow-root');
        $('.edit-main-profile-open').css('display', 'none');
    });

    // Upload avatar

    $('#upload-logo-user-avatar').click(function () {
        // $('#edit-user-avatar').click();
        $('#edit-user-avatar').trigger('click');

    });

    $('#edit-user-avatar').on('change', function () {
        let file = $('#edit-user-avatar').prop('files')[0];

        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                let new_image_url = e.target.result;

                if ($('#upload-logo-user-avatar img').length > 0) {
                    $('#upload-logo-user-avatar img').attr('src', new_image_url);
                } else {
                    $('#upload-logo-user-avatar').html('<img src="' + new_image_url + '" class="avatar-user-b" alt="">');
                }
            };
            reader.readAsDataURL(file);
        }
    });


    // Save edit profile
    $('.button-save-changes').on('click', function (event) {
        event.preventDefault();
        let formData = new FormData();
        formData.append('first_name', $('#first-name').val());
        formData.append('last_name', $('#last-name').val());
        formData.append('email', $('#email').val());
        formData.append('city', $('#city').val());
        formData.append('zip_code', $('#zip-code').val());
        formData.append('phone', $('#phone').val());

        let file_data = $('#edit-user-avatar').prop('files')[0];
        if (file_data) {
            formData.append('edit-user-avatar', file_data);
        }

        formData.append('action', 'edit_profile_user');

        $.ajax({
            type: 'POST',
            url: myAjax.ajaxurl,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log('AJAX response:', response);
                if (response.success) {
                    console.log('Profile updated successfully!');
                    location.reload();
                } else {
                    console.log('Error: ' + response.data);
                }
            },
            error: function (error) {
                console.log('Error:', error);
                console.log('An error occurred. Please try again.');
            }
        });
    });


    //Edit Job preferences
    $('.block-open-for-edit-job-preferences').on('click', function (event) {
        event.preventDefault();
        $('.show-job-location').css('display', 'none');
        $('a.block-open-for-edit-job-preferences').css('display', 'none');
        $('.edit-job-location').css('display', 'block');
        updateButtons();
        updateButtonsLocation();
    });

    $('.button-cancel-block-job-preferences').on('click', function (event) {
        event.preventDefault();
        $('.show-job-location').css('display', 'block');
        $('a.block-open-for-edit-job-preferences').css('display', 'block');
        $('.edit-job-location').css('display', 'none');

    });

    // Add another job title
    const jobData = {
        1: { title: '', category: '' },
        2: { title: '', category: '' },
        3: { title: '', category: '' }
    };

    const jobTitles = document.querySelectorAll('.job-title');
    const jobCategories = document.querySelectorAll('.job_category');

    // Initialize job data
    jobTitles.forEach((titleElement, index) => {
        const jobId = index + 1;
        jobData[jobId].title = titleElement.value;
    });

    jobCategories.forEach((categoryElement, index) => {
        const selectedOption = categoryElement.options[categoryElement.selectedIndex];
        const jobId = index + 1;
        jobData[jobId].category = selectedOption.value;
    });

    $('.stepBlockShowforJob:not(:first-of-type)').hide();

    function initializeJobFields() {
        for (let step = 1; step <= 3; step++) {
            if (jobData[step].title !== '' || jobData[step].category !== '') {
                $(`.stepBlockShowforJob:nth-of-type(${step}) .job-title`).val(jobData[step].title);
                $(`.stepBlockShowforJob:nth-of-type(${step}) .job_category`).val(jobData[step].category);
                $(`.stepBlockShowforJob:nth-of-type(${step})`).show();
            }
        }
        updateButtons();
    }

    initializeJobFields();

    function saveJobData() {
        console.log('Sending job data:', jobData); // Debug log
        $.ajax({
            url: myAjax.ajaxurl,
            method: 'POST',
            data: {
                action: 'save_job_data',
                job_data: jobData
            },
            success: function (response) {
                console.log('Data saved successfully:', response);

            },
            error: function (error) {
                console.error('Error saving data:', error);
            }
        });
    }

    function updateJobData(step) {
        const title = $(`.stepBlockShowforJob:nth-of-type(${step}) .job-title`).val();
        const category = $(`.stepBlockShowforJob:nth-of-type(${step}) .job_category`).val();
        console.log(`Updating job data for step ${step}: title=${title}, category=${category}`); // Debug log

        jobData[step].title = title;
        jobData[step].category = category;

        console.log('Updated job data:', jobData); // Debug log

    }

    function shiftDataUp(startIndex) {
        for (let i = startIndex; i < 3; i++) {
            jobData[i].title = jobData[i + 1].title;
            jobData[i].category = jobData[i + 1].category;
        }
        jobData[3].title = '';
        jobData[3].category = '';
    }

    function updateFormFields() {
        for (let i = 1; i <= 3; i++) {
            $(`.stepBlockShowforJob:nth-of-type(${i}) .job-title`).val(jobData[i].title);
            $(`.stepBlockShowforJob:nth-of-type(${i}) .job_category`).val(jobData[i].category);
            // Update select element to show the correct option as selected
            $(`.stepBlockShowforJob:nth-of-type(${i}) .job_category`).prop('selectedIndex', -1);
            $(`.stepBlockShowforJob:nth-of-type(${i}) .job_category option[value="${jobData[i].category}"]`).prop('selected', true);
        }

        // Hide and clear any empty steps
        for (let i = 1; i <= 3; i++) {
            if (jobData[i].title === '' && jobData[i].category === '') {
                $(`.stepBlockShowforJob:nth-of-type(${i})`).hide();
            }
        }
    }

    $('.job-title, .job_category').on('change', function () {
        let step = $(this).closest('.stepBlockShowforJob').index() + 1;
        updateJobData(step);
        console.log('Field changed in step:', step);
    });

    $(document).on('click', '.add-button', function () {
        const step = getLastVisibleStep();
        const nextStep = step + 1;

        $(`.stepBlockShowforJob:nth-of-type(${nextStep})`).show();
        updateButtons();
    });

    $(document).on('click', '.remove-button', function () {
        const step = $(this).closest('.stepBlockShowforJob').index() + 1;

        for (let i = 1; i <= 3; i++) {
            updateJobData(i);
        }

        shiftDataUp(step);
        updateFormFields();
        sortSteps();
        updateButtons();

    });




    function updateButtons() {
        const lastStep = getLastVisibleStep();

        for (let i = 1; i <= lastStep; i++) {
            if (lastStep === 1) {
                showAddButtonOnly(i);
            } else if (lastStep === 3) {
                showRemoveButtonOnly(i);
            } else {
                showAddAndRemoveButton(i);
            }
        }

        function showAddButtonOnly(i) {
            $(`.stepBlockShowforJob:nth-of-type(${i}) .add-button`).show();
            $(`.stepBlockShowforJob:nth-of-type(${i}) .remove-button`).hide();
        }

        function showAddAndRemoveButton(i) {
            $(`.stepBlockShowforJob:nth-of-type(${i}) .add-button`).show();
            $(`.stepBlockShowforJob:nth-of-type(${i}) .remove-button`).show();
        }

        function showRemoveButtonOnly(i) {
            $(`.stepBlockShowforJob:nth-of-type(${i}) .add-button`).hide();
            $(`.stepBlockShowforJob:nth-of-type(${i}) .remove-button`).show();
        }
    }

    function getLastVisibleStep() {
        const visibleSteps = $('.stepBlockShowforJob:visible');
        return visibleSteps.length;
    }

    function sortSteps() {
        const steps = $('.stepBlockShowforJob');
        const visibleSteps = [];
        const hiddenSteps = [];

        steps.each(function () {
            if ($(this).is(':visible')) {
                visibleSteps.push(this);
            } else {
                hiddenSteps.push(this);
            }
        });

        // Append visible steps first, then hidden steps
        const container = steps.parent();
        container.empty();
        visibleSteps.forEach(step => container.append(step));
        hiddenSteps.forEach(step => container.append(step));
    }

    // $('.job-title, .job_category').on('change', function () {
    //     saveJobData(); 
    // });

    $('.button-save-block-job-preferences').on('click', function (event) {
        saveJobData();
        saveLocationData();



    });


    ////////////////////////////////////////////
    // Add another location title
    const locationData = {
        1: { cantone: '', city: '' },
        2: { cantone: '', city: '' },
        3: { cantone: '', city: '' },
        4: { cantone: '', city: '' },
        5: { cantone: '', city: '' }
    };

    const jobCantones = document.querySelectorAll('.location');
    const jobCities = document.querySelectorAll('.job-cantone');

    // Initialize location data
    jobCantones.forEach((cantoneElement, index) => {
        const locationId = index + 1;
        locationData[locationId].cantone = cantoneElement.value;
    });

    jobCities.forEach((cityElement, index) => {
        const locationId = index + 1;
        locationData[locationId].city = cityElement.value;
    });

    $('.stepBlockShowforLocation:not(:first-of-type)').hide();

    function initializeLocationFields() {
        for (let step = 1; step <= 5; step++) {
            if (locationData[step].cantone !== '' || locationData[step].city !== '') {
                $(`.stepBlockShowforLocation:nth-of-type(${step}) .location`).val(locationData[step].cantone).trigger('change');
                $(`.stepBlockShowforLocation:nth-of-type(${step}) .job-cantone`).val(locationData[step].city).trigger('change');
                $(`.stepBlockShowforLocation:nth-of-type(${step})`).show();
            }
        }
        updateButtonsLocation();
    }

    initializeLocationFields();

    function saveLocationData() {
        console.log('Sending job data:', locationData); // Debug log
        $.ajax({
            url: myAjax.ajaxurl,
            method: 'POST',
            data: {
                action: 'save_location_data',
                location_data: locationData
            },
            success: function (response) {
                console.log('Data saved successfully:', response);
            },
            error: function (error) {
                console.error('Error saving data:', error);
            }
        });
    }

    function updateLocationData(step) {
        const cantone = $(`.stepBlockShowforLocation:nth-of-type(${step}) .location`).val();
        const city = $(`.stepBlockShowforLocation:nth-of-type(${step}) .job-cantone`).val();
        console.log(`Updating location data for step ${step}: cantone=${cantone}, city=${city}`); // Debug log

        locationData[step].cantone = cantone;
        locationData[step].city = city;

        console.log('Updated location data:', locationData); // Debug log
    }

    function shiftLocationDataUp(startIndex) {
        for (let i = startIndex; i < 5; i++) {
            locationData[i].cantone = locationData[i + 1].cantone;
            locationData[i].city = locationData[i + 1].city;
        }
        locationData[5].cantone = '';
        locationData[5].city = '';
    }

    function updateLocationFormFields() {
        for (let i = 1; i <= 5; i++) {
            $(`.stepBlockShowforLocation:nth-of-type(${i}) .location`).val(locationData[i].cantone);
            $(`.stepBlockShowforLocation:nth-of-type(${i}) .job-cantone`).val(locationData[i].city);
            // Update select element to show the correct option as selected
            $(`.stepBlockShowforLocation:nth-of-type(${i}) .job-cantone`).prop('selectedIndex', -1);
            $(`.stepBlockShowforLocation:nth-of-type(${i}) .job-cantone option[value="${locationData[i].city}"]`).prop('selected', true);
        }

        // Hide and clear any empty steps
        for (let i = 1; i <= 5; i++) {
            if (locationData[i].cantone === '' && locationData[i].city === '') {
                $(`.stepBlockShowforLocation:nth-of-type(${i})`).hide();
            }
        }
    }

    $('.location, .job-cantone').on('change', function () {
        let step = $(this).closest('.stepBlockShowforLocation').index() + 1;
        updateLocationData(step);
        console.log('Field changed in step local:', step);
    });

    $(document).on('click', '.add-another-location', function () {
        const step = getLastVisibleStepLocation();
        const nextStep = step + 1;

        $(`.stepBlockShowforLocation:nth-of-type(${nextStep})`).show();
        updateButtonsLocation();
    });


    $(document).on('click', '.remove-another-location', function () {
        const step = $(this).closest('.stepBlockShowforLocation').index() + 1;

        for (let i = step; i <= 5; i++) {
            updateLocationData(i);
        }

        shiftLocationDataUp(step);
        updateLocationFormFields();
        sortStepsLocation();
        updateButtonsLocation();
    });


    function updateButtonsLocation() {
        const lastStep = getLastVisibleStepLocation();

        for (let i = 1; i <= lastStep; i++) {
            if (lastStep === 1) {
                showAddButtonOnlyLocation(i);
            } else if (lastStep === 5) {
                showRemoveButtonOnlyLocation(i);
            } else {
                showAddAndRemoveButtonLocation(i);
            }
        }

        function showAddButtonOnlyLocation(i) {
            $(`.stepBlockShowforLocation:nth-of-type(${i}) .add-another-location`).show();
            $(`.stepBlockShowforLocation:nth-of-type(${i}) .remove-another-location`).hide();
        }

        function showAddAndRemoveButtonLocation(i) {
            $(`.stepBlockShowforLocation:nth-of-type(${i}) .add-another-location`).show();
            $(`.stepBlockShowforLocation:nth-of-type(${i}) .remove-another-location`).show();
        }

        function showRemoveButtonOnlyLocation(i) {
            $(`.stepBlockShowforLocation:nth-of-type(${i}) .add-another-location`).hide();
            $(`.stepBlockShowforLocation:nth-of-type(${i}) .remove-another-location`).show();
        }
    }


    function getLastVisibleStepLocation() {
        const steps = $('.stepBlockShowforLocation');
        let lastStep = 1;

        steps.each(function (index) {
            if ($(this).is(':visible')) {
                lastStep = index + 1;
            }
        });

        return lastStep;
    }

    function sortStepsLocation() {
        const steps = $('.stepBlockShowforLocation');
        const visibleSteps = [];
        const hiddenSteps = [];

        steps.each(function () {
            if ($(this).is(':visible')) {
                visibleSteps.push(this);
            } else {
                hiddenSteps.push(this);
            }
        });

        // Append visible steps first, then hidden steps
        const container = steps.parent();
        container.empty();
        visibleSteps.forEach(step => container.append(step));
        hiddenSteps.forEach(step => container.append(step));
    }

    function saveLocationData() {
        console.log('Sending job data:', locationData); // Debug log
        $.ajax({
            url: myAjax.ajaxurl,
            method: 'POST',
            data: {
                action: 'save_location_data',
                location_data: locationData
            },
            success: function (response) {
                console.log('Data saved successfully:', response);
                location.reload();
            },
            error: function (error) {
                console.error('Error saving data:', error);
            }
        });
    }

    // block - Experience
    $('.block-open-for-experience-block').on('click', function (event) {
        event.preventDefault();
        $('.show-block-experience').css('display', 'block');
        $('.show-experience-block').css('display', 'none');
        $('a.block-open-for-experience-block').css('display', 'none');

    });

    $('.button-cancel-block-experience').on('click', function (event) {
        event.preventDefault();
        $('.show-block-experience').css('display', 'none');
        $('.show-experience-block').css('display', 'block');
        $('a.block-open-for-experience-block').css('display', 'block');
    });

    $('.select-file-for-experience-company').on('click', function (event) {
        event.preventDefault();
        $('#experience-file-upload').trigger('click');
    });



    let existingFiles = [];
    let filesList = [];


    $(document).ready(function () {
        $('.show-documents-for-experience-block .file-name').each(function () {
            let fileName = $(this).find('a').text();
            let fileUrl = $(this).find('a').attr('href');
            existingFiles.push({ name: fileName, url: fileUrl });
        });

        displayFiles();
    });

    $('#experience-file-upload').on('change', function () {
        filesList = Array.from($(this)[0].files);
        displayFiles();
    });

    function displayFiles() {
        let fileNames = '';

        $('.show-documents-for-experience-block').empty();

        for (let i = 0; i < existingFiles.length; i++) {
            if (!existingFiles[i].deleted) {
                fileNames += '<div class="file-name"><a href="' + existingFiles[i].url + '" target="_blank">' + existingFiles[i].name + '</a><span class="delete-doc-for-experience" data-index="' + i + '" data-type="existing"></span></div>';
            }
        }

        for (let i = 0; i < filesList.length; i++) {
            fileNames += '<div class="file-name">' + filesList[i].name + ' <span class="delete-doc-for-experience" data-index="' + i + '" data-type="new"></span></div>';
        }

        $('.show-documents-for-experience-block').append(fileNames);
    }

    $(document).on('click', '.delete-doc-for-experience', function () {
        let index = $(this).data('index');
        let type = $(this).data('type');

        if (type === 'existing') {
            existingFiles[index].deleted = true;
        } else if (type === 'new') {
            filesList.splice(index, 1);
        }

        displayFiles();
    });

    $('.button-save-block-experience').on('click', function (event) {
        event.preventDefault();

        let formData = new FormData();
        formData.append('action', 'save_experience_files');

        for (let i = 0; i < filesList.length; i++) {
            formData.append('experience_files[]', filesList[i]);
        }

        for (let i = 0; i < existingFiles.length; i++) {
            if (existingFiles[i].deleted) {
                formData.append('files_to_delete[]', existingFiles[i].url);
            }
        }

        $.ajax({
            url: myAjax.ajaxurl,
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log('Data saved successfully:', response);
                location.reload();
            },
            error: function (error) {
                console.error('Error saving data:', error);
            }
        });
    });


    // block - Additional
    $('.block-open-for-additional-block').on('click', function (event) {
        event.preventDefault();
        $('.show-block-additional').css('display', 'block');
        $('.show-additional-documents-block').css('display', 'none');
        $('a.block-open-for-additional-block').css('display', 'none');
    });

    $('.button-cancel-block-additional').on('click', function (event) {
        event.preventDefault();
        $('.show-block-additional').css('display', 'none');
        $('.show-additional-documents-block').css('display', 'block');
        $('a.block-open-for-additional-block').css('display', 'block');
    });

    $('.select-file-for-additional-documents').on('click', function (event) {
        event.preventDefault();
        $('#additional-file-upload').trigger('click');
    });

    let additionalExistingFiles = [];
    let additionalFilesList = [];

    $(document).ready(function () {
        $('.show-documents-for-additional-block .file-name').each(function () {
            let fileName = $(this).find('a').text();
            let fileUrl = $(this).find('a').attr('href');
            additionalExistingFiles.push({ name: fileName, url: fileUrl });
        });

        displayAdditionalFiles();
    });

    $('#additional-file-upload').on('change', function () {
        additionalFilesList = Array.from($(this)[0].files);
        displayAdditionalFiles();
    });

    function displayAdditionalFiles() {
        let fileNames = '';

        $('.show-documents-for-additional-block').empty();

        for (let i = 0; i < additionalExistingFiles.length; i++) {
            if (!additionalExistingFiles[i].deleted) {
                fileNames += '<div class="file-name"><a href="' + additionalExistingFiles[i].url + '" target="_blank">' + additionalExistingFiles[i].name + '</a><span class="delete-doc-for-additional" data-index="' + i + '" data-type="existing"></span></div>';
            }
        }

        for (let i = 0; i < additionalFilesList.length; i++) {
            fileNames += '<div class="file-name">' + additionalFilesList[i].name + ' <span class="delete-doc-for-additional" data-index="' + i + '" data-type="new"></span></div>';
        }

        $('.show-documents-for-additional-block').append(fileNames);
    }

    $(document).on('click', '.delete-doc-for-additional', function () {
        let index = $(this).data('index');
        let type = $(this).data('type');

        if (type === 'existing') {
            additionalExistingFiles[index].deleted = true;
        } else if (type === 'new') {
            additionalFilesList.splice(index, 1);
        }

        displayAdditionalFiles();
    });

    $('.button-save-block-additional').on('click', function (event) {
        event.preventDefault();

        let formData = new FormData();
        formData.append('action', 'save_additional_files');

        for (let i = 0; i < additionalFilesList.length; i++) {
            formData.append('additional_files[]', additionalFilesList[i]);
        }

        for (let i = 0; i < additionalExistingFiles.length; i++) {
            if (additionalExistingFiles[i].deleted) {
                formData.append('files_to_delete[]', additionalExistingFiles[i].url);
            }
        }

        $.ajax({
            url: myAjax.ajaxurl,
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log('Data saved successfully:', response);
                location.reload();
            },
            error: function (error) {
                console.error('Error saving data:', error);
            }
        });
    });



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
});
