$(document).on('DOMContentLoaded', function () {

    $('#job-title').on('input', function () {
        var maxLength = $(this).attr('maxlength');
        var currentLength = $(this).val().length;
        $('#char-count span').text(currentLength + '/' + maxLength);
    });

    //check fields for %
    function validateInput(input) {
        let value = parseInt(input.val(), 10);
        if (isNaN(value) || value < 1 || value > 100) {
            input.val('');
            if (value == 0) {
                alert("Please enter a value greater than 0.");
            }
        }
    }
    $('#minInput, #maxInput').on('input change', function () {
        validateInput($(this));
    });

    function validateInputSalery(input) {
        let value = parseInt(input.val(), 10);
        if (isNaN(value) || value < 1 || value > 99999999) {
            input.val('');
            if (value == 0) {
                alert("Please enter a value greater than 0.");
                $('.salary-block-info .block-for-text-for-from-to.from').css('border', '1px solid red');
                $('#salary-block-none .block-for-text-for-from-to.to').css('border', '1px solid red');
                $('#salary-from').css('border', '0px solid red');
                $('#salary-to').css('border', '0px solid red');

            }
        }
    }

    $('#salary-from, #salary-to').on('input change', function () {
        validateInputSalery($(this));
    });

    function validateInputVacation(input) {
        let value = parseInt(input.val(), 10);
        if (isNaN(value) || value < 1 || value > 99) {
            input.val('');
            if (value == 0) {
                alert("Please enter a value greater than 0.");
            }
        }
    }

    $('#count-d-w-vacation').on('input change', function () {
        validateInputVacation($(this));
    });


    function validateInputOld(input) {
        let value = parseInt(input.val(), 10);
        if (isNaN(value) || value < 1 || value > 100) {
            input.val('');
            if (value == 0) {
                alert("Please enter a value greater than 0.");
            }
        }
    }

    $('#months-old, #year-old').on('input change', function () {
        validateInputOld($(this));
    });



    //add id for button next
    function updateButtonId() {
        $('.button-next').removeAttr('id');
        for (let i = 1; i <= 4; i++) {
            if ($(`#step-${i}`).is(':visible')) {
                $('.button-next').attr('id', `close-step-${i}`);
                break;
            }
        }
    }

    updateButtonId();


    //validation for form step 1
    function validateFormStep1() {
        //check input fields
        $('#submit_custom_form input').on('input', function () {
            if ($(this).val().trim() !== '') {
                $(this).css('border', '1.5px solid #3964A6');
            } else {
                $(this).css('border', '1px solid red');
            }
        });

        //check select fields
        $('#job-category').on('change', function () {
            if ($(this).val() !== '') {
                $(this).css('border', '1.5px solid #3964A6');
            } else {
                $(this).css('border', '1px solid red');
            }
        });

        $('#job-location').on('change', function () {
            if ($(this).val() !== '') {
                $(this).css('border', '1.5px solid #3964A6');
            } else {
                $(this).css('border', '1px solid red');
            }
        });


        //min date for calendar


        $("#selected-date-starts-on").datepicker({
            minDate: 0,
            onSelect: function (dateText) {
                $('#calendar-button-starts-on').css('border', '1.5px solid #3964A6');
            }
        });

        $("#selected-date").datepicker({
            minDate: 0,
            onSelect: function (dateText) {
                $('#calendar-button').css('border', '1.5px solid #3964A6');
            }
        });


        $("#calendar-button-starts-on").click(function (event) {
            event.preventDefault();
            $("#selected-date-starts-on").datepicker("show");
        });

        $("#calendar-button").click(function (event) {
            event.preventDefault();
            $("#selected-date").datepicker("show");
        });

        $('#selected-date-starts-on').datepicker('option', 'onSelect', function (dateText) {
            $('#calendar-button-starts-on').css('border', '1.5px solid #3964A6');
        });

        $('#selected-date').datepicker('option', 'onSelect', function (dateText) {
            $('#calendar-button').css('border', '1.5px solid #3964A6');
        });



        let isValidStep1 = true;
        let jobTitle = $('#submit_custom_form #job-title').val();
        let jobCategory = $('#job-category').val();
        let jobLocation = $('#job-location').val();
        let jobCity = $('#job-city').val();
        let jobStreet = $('#job-street').val();
        let jobBuilding = $('#job-building').val();
        let jobZipCode = $('#job-zip-code').val();
        let selectedDateStartsOn = $('#selected-date-starts-on').val();
        let selectedDate = $('#selected-date').val();

        if (!jobTitle) {
            $('#submit_custom_form #job-title').css('border', '1px solid red');
            isValidStep1 = false;
        }

        if (!jobCategory) {
            $('#job-category').css('border', '1px solid red');
            isValidStep1 = false;
        }

        if (!jobLocation) {
            $('#job-location').css('border', '1px solid red');
            isValidStep1 = false;
        }

        if (!jobCity) {
            $('#job-city').css('border', '1px solid red');
            isValidStep1 = false;
        }

        if (!jobStreet) {
            $('#job-street').css('border', '1px solid red');
            isValidStep1 = false;
        }

        if (!jobBuilding) {
            $('#job-building').css('border', '1px solid red');
            isValidStep1 = false;
        }

        if (!jobZipCode) {
            $('#job-zip-code').css('border', '1px solid red');
            isValidStep1 = false;
        }

        if (!selectedDateStartsOn) {
            $('#calendar-button-starts-on').css('border', '1px solid red');
            isValidStep1 = false;
        }

        if (!selectedDate) {
            $('#calendar-button').css('border', '1px solid red');
            isValidStep1 = false;
        }

        if (isValidStep1) {
            nextStep();
            updateButtonId();

        }

        return isValidStep1;

    }

    //check visible step 1
    $(document).on('click', '#close-step-1', function (event) {
        event.preventDefault();
        validateFormStep1();
    });



    //validation for form step 2
    function validateFormStep2() {
        //check Contract type
        $('#employment-buttons .employment-button').click(function () {
            $('#employment-buttons button').css('border', '1px solid');
        });

        $('#submit_custom_form input').on('input', function () {
            if ($(this).val().trim() !== '') {
                $(this).css('border', '1.5px solid #3964A6');
            } else {
                $(this).css('border', '0px solid red');
            }
        });

        $('#submit_custom_form #salary-from').on('input', function () {
            if ($(this).val().trim() !== '') {
                $('.block-for-text-for-from-to.from').css('border', '0px solid #3964A6');
            }
        });

        $('#submit_custom_form #count-d-w-vacation').on('input', function () {
            if ($(this).val().trim() !== '') {
                $('.block-for-day-weeks').css('border', '1.5px solid #3964A6');
            }
        });

        $('#minInput, #maxInput').on('input', function () {
            validateInputs();
        });

        $('#time-start-wh, #time-finish-wh').on('input', function () {
            console.log("time chacge ");
            validateTimeInputs();
        });

        $('#salary-from, #salary-to').on('input', function () {
            validateSalaryFields();
        });

        $('#count-d-w-vacation').on('input', function () {
            validateSalaryFields();
        });



        let jobminInput = $('#minInput').val();
        let jobmaxInput = $('#maxInput').val();
        let jobTimeStart = $('#time-start-wh').val();
        let jobTimeFinish = $('#time-finish-wh').val();
        let jobSalaryFrom = $('#salary-from').val();
        let jobVacation = $('#count-d-w-vacation').val();
        let isValidStep2 = true;

        if ($('#employment-buttons .employment-button.active').length > 0) {
            $('#employment-buttons button').css('border', '1px solid');
        } else {
            $('#employment-buttons button').css('border', '1px solid red');
            isValidStep2 = false;
        }

        if (!jobminInput) {
            $('#minInput').css('border', '1px solid red');
            isValidStep2 = false;
        }

        if (!jobmaxInput) {
            $('#maxInput').css('border', '1px solid red');
            isValidStep2 = false;
        }

        if (!jobTimeStart) {
            $('#time-start-wh').css('border', '1px solid red');
            isValidStep2 = false;
        }

        if (!jobTimeFinish) {
            $('#time-finish-wh').css('border', '1px solid red');
            isValidStep2 = false;
        }

        if (!jobSalaryFrom) {
            $('.block-for-text-for-from-to.from').css('border', '1px solid red');
            isValidStep2 = false;
        }

        if (!jobVacation) {
            $('.block-for-day-weeks').css('border', '1px solid red');
            isValidStep2 = false;
        }

        // Validate workload percentage fields
        if (!validateInputs()) {
            isValidStep2 = false;
        }

        // Validate salary fields
        if (!validateSalaryFields()) {
            isValidStep2 = false;
        }

        if (isValidStep2) {
            nextStep();
            updateButtonId();
        }

        return isValidStep2;
    }

    function validateInputs() {
        const minValue = parseInt($('#minInput').val(), 10);
        const maxValue = parseInt($('#maxInput').val(), 10);
        let isValid = true;

        if (!isNaN(minValue) && !isNaN(maxValue) && minValue > 0 && maxValue > 0 && minValue <= 100 && maxValue <= 100) {
            if (maxValue < minValue) {
                $('.mixer-block input').css('border', '1px solid red');
                isValid = false;
            } else {
                $('.mixer-block input').css('border', '1.5px solid #3964A6');
            }
        } else {
            $('.mixer-block input').css('border', '1px solid red');
            isValid = false;
        }

        return isValid;
    }


    function validateTimeInputs() {
        let isValid = true;
        const timeStartValue = $('#time-start-wh').val();
        const timeFinishValue = $('#time-finish-wh').val();

        if (timeStartValue === '') {
            $('#time-start-wh').css('border', '1px solid red');
            isValid = false;
        } else {
            $('#time-start-wh').css('border', '1.5px solid #3964A6');
        }

        if (timeFinishValue === '') {
            $('#time-finish-wh').css('border', '1px solid red');
            isValid = false;
        } else {
            $('#time-finish-wh').css('border', '1.5px solid #3964A6');
        }

        return isValid;
    }



    function validateSalaryFields() {
        const fromValue = parseInt($('#salary-from').val(), 10);
        const toValue = $('#salary-to').val() === '' ? null : parseInt($('#salary-to').val(), 10);
        const vacationDays = parseInt($('#count-d-w-vacation').val(), 10);
        let isValid = true;

        // Validate salary fields
        if (!isNaN(fromValue) && fromValue > 0) {
            if (toValue !== null && (!isNaN(toValue) && toValue > 0)) {
                if (fromValue > toValue) {
                    $('.salary-block-info .block-for-text-for-from-to.from').css('border', '1px solid red');
                    $('#salary-block-none .block-for-text-for-from-to.to').css('border', '1px solid red');
                    $('#salary-from').css('border', '0px solid red');
                    $('#salary-to').css('border', '0px solid red');
                    isValid = false;
                } else {
                    $('.salary-block-info .block-for-text-for-from-to.from').css('border', '1.5px solid #3964A6');
                    $('#salary-block-none .block-for-text-for-from-to.to').css('border', '1.5px solid #3964A6');
                    $('#salary-from').css('border', '0px solid red');
                    $('#salary-to').css('border', '0px solid red');
                }
            } else if (toValue === null) {
                $('.salary-block-info .block-for-text-for-from-to.from').css('border', '1.5px solid #3964A6');
                $('#salary-block-none .block-for-text-for-from-to.to').css('border', '1.5px solid #3964A6');
                $('#salary-from').css('border', '0px solid red');
                $('#salary-to').css('border', '0px solid red');
            } else {
                $('.salary-block-info .block-for-text-for-from-to.from').css('border', '1px solid red');
                $('#salary-block-none .block-for-text-for-from-to.to').css('border', '1px solid red');
                $('#salary-from').css('border', '0px solid red');
                $('#salary-to').css('border', '0px solid red');
                isValid = false;
            }
        } else {
            $('.salary-block-info .block-for-text-for-from-to.from').css('border', '1px solid red');
            $('#salary-block-none .block-for-text-for-from-to.to').css('border', '1px solid red');
            $('#salary-from').css('border', '0px solid red');
            $('#salary-to').css('border', '0px solid red');
            isValid = false;
        }

        // Validate vacation days
        if (!isNaN(vacationDays) && vacationDays > 0) {
            $('.block-for-day-weeks').css('border', '1.5px solid #3964A6');
        } else {
            $('.block-for-day-weeks').css('border', '1px solid red');
            isValid = false;
        }

        return isValid;
    }




    //check visible step 2
    $(document).on('click', '#close-step-2', function (event) {
        event.preventDefault();
        validateFormStep2();
    });

    //validation for form step 3
    function validateFormStep3() {
        $('.check-teaching-approach .employment-checkbox').on('change', function () {
            $('span.check-teaching-approach-error').css('color', 'rgba(119, 119, 119, 1)');
        });

        $('.check-working-language .employment-checkbox-language').on('change', function () {
            $('span.check-working-language-error').css('color', 'rgba(119, 119, 119, 1)');
        });

        $('#employment-buttons .employment-button-group').click(function () {
            $('#employment-buttons button').css('border', '1px solid');
        });

        $('#submit_custom_form #months-old').on('input', function () {
            if ($(this).val().trim() !== '') {
                $('.text-for-kids-select-age-block-from-to').css('border', '0px solid #A3B4BC');
            } else {
                $('.text-for-kids-select-age-block-from-to').css('border', '1px solid red');
            }
        });

        $('#submit_custom_form #year-old').on('input', function () {
            if ($(this).val().trim() !== '') {
                $('.text-for-kids-select-age-block-to').css('border', '0px solid #A3B4BC');
            } else {
                $('.text-for-kids-select-age-block-to').css('border', '1px solid red');
            }
        });

        let isValidStep3 = true;


        let checkedBoxesTeachingApproach = $('.approach-options.check-teaching-approach .employment-checkbox:checked');
        if (checkedBoxesTeachingApproach.length > 0) {
            $('span.check-teaching-approach-error').css('color', 'rgba(119, 119, 119, 1)');
        } else {
            $('span.check-teaching-approach-error').css('color', 'red');
            isValidStep3 = false;
        }


        let checkedBoxesWorkingLanguage = $('.check-working-language .employment-checkbox-language:checked');
        if (checkedBoxesWorkingLanguage.length > 0) {
            $('span.check-working-language-error').css('color', 'rgba(119, 119, 119, 1)');
        } else {
            $('span.check-working-language-error').css('color', 'red');
            isValidStep3 = false;
        }

        if ($('#employment-buttons .employment-button-group.active').length > 0) {
            $('#employment-buttons button').css('border', '1px solid');
        } else {
            $('#employment-buttons button').css('border', '1px solid red');
            isValidStep3 = false;
        }

        let jobMonthsOld = $('#months-old').val();
        let jobYearOld = $('#year-old').val();
        if (!jobMonthsOld) {
            $('.text-for-kids-select-age-block-from-to').css('border', '1px solid red');
            isValidStep3 = false;
        }
        if (!jobYearOld) {
            $('.text-for-kids-select-age-block-to').css('border', '1px solid red');
            isValidStep3 = false;
        }

        function validateAges() {
            const fromValue = parseInt($('#months-old').val(), 10);
            const toValue = parseInt($('#year-old').val(), 10);

            if (!isNaN(fromValue) && fromValue > 0 && (isNaN(toValue) || toValue > 0)) {
                if (!isNaN(toValue) && fromValue > toValue) {
                    $('.text-for-kids-select-age-block-from-to').css('border', '1px solid red');
                    $('.text-for-kids-select-age-block-to').css('border', '1px solid red');
                    $('#months-old').css('border', '0px solid red');
                    $('#year-old').css('border', '0px solid red');
                    isValidStep3 = false;
                } else {

                    $('.text-for-kids-select-age-block-from-to').css('border', '1.5px solid #3964A6');
                    $('.text-for-kids-select-age-block-to').css('border', '1.5px solid #3964A6');
                    $('#months-old').css('border', '0px solid red');
                    $('#year-old').css('border', '0px solid red');
                }
            } else {
                $('.text-for-kids-select-age-block-from-to').css('border', '1px solid red');
                $('.text-for-kids-select-age-block-to').css('border', '1px solid red');
                $('#months-old').css('border', '0px solid red');
                $('#year-old').css('border', '0px solid red');
                isValidStep3 = false;
            }

            return isValidStep3;
        }

        $('#months-old, #year-old').on('input', function () {
            validateAges();
        });

        validateAges();

        if (isValidStep3) {
            nextStep();
            updateButtonId();
        }

        return isValidStep3;
    }


    $(document).on('click', '#close-step-3', function (event) {
        event.preventDefault();
        validateFormStep3();
    });

    //validation for form step 4
    function validateFormStep4() {
        let isValidStep4 = true;

        let jobRequirements = document.getElementById('job-description-describe-required-editor_ifr').contentDocument;
        let iframeBody = jobRequirements.body;
        if (!iframeBody.textContent.trim()) {
            $('#job-description-describe-required-editor_ifr').css('border', '1px solid red');
            isValidStep4 = false;
        }

        iframeBody.addEventListener('input', function () {
            if (iframeBody.textContent.trim()) {
                $('#job-description-describe-required-editor_ifr').css('border', 'none');
            } else {
                $('#job-description-describe-required-editor_ifr').css('border', '1px solid red');
            }
        });




        let jobDNiceToHave = document.getElementById('job-description-applying-process_ifr').contentDocument;
        let iframeBodyNiceToHave = jobDNiceToHave.body;
        if (!iframeBodyNiceToHave.textContent.trim()) {
            $('#job-description-applying-process_ifr').css('border', '1px solid red');
            isValidStep4 = false;
        }

        iframeBodyNiceToHave.addEventListener('input', function () {
            if (iframeBodyNiceToHave.textContent.trim()) {
                $('#job-description-applying-process_ifr').css('border', 'none');
            } else {
                $('#job-description-applying-process_ifr').css('border', '1px solid red');
            }
        });


        let jobResponsibilities = document.getElementById('job-description-describe-create-list_ifr').contentDocument;
        let iframeBodyResponsibilities = jobResponsibilities.body;
        if (!iframeBodyResponsibilities.textContent.trim()) {
            $('#job-description-describe-create-list_ifr').css('border', '1px solid red');
            isValidStep4 = false;
        }

        iframeBodyResponsibilities.addEventListener('input', function () {
            if (iframeBodyResponsibilities.textContent.trim()) {
                $('#job-description-describe-create-list_ifr').css('border', 'none');
            } else {
                $('#job-description-describe-create-list_ifr').css('border', '1px solid red');
            }
        });


        let jobBenefits = document.getElementById('job-description-describe-benefits_ifr').contentDocument;
        let iframeBodyBenefits = jobBenefits.body;
        if (!iframeBodyBenefits.textContent.trim()) {
            $('#job-description-describe-benefits_ifr').css('border', '1px solid red');
            isValidStep4 = false;
        }

        iframeBodyBenefits.addEventListener('input', function () {
            if (iframeBodyBenefits.textContent.trim()) {
                $('#job-description-describe-benefits_ifr').css('border', 'none');
            } else {
                $('#job-description-describe-benefits_ifr').css('border', '1px solid red');
            }
        });

        let gallery = document.getElementById('gallery');
        let galleryButton = document.querySelector('.upload-photo-gallery button');

        function updateGalleryButton() {
            if (gallery && gallery.children.length === 0) {
                galleryButton.style.border = '1px solid red';
                isValidStep4 = false;
            } else {
                galleryButton.style.border = '1px solid #9747FF';
                isValidStep4 = true;
            }
        }

        updateGalleryButton();

        const observer = new MutationObserver(updateGalleryButton);
        observer.observe(gallery, { childList: true });



        if (isValidStep4) {
            nextStep();
            updateButtonId();

        }

        return isValidStep4;
    }

    $(document).on('click', '.button-next-final', function (event) {
        event.preventDefault();
        validateFormStep4();
    });

    //Form block

    // Variables
    var currentStep = 1;
    var totalSteps = 4;
    let approachOptionsArray = [];
    let galleryImages = [];
    let urgencyValue = '';
    let temporaryValue = '';
    let cityValue = '';
    let formDateStart = '';
    let formattedDate = '';
    let timeInputStart = '';
    let timeInputFinish = '';



    // Selectors
    var backButton = document.querySelector(".button-back");
    var nextButton = document.querySelector(".button-next");
    var previewButton = document.querySelector(".button-preview");
    var nextFinalButton = document.querySelector(".button-next-final");

    var steps = document.querySelectorAll(".step");

    // Event listeners for buttons
    backButton.addEventListener("click", function (event) {
        event.preventDefault();
        prevStep();
        updateButtonId();
    });

    // nextButton.addEventListener("click", function (event) {
    //     event.preventDefault();
    //     nextStep();
    //     updateButtonId();
    // });

    // Event listeners for steps
    steps.forEach(function (step, index) {
        step.addEventListener("click", function (event) {
            event.preventDefault();
            var clickedStepIndex = Array.from(steps).indexOf(step) + 1;
            if (clickedStepIndex > currentStep) {
                while (currentStep < clickedStepIndex) {

                    if (clickedStepIndex == 2) {
                        validateFormStep1();
                        updateButtonId();
                        return false
                    }
                    if (clickedStepIndex == 3) {
                        validateFormStep2();
                        updateButtonId();
                        return false
                    }

                    if (clickedStepIndex == 4) {
                        validateFormStep3();
                        updateButtonId();
                        return false
                    }

                    nextStep();
                    updateButtonId();
                }
            } else if (clickedStepIndex < currentStep) {
                while (currentStep > clickedStepIndex) {
                    prevStep();
                    updateButtonId

                    console.log('clickedStepIndex <<<', clickedStepIndex);
                }
            }
        });
    });

    // Function to toggle steps
    function toggleStep(current, next) {
        var currentStepElement = document.getElementById("step-" + current);
        var nextStepElement = document.getElementById("step-" + next);

        if (currentStepElement && nextStepElement) {
            currentStepElement.style.display = "none";
            nextStepElement.style.display = "block";
        }
    }



    // Update steps function
    function updateSteps() {
        for (var i = 0; i < steps.length; i++) {
            if (i + 1 === currentStep) {
                steps[i].classList.add("step-active");
                steps[i].classList.remove("step-done");
                steps[i].innerHTML = i + 1;
            } else if (i + 1 < currentStep) {
                steps[i].classList.add("step-done");
                steps[i].classList.remove("step-active");
                steps[i].innerHTML = '<i class="fas fa-check"></i>';
                if (steps[i].classList.contains("step-done")) {
                    steps[i].innerHTML = '<i class="fas fa-check"></i>';
                }
            } else {
                steps[i].classList.remove("step-active");
                steps[i].classList.remove("step-done");
            }
        }

        //check buttons for visibility
        if (currentStep === 1) {
            backButton.style.opacity = 0;
        } else {
            backButton.style.opacity = 1;
        }

        if (currentStep === totalSteps) {
            nextButton.style.display = "none";
            nextFinalButton.style.display = "block";
        } else {
            nextButton.style.display = "block";
            nextFinalButton.style.display = "none";
        }

    }

    // Function to move to next step
    function nextStep() {
        if (currentStep < totalSteps) {
            toggleStep(currentStep, currentStep + 1);
            currentStep++;
            updateSteps();
        }
    }

    // Function to move to previous step
    function prevStep() {
        if (currentStep > 1) {
            toggleStep(currentStep, currentStep - 1);
            currentStep--;
            updateSteps();
        }
    }

    // Initial update
    updateSteps();


    //calendar step 1
    var calendarButton = document.getElementById("calendar-button");
    const selectedDateInput = document.getElementById("selected-date");

    calendarButton.addEventListener("click", function (event) {
        event.preventDefault();
        $("#selected-date").datepicker("show");
        selectedDateInput.style.display = "block";
    });



    //calendar start step 2
    var startsOnCalendarButton = document.getElementById("calendar-button-starts-on");
    const selectedStartDateInput = document.getElementById("selected-date-starts-on");


    startsOnCalendarButton.addEventListener("click", function (event) {
        event.preventDefault();
        $("#selected-date-starts-on").datepicker("show");
        selectedStartDateInput.style.display = "block";
    });

    //calendar update
    $(".calendar-button, #selected-date-starts-on, #selected-date-starts-of").click(function (event) {
        event.preventDefault();
        var targetId = $(this).attr('id');
        $("#" + targetId).datepicker("show");
    });


    $("#selected-date, #selected-date-starts-on, #selected-date-starts-of").datepicker({
        dateFormat: "yy-mm-dd",
        minDate: "today",
        onSelect: function (dateText) {
            $(this).val(dateText);
        }
    });;

    // Employment buttons
    var employmentButtons = document.querySelectorAll(".employment-button");
    var selectedEmployment = null;

    employmentButtons.forEach(function (button) {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            var employmentId = this.getAttribute("data-value");
            if (selectedEmployment === employmentId) {

                this.classList.remove("active");
                this.classList.add("no-active");
                this.querySelector(".button-icon").classList.remove("fas", "fa-check");
                this.querySelector(".button-icon").classList.add("fas", "fa-times");
                selectedEmployment = null;
            } else {
                employmentButtons.forEach(function (btn) {
                    btn.classList.remove("active");
                    btn.classList.add("no-active");
                    btn.querySelector(".button-icon").classList.remove("fas", "fa-check");
                    btn.querySelector(".button-icon").classList.add("fas", "fa-times");
                });
                this.classList.add("active");
                this.classList.remove("no-active");
                this.querySelector(".button-icon").classList.remove("fa-times");
                this.querySelector(".button-icon").classList.add("fas", "fa-check");
                selectedEmployment = employmentId;
            }
            console.log("Employment ID:", selectedEmployment);
        });
    });

    // Work buttons

    var workButtons = document.querySelectorAll(".employment-button-work");
    var selectedWork = null;
    const minInput = document.getElementById("minInput");
    const maxInput = document.getElementById("maxInput");
    const rangeMin = document.getElementById("rangeMin");
    const rangeMax = document.getElementById("rangeMax");

    //mixer
    let min = 10;
    let max = 100;

    const calcLeftPosition = value => Math.floor((value - 10) * (100 / (100 - 10)));

    function updateMixer() {
        const min = parseInt(rangeMin.value, 10);
        const max = parseInt(rangeMax.value, 10);
        const minPercent = Math.floor(((min - 10) / (100 - 10)) * 100);
        const maxPercent = Math.floor(((max - 10) / (100 - 10)) * 100);

        $('#thumbMin').css('left', minPercent + '%');
        $('#thumbMax').css('left', maxPercent + '%');
        $('#line').css('left', minPercent + '%');
        $('#line').css('right', (100 - maxPercent) + '%');
    }

    function updateRangeFromInput(input, range) {
        const value = parseInt(input.val(), 10);
        if (range.attr('id') === 'rangeMin' && value >= max) return;
        if (range.attr('id') === 'rangeMax' && value <= min) return;
        range.val(value);
        updateMixer();
    }

    $('#minInput').on('input', function () {
        updateRangeFromInput($(this), $('#rangeMin'));
    });

    $('#maxInput').on('input', function () {
        updateRangeFromInput($(this), $('#rangeMax'));
    });

    $('#rangeMin').on('input', function (e) {
        const newValue = parseInt(e.target.value, 10);
        if (newValue >= max) return;
        min = newValue;
        updateMixer();
        $('#minInput').val(newValue);
    });

    $('#rangeMax').on('input', function (e) {
        const newValue = parseInt(e.target.value, 10);
        if (newValue <= min) return;
        max = newValue;
        updateMixer();
        $('#maxInput').val(newValue);
    });

    // Initialize values
    $('#minInput').val(min);
    $('#maxInput').val(max);
    updateMixer();



    workButtons.forEach(function (button) {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            var workId = this.getAttribute("data-value");
            if (selectedWork === workId) {
                this.classList.remove("active");
                this.classList.add("no-active");
                this.querySelector(".button-icon").classList.remove("fas", "fa-check");
                this.querySelector(".button-icon").classList.add("fas", "fa-times");
                selectedWork = null;
            } else {
                workButtons.forEach(function (btn) {
                    btn.classList.remove("active");
                    btn.classList.add("no-active");
                    btn.querySelector(".button-icon").classList.remove("fas", "fa-check");
                    btn.querySelector(".button-icon").classList.add("fas", "fa-times");
                });
                this.classList.add("active");
                this.classList.remove("no-active");
                this.querySelector(".button-icon").classList.remove("fa-plus");
                this.querySelector(".button-icon").classList.add("fas", "fa-check");
                selectedWork = workId;
            }
            console.log("Work ID:", selectedWork);

            updateMixer();


            if (selectedWork === "full-time") {
                rangeMin.min = 60;
                rangeMin.max = 100;
            } else if (selectedWork === "part-time") {
                rangeMin.min = 0;
                rangeMin.max = 60;
            }

            updateMixer();
        });
    });




    //duration
    var durationButtons = document.querySelectorAll(".employment-button-duration");
    var selectedWork = null;
    var endDateLink = document.getElementById("calendar-button-starts-of");

    durationButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            event.preventDefault();
            var workId = this.getAttribute("data-value");
            if (selectedWork === workId) {
                this.classList.remove("active");
                btn.classList.add("no-active");
                btn.querySelector(".button-icon").classList.remove("fas", "fa-check");
                btn.querySelector(".button-icon").classList.add("fas", "fa-times");
                selectedWork = null;
            } else {
                durationButtons.forEach(function (btn) {
                    btn.classList.remove("active");
                    btn.classList.add("no-active");
                    btn.querySelector(".button-icon").classList.remove("fas", "fa-check");
                    btn.querySelector(".button-icon").classList.add("fas", "fa-times");
                });
                this.classList.add("active");
                this.classList.remove("no-active");
                this.querySelector(".button-icon").classList.remove("fa-plus");
                this.querySelector(".button-icon").classList.add("fas", "fa-check");
                selectedWork = workId;
            }

            if (workId === "temporary") {
                endDateLink.style.display = "inline";
                selectedFinishDateInput.style.display = "block";
            } else {
                endDateLink.style.display = "none";
            }

            console.log("Duration ID:", selectedWork);
        });
    });

    //Urgent
    var urgentButtons = document.querySelectorAll(".employment-button-urgent");
    var selectedWork = false;

    urgentButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            event.preventDefault();

            var isActive = this.classList.contains("active");

            if (isActive) {
                this.querySelector(".button-icon").classList.remove("fas", "fa-check");
                this.classList.remove("active");
                this.setAttribute("data-value", "false");
                selectedWork = false;
            } else {
                urgentButtons.forEach(function (btn) {
                    btn.classList.remove("active");
                    btn.querySelector(".button-icon").classList.add("fa-plus");
                    btn.setAttribute("data-value", "false");
                });
                this.querySelector(".button-icon").classList.add("fas", "fa-check");
                this.classList.add("active");
                this.setAttribute("data-value", "true");
                selectedWork = this.getAttribute("data-value");
            }

            console.log("Urgent ID:", selectedWork);
        });
    });



    // //approach
    // var approachButtons = document.querySelectorAll(".employment-button-approach");
    // var selectedWork = null;

    // document.querySelectorAll(".employment-checkbox").forEach(function (checkbox) {
    //     checkbox.name = "single-approach";
    // });

    // approachButtons.forEach(function (button) {
    //     button.addEventListener("click", function () {
    //         event.preventDefault();
    //         var workId = this.getAttribute("data-value");

    //         if (workId === "mixed-approach") {
    //             document.querySelectorAll(".employment-checkbox").forEach(function (checkbox) {
    //                 checkbox.name = "mixed-approach";
    //             });
    //             selectedWork = workId;
    //         } else {
    //             document.querySelectorAll(".employment-checkbox").forEach(function (checkbox) {
    //                 checkbox.name = "single-approach";
    //             });
    //             selectedWork = workId;
    //         }
    //         approachButtons.forEach(function (btn) {
    //             btn.classList.remove("active");
    //             btn.classList.add("no-active");
    //             btn.querySelector(".button-icon").classList.remove("fas", "fa-check");
    //             btn.querySelector(".button-icon").classList.add("fas", "fa-times");
    //         });

    //         this.classList.add("active");
    //         this.classList.remove("no-active");
    //         this.querySelector(".button-icon").classList.remove("fa-plus");
    //         this.querySelector(".button-icon").classList.add("fas", "fa-check");
    //         selectedWork = workId;
    //         console.log("Aproach ID:", selectedWork);
    //     });
    // });


    // document.querySelectorAll(".employment-checkbox").forEach(function (checkbox) {
    //     checkbox.addEventListener("change", function () {
    //         if (this.checked && this.name === "single-approach") {
    //             document.querySelectorAll(".employment-checkbox").forEach(function (otherCheckbox) {
    //                 if (otherCheckbox !== checkbox && otherCheckbox.name === "single-approach") {
    //                     otherCheckbox.checked = false;
    //                 }
    //             });
    //         }
    //     });
    // });

    //show checbos
    // var selectedValues = [];
    // document.querySelectorAll(".employment-checkbox").forEach(function (checkbox) {
    //     checkbox.addEventListener("click", function () {

    //         var selectedCheckboxes = document.querySelectorAll(".employment-checkbox:checked");
    //         var selectedValues = Array.from(selectedCheckboxes).map(function (checkbox) {
    //             return checkbox.value;
    //         });
    //         var optionalBlock = document.querySelector(".approach-options-optional");
    //         if (optionalBlock) {
    //             optionalBlock.style.display = "block";
    //         }
    //         console.log("Selected checkboxes:", selectedValues.join(", "));
    //     });
    // });

    //show approach-options-optional
    // var checkboxRequired = document.getElementById("checkbox-required");
    // var checkboxOptional = document.getElementById("checkbox-optional");

    // checkboxRequired.name = "approach-option";
    // checkboxOptional.name = "approach-option";

    // document.querySelectorAll(".employment-checkbox-required, .employment-checkbox-optional").forEach(function (checkbox) {
    //     checkbox.addEventListener("change", function () {
    //         if (this === checkboxRequired && checkboxOptional.checked) {
    //             checkboxOptional.checked = false;
    //         } else if (this === checkboxOptional && checkboxRequired.checked) {
    //             checkboxRequired.checked = false;
    //         }

    //         var selectedCheckbox = document.querySelector(".employment-checkbox-required:checked, .employment-checkbox-optional:checked");

    //         var selectedValue = selectedCheckbox ? selectedCheckbox.value : "";
    //         console.log("Selected approach option:", selectedValue);
    //     });
    // });

    //Kids age in a group
    var groupButtons = document.querySelectorAll(".employment-button-group");
    var selectedWork = null;

    groupButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            event.preventDefault();
            var workId = this.getAttribute("data-value");
            if (selectedWork === workId) {
                this.classList.remove("active");
                this.querySelector(".button-icon").classList.remove("fas", "fa-check");
                this.querySelector(".button-icon").classList.add("fas", "fa-check");
                selectedWork = null;
            } else {
                groupButtons.forEach(function (btn) {
                    btn.classList.remove("active");
                    btn.classList.add("no-active");
                    btn.querySelector(".button-icon").classList.remove("fas", "fa-check");
                    btn.querySelector(".button-icon").classList.add("fas", "fa-times");
                });
                this.classList.add("active");
                this.classList.remove("no-active");
                this.querySelector(".button-icon").classList.remove("fa-plus");
                this.querySelector(".button-icon").classList.add("fas", "fa-check");
                selectedWork = workId;
            }
            console.log("groupButtons ID:", selectedWork);
        });
    });

    // Language
    document.querySelectorAll(".employment-checkbox-language").forEach(function (checkbox) {
        checkbox.addEventListener("change", function () {
            var selectedCheckboxes = document.querySelectorAll(".employment-checkbox-language:checked");
            var selectedValues = Array.from(selectedCheckboxes).map(function (checkbox) {
                return checkbox.value;
            });
            console.log("Selected languages:", selectedValues.join(", "));
        });
    });

    document.querySelector("#checkbox_other").addEventListener("change", function () {
        var otherLanguageInput = document.querySelector("#add-language-block-rel");
        if (this.checked) {
            otherLanguageInput.style.display = "block";
        } else {
            otherLanguageInput.style.display = "none";
        }
    });





    //download image for gallery

    const uploadButton = document.getElementById('upload-photo-gallery-button');
    const photoInput = document.getElementById('photo-input');
    const gallery = document.getElementById('gallery');

    uploadButton.addEventListener('click', function (event) {
        event.preventDefault();
        photoInput.click();
    });

    photoInput.addEventListener('change', function () {
        const files = photoInput.files;

        if (files.length > 15) {
            alert('Please select up to 15 photos.');
            return;
        }

        gallery.innerHTML = '';

        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            const reader = new FileReader();

            reader.onload = function (event) {
                const imgContainer = document.createElement('div');
                imgContainer.classList.add('image-container');
                imgContainer.classList.add('draggable');

                const img = document.createElement('img');
                img.src = event.target.result;

                imgContainer.appendChild(img);

                const removeIcon = document.createElement('div');
                removeIcon.classList.add('image-container-remove');
                removeIcon.innerHTML = '<i class="fa fa-trash"></i>';
                imgContainer.appendChild(removeIcon);

                gallery.appendChild(imgContainer);
            };

            reader.readAsDataURL(file);
        }
    });

    //remove image from gallery
    gallery.addEventListener('click', function (event) {
        if (event.target.classList.contains('image-container-remove') || event.target.closest('.image-container-remove')) {
            const imgContainer = event.target.closest('.image-container');
            if (imgContainer) {
                imgContainer.remove();
            }
        }
    });


    var jobLocation = '';

    //auto complete fields address
    $('#job-same-as-company').on('change', function () {
        if ($(this).is(':checked')) {
            let locationCompany = $('#location_company_check').text().trim();
            let addressProfileCompany = $('#address_profile_company_check').text().trim();
            let addressStreetCompany = $('#address_street_company_check').text().trim();
            let buildingCompany = $('#building_company_check').text().trim();
            let zipCodeCompany = $('#zip_code_company_check').text().trim();

            $('#job-location').val(locationCompany);
            $('#job-city').val(addressProfileCompany);
            $('#job-street').val(addressStreetCompany);
            $('#job-building').val(buildingCompany);
            $('#job-zip-code').val(zipCodeCompany);

            $('#job-location').css('border', '1.5px solid #3964A6');
            $('#job-city').css('border', '1.5px solid #3964A6');
            $('#job-street').css('border', '1.5px solid #3964A6');
            $('#job-building').css('border', '1.5px solid #3964A6');
            $('#job-zip-code').css('border', '1.5px solid #3964A6');
        } else {
            $('#job-location').val('');
            $('#job-city').val('');
            $('#job-street').val('');
            $('#job-building').val('');
            $('#job-zip-code').val('');
        }
    });

    //select - other for step 3
    $('.approach-options #checkbox_191').change(function () {
        if ($(this).is(':checked')) {
            console.log('Other has been selected');
            $('.approach-options-optional').show();
        } else {
            console.log('Other has been deselected');
            $('.approach-options-optional').hide();
        }
    });



    //Block preview
    // Variables block
    var previewButtonBlock = document.getElementById("preview-button");

    var previewBlock = document.querySelector(".preview-mail-block");

    var customForm = document.getElementById("submit_custom_form");
    var headerBlockStaps = document.querySelector(".full-steps");
    var buttonBackNext = document.querySelector(".button-back-next");

    var buttonSavePublick = document.querySelector(".button-save-publick ");

    previewButtonBlock.addEventListener("click", function (event) {
        event.preventDefault();
        previewBlock.style.display = "block";
        customForm.style.display = "none";
        headerBlockStaps.style.display = "none";

        buttonBackNext.style.display = "none";

        buttonSavePublick.style.display = "flex";

        //auto complete fields for preview steps
        //step 1

        //Title
        const jobTitle = document.getElementById('job-title').value;

        //category value + name
        const jobCategorySelect = document.getElementById('job-category');
        const selectedOptionCategory = jobCategorySelect.options[jobCategorySelect.selectedIndex];
        const jobCategory = selectedOptionCategory.textContent;

        //location value + name
        const jobLocationValue = document.getElementById('job-location').value;
        const jobLocationSelect = document.getElementById('job-location');
        const selectedOption = jobLocationSelect.options[jobLocationSelect.selectedIndex];
        jobLocation = selectedOption.textContent;

        //job city
        const cityInput = document.getElementById('job-city');
        cityValue = cityInput.value;

        //job-street
        const streetAndBuildingInput = document.getElementById('job-street');
        const streetAndBuildingValue = streetAndBuildingInput.value;

        //job building
        const buildingInput = document.getElementById('job-building');
        const buildingValue = buildingInput.value;

        //job-zip-code
        const zipCodeInput = document.getElementById('job-zip-code');
        const zipCodeValue = zipCodeInput.value;

        //The same as the company location
        const checkboxCompanyLocation = document.getElementById('job-same-as-company');
        function checkCheckboxStatus() {
            if (checkboxCompanyLocation.checked) {
                console.log("Active company location");
            } else {
                console.log("No active company location.");
            }
        }
        checkCheckboxStatus();
        checkboxCompanyLocation.addEventListener('change', checkCheckboxStatus);

        //start work time
        const startTime = document.getElementById('selected-date-starts-on').value;
        formDateStart = formatDateString(startTime);


        //Apply deadline
        const selectedDate = document.getElementById('selected-date').value;
        formattedDate = formatDateString(selectedDate);

        //Immediate offer
        const checkboxImmediateOffer = document.getElementById('immediate-offer');
        let buttonTextUrgent = '';
        function checkCheckboxStatusImmediateOffer() {
            if (checkboxImmediateOffer.checked) {
                buttonTextUrgent = "Active Urgent";
                urgencyValue = true;
            } else {
                buttonTextUrgent = "-";
                urgencyValue = false;
            }
        }

        //Temporary position


        checkCheckboxStatusImmediateOffer();
        checkboxImmediateOffer.addEventListener('change', checkCheckboxStatusImmediateOffer);

        //Temporary position
        let buttonTextTemporary = '';
        const checkboxTemporaryPosition = document.getElementById('temporary-positio');
        function checkCheckboxStatusTemporaryPosition() {
            if (checkboxTemporaryPosition.checked) {
                temporaryValue = true;
                buttonTextTemporary = "Active Temporary";
                console.log("Active company location");

            } else {
                temporaryValue = false;
                buttonTextTemporary = "-";
                console.log("No active company location.");
            }
        }
        checkCheckboxStatusTemporaryPosition();
        checkboxTemporaryPosition.addEventListener('change', checkCheckboxStatusTemporaryPosition);


        //preview step 1
        const jobTitleElement = document.getElementById('job-title-value');
        const jobCategoryElement = document.getElementById('job-category-value');
        const jobLocationElement = document.getElementById('job-location-value');
        const jobStartElement = document.getElementById('job-start-value');
        const jobDedlineElement = document.getElementById('job-deadline-value');
        const jobUrgencyElement = document.getElementById('job-urgency-value');
        const jobTemporaryElement = document.getElementById('job-temporary-position-value');

        //Auto complete fields step 1
        jobTitleElement.textContent = jobTitle;
        jobCategoryElement.textContent = jobCategory;
        jobLocationElement.textContent = zipCodeValue + " " + cityValue + " " + streetAndBuildingValue + " " + buildingValue + " - " + jobLocation;
        jobStartElement.textContent = formDateStart;
        jobDedlineElement.textContent = formattedDate;
        jobUrgencyElement.textContent = buttonTextUrgent;
        jobTemporaryElement.textContent = buttonTextTemporary;


        // //step 2
        //job-contract-type
        const employmentButtonsContractType = document.querySelectorAll('.employment-button');
        let buttonTextContractType = '';
        employmentButtonsContractType.forEach(button => {
            if (button.classList.contains('active')) {
                buttonTextContractType = button.querySelector('.button-content').textContent.trim();
            }
        });

        //job-workload
        const employmentButtonsWorkload = document.querySelectorAll('.employment-button-work');
        let buttonTextWorkload = '';
        employmentButtonsWorkload.forEach(button => {
            if (button.classList.contains('active')) {
                buttonTextWorkload = button.querySelector('.button-content').textContent.trim();
            }
        });

        //% min and max
        const minInputValue = document.getElementById('minInput').value;
        const maxInputValue = document.getElementById('maxInput').value;

        //Working hourse
        timeInputStart = document.getElementById('time-start-wh').value;
        timeInputFinish = document.getElementById('time-finish-wh').value;
        const timeStartandFinish = timeInputStart + " - " + timeInputFinish;

        //Salary
        const jobStartSalery = document.getElementById('salary-from').value;
        const jobFinishSalery = document.getElementById('salary-to').value;
        let jobSalary = " ";
        if (jobFinishSalery == '') {
            jobSalary = jobStartSalery;
        } else {
            jobSalary = jobStartSalery + " - " + jobFinishSalery;
        }


        //Vacation
        const vacationDay = document.getElementById('count-d-w-vacation').value;
        const placeholderValue = document.getElementById('count-d-w-vacation').getAttribute('placeholder');
        const valueVacationSpanElement = $('.block-for-day-weeks span').text();
        const distributed = document.getElementById('input-vacation-distributed').value;

        //Other benefits
        const otherBenefistTextArea = document.getElementById('other-benefist-text-area').value;


        //preview step 2
        const jobContractTypeElement = document.getElementById('job-contract-type-value');
        const jobWorkloadElement = document.getElementById('job-workload-value');
        const jobWorkingHoursElement = document.getElementById('job-working-hours-value');
        const jobSalaryElement = document.getElementById('job-salary-value');
        const jobVacationElement = document.getElementById('job-vacation-value');
        const jobOtherBenefistElement = document.getElementById('job-other-benefits-value');

        //Auto complete fields step 2
        jobContractTypeElement.textContent = buttonTextContractType;
        jobWorkloadElement.textContent = minInputValue + " - " + maxInputValue + " %";
        jobWorkingHoursElement.textContent = timeStartandFinish;
        jobSalaryElement.textContent = jobSalary;
        jobVacationElement.textContent = vacationDay + " " + placeholderValue + " " + valueVacationSpanElement + " ; " + distributed;
        jobOtherBenefistElement.textContent = otherBenefistTextArea;

        //step 3
        //Approach
        var selectedValuesApproach = $('.approach-options .employment-checkbox:checked').map(function () {
            let value = $(this).val();
            let capitalizedWord = value.charAt(0).toUpperCase() + value.slice(1).toLowerCase();
            return capitalizedWord;
        }).get().join(", ");

        //teaching_approach_additionally
        const checkboxTeachingApproachAdditionally = document.getElementById('input-approach').value;

        //age group
        const selectedAgeMonths = document.getElementById('months-old').value;
        const selectedAgeYear = document.getElementById('year-old').value;
        const activeButton = document.querySelector('#employment-buttons .employment-button-group.active').querySelector('.button-content').textContent.trim();
        let selectedAgeText = '';
        if (window.location.pathname.indexOf('/de/') !== -1) {
            if (selectedAgeYear == '') {
                selectedAgeText = selectedAgeMonths + " jahre";
            } else {
                selectedAgeText = selectedAgeMonths + " - " + selectedAgeYear + " jahre";
            }

        } else {
            if (selectedAgeYear == '') {
                selectedAgeText = selectedAgeMonths + " years";
            } else {
                selectedAgeText = selectedAgeMonths + " - " + selectedAgeYear + " years";
            }
        }
        //Language
        const languageOptions = document.querySelectorAll('.employment-checkbox-language:checked');
        let buttonTextLanguage = '';
        languageOptions.forEach(checkbox => {
            let capitalizedWord = checkbox.value.charAt(0).toUpperCase() + checkbox.value.slice(1).toLowerCase();
            buttonTextLanguage += capitalizedWord + ", ";
        });

        buttonTextLanguage = buttonTextLanguage.slice(0, -2);


        //preview step 3
        const jobApproachElement = document.getElementById('job-approach-value');
        const jobApproachElementAdditionally = document.getElementById('job-approach-value-additionally');
        const jobApproachOptionsElement = document.getElementById('job-approach-options-value');
        const jobLanguageElement = document.getElementById('job-language-value');


        //Auto complete fields step 3
        jobApproachElement.innerHTML = selectedValuesApproach;
        jobApproachElementAdditionally.textContent = checkboxTeachingApproachAdditionally;
        jobApproachOptionsElement.textContent = activeButton + " " + selectedAgeText;
        jobLanguageElement.textContent = buttonTextLanguage;


        //step 4
        //description
        let iframeContent = '';

        const iframeElement = document.getElementById('job-description-describe-required-editor_ifr');
        const iframeContentDocument = iframeElement.contentDocument;
        if (iframeContentDocument) {
            const iframeBody = iframeContentDocument.body;
            if (iframeBody) {
                iframeContent = iframeBody.innerHTML;
                console.log(iframeContent);
            } else {
                console.error('Document body not found in iframe.');
            }
        } else {
            console.error('Iframe content not found.');
        }

        //skills
        let skillsIframeContent = '';

        const skillsIframeElement = document.getElementById('job-description-describe-skills_ifr');
        const skillsIframeContentDocument = skillsIframeElement.contentDocument;
        if (skillsIframeContentDocument) {
            const skillsIframeBody = skillsIframeContentDocument.body;
            if (skillsIframeBody) {
                skillsIframeContent = skillsIframeBody.innerHTML;
                console.log(skillsIframeContent);
            } else {
                console.error('Document body not found in skills iframe.');
            }
        } else {
            console.error('Skills iframe content not found.');
        }

        //responsibilities
        let createListIframeContent = '';

        const createListIframeElement = document.getElementById('job-description-describe-create-list_ifr');
        const createListIframeContentDocument = createListIframeElement.contentDocument;
        if (createListIframeContentDocument) {
            const createListIframeBody = createListIframeContentDocument.body;
            if (createListIframeBody) {
                createListIframeContent = createListIframeBody.innerHTML;
                console.log(createListIframeContent);
            } else {
                console.error('Document body not found in create list iframe.');
            }
        } else {
            console.error('Create list iframe content not found.');
        }

        //description-describe-benefits
        let benefitsIframeContent = '';

        const benefitsIframeElement = document.getElementById('job-description-describe-benefits_ifr');
        const benefitsIframeContentDocument = benefitsIframeElement.contentDocument;
        if (benefitsIframeContentDocument) {
            const benefitsIframeBody = benefitsIframeContentDocument.body;
            if (benefitsIframeBody) {
                benefitsIframeContent = benefitsIframeBody.innerHTML;
                console.log(benefitsIframeContent);
            } else {
                console.error('Document body not found in benefits iframe.');
            }
        } else {
            console.error('Benefits iframe content not found.');
        }

        //description-describe-mention
        let mentionIframeContent = '';

        const mentionIframeElement = document.getElementById('job-description-describe-mention_ifr');
        const mentionIframeContentDocument = mentionIframeElement.contentDocument;
        if (mentionIframeContentDocument) {
            const mentionIframeBody = mentionIframeContentDocument.body;
            if (mentionIframeBody) {
                mentionIframeContent = mentionIframeBody.innerHTML;
                console.log(mentionIframeContent);
            } else {
                console.error('Document body not found in mention iframe.');
            }
        } else {
            console.error('Mention iframe content not found.');
        }

        let mentionApplyingProcess = '';
        const mentionApplyingProcessElement = document.getElementById('job-description-applying-process_ifr');
        const mentionApplyingProcessContentDocument = mentionApplyingProcessElement.contentDocument;
        if (mentionApplyingProcessContentDocument) {
            const mentionApplyingProcessBody = mentionApplyingProcessContentDocument.body;
            if (mentionApplyingProcessBody) {
                mentionApplyingProcess = mentionApplyingProcessBody.innerHTML;
                console.log(mentionApplyingProcess);
            } else {
                console.error('Document body not found in mention iframe.');
            }
        } else {
            console.error('Mention iframe content not found.');
        }

        let mentionAboutCompany = '';
        const mentionAboutCompanyElement = document.getElementById('job-description-about_company_ifr');
        const mentionAboutCompanyContentDocument = mentionAboutCompanyElement.contentDocument;
        if (mentionAboutCompanyContentDocument) {
            const mentionAboutCompanyBody = mentionAboutCompanyContentDocument.body;
            if (mentionAboutCompanyBody) {
                mentionAboutCompany = mentionAboutCompanyBody.innerHTML;
                console.log(mentionAboutCompany);
            } else {
                console.error('Document body not found in mention iframe.');
            }
        } else {
            console.error('Mention iframe content not found.');
        }

        //preview step 5
        const jobRequirementsElement = document.getElementById('job-requirements-value');
        const jobNiceToHaveElement = document.getElementById('job-nice-to-have-value');
        const jobResponsibilitiesElement = document.getElementById('job-responsibilities-value');
        const jobBenefitsElement = document.getElementById('job-benefits-value');
        const jobOtherDetailsElement = document.getElementById('job-other-details-value');
        const jobApplyingProcess = document.getElementById('job-applying-process-value');
        const jobAboutCompany = document.getElementById('job-about-company-value');

        //Auto complete fields step 5
        jobRequirementsElement.innerHTML = iframeContent;
        jobNiceToHaveElement.innerHTML = skillsIframeContent;
        jobResponsibilitiesElement.innerHTML = createListIframeContent;
        jobBenefitsElement.innerHTML = benefitsIframeContent;
        jobOtherDetailsElement.innerHTML = mentionIframeContent;
        jobApplyingProcess.innerHTML = mentionApplyingProcess;
        jobAboutCompany.innerHTML = mentionAboutCompany;

        //gallery
        galleryImages = [];
        const gallery = document.getElementById('gallery');
        const galleryCopy = gallery.cloneNode(true);
        const galleryPreview = document.getElementById('gallery-preview');
        galleryPreview.innerHTML = '';
        galleryPreview.insertBefore(galleryCopy, galleryPreview.firstChild);

        galleryImages = Array.from(gallery.querySelectorAll('.image-container img')).map(img => img.src);

        //end auto complete fields for preview steps
    });

    //preview steps
    //staep 1
    const Firstlink = document.getElementById('first-step');
    Firstlink.addEventListener('click', function (event) {
        event.preventDefault();
        previewBlock.style.display = "none";
        customForm.style.display = "block";
        headerBlockStaps.style.display = "flex";
        buttonBackNext.style.display = "flex";
        buttonSavePublick.style.display = "none";
        steps[0].click();
    });

    //step 2
    const secondlink = document.getElementById('second-step');
    secondlink.addEventListener('click', function (event) {
        event.preventDefault();
        previewBlock.style.display = "none";
        customForm.style.display = "block";
        headerBlockStaps.style.display = "flex";
        buttonBackNext.style.display = "flex";
        buttonSavePublick.style.display = "none";
        steps[1].click();
    });

    //step 3
    const treeLink = document.getElementById('tree-step');
    treeLink.addEventListener('click', function (event) {
        event.preventDefault();
        previewBlock.style.display = "none";
        customForm.style.display = "block";
        headerBlockStaps.style.display = "flex";
        buttonBackNext.style.display = "flex";
        buttonSavePublick.style.display = "none";
        steps[2].click();
    });

    //step 4
    const fourLink = document.getElementById('fourth-step');
    fourLink.addEventListener('click', function (event) {
        event.preventDefault();
        previewBlock.style.display = "none";
        customForm.style.display = "block";
        headerBlockStaps.style.display = "flex";
        buttonBackNext.style.display = "flex";
        buttonSavePublick.style.display = "none";
        steps[3].click();
    });

    //step 5
    //function for data format
    function formatDateString(dateString) {
        const dateComponents = dateString.split('-');
        const year = dateComponents[0];
        const month = dateComponents[1];
        const day = dateComponents[2];

        const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ];

        return `${day} ${monthNames[parseInt(month) - 1]} ${year}`;
    }


    //gallery
    async function processBase64Images(base64Images) {
        const images = [];
        for (let i = 0; i < base64Images.length; i++) {
            try {
                const image = await createImageFromBase64(base64Images[i]);
                images.push(image);
            } catch (error) {
                console.error('Error:', error);
            }
        }
        return images;
    }

    function createImageFromBase64(base64String) {
        return new Promise((resolve, reject) => {
            const image = new Image();
            image.onload = () => resolve(image);
            image.onerror = reject;
            image.src = base64String;
        });
    }

    //send data to server
    const publishButton = document.querySelector('a.button-publish');

    const nextFinalButtonPublis = document.querySelector('.button-next-final');
    nextFinalButtonPublis.addEventListener('click', function (event) {

        event.preventDefault();
        if (validateFormStep4()) {
            previewButtonBlock.click();
            publishButton.click();
            $(".preview-mail-block").css('display', 'none');
            $("form#submit_custom_form").css('display', 'block');
            $('div#step-4').css('display', 'block');
        }
    });

    publishButton.addEventListener('click', async function (event) {
        //gallery
        const images = await processBase64Images(galleryImages);
        const base64Images = images.map(image => image.src);
        event.preventDefault();

        let languagePost = document.documentElement.lang;

        if (languagePost === 'de-DE') {
            languagePost = 'de';
        } else {
            languagePost = 'en';
        }

        //object for data
        const formData = {
            //step 1
            title: document.getElementById('job-title-value').textContent,
            category: document.getElementById('job-category-value').textContent,
            location: document.getElementById('job-location-value').textContent,
            city: cityValue,
            startOn: formDateStart,
            startOf: formattedDate,
            urgency: urgencyValue,
            temporary: temporaryValue,
            languagePost: languagePost,

            //step 2
            contractType: document.getElementById('job-contract-type-value').textContent,
            workload: document.getElementById('job-workload-value').textContent,
            workLoadMin: document.getElementById('minInput').value, //need check
            workLoadMax: document.getElementById('maxInput').value, //need check
            time: document.getElementById('job-working-hours-value').textContent,
            timeStart: timeInputStart,
            timeFinish: timeInputFinish,
            salary: document.getElementById('job-salary-value').textContent,
            vacation: document.getElementById('job-vacation-value').textContent,
            otherBenefits: document.getElementById('job-other-benefits-value').textContent,

            //step 3
            approach: document.getElementById('job-approach-value').textContent,
            approachAdditionally: document.getElementById('job-approach-value-additionally').textContent,
            approachOptions: document.getElementById('job-approach-options-value').textContent,
            language: document.getElementById('job-language-value').textContent,

            //step 4
            requirements: document.getElementById('job-requirements-value').innerHTML,
            niceToHave: document.getElementById('job-nice-to-have-value').innerHTML,
            responsibilities: document.getElementById('job-responsibilities-value').innerHTML,
            benefits: document.getElementById('job-benefits-value').innerHTML,
            otherDetails: document.getElementById('job-other-details-value').innerHTML,
            applyingProcess: document.getElementById('job-applying-process-value').innerHTML,
            aboutCompany: document.getElementById('job-about-company-value').innerHTML,
            galleryImages: base64Images,

            // timeStart: document.getElementById('time-start-wh').value, //need check
            //timeFinish: document.getElementById('time-finish-wh').value, //need check
        };

        let lang = document.documentElement.lang;

        jQuery.ajax({
            url: myAjax.ajaxurl,
            method: 'POST',
            data: {
                action: 'process_form_data',
                formData: formData
            },
            success: function (response) {
                console.log('Form data sent successfully.');
                if (lang === "en-US") {
                    window.location.href = '/searchjobs';
                } else if (lang === "de-DE") {
                    window.location.href = 'de/jobsuche/';
                }

            },
            error: function (error) {
                console.error('Failed to send form data.');
                console.error(error);
            }
        });

        // window.location.reload(true);

    });
});


//send form registration compamy
$(document).ready(function () {
    $('button.create-a-profile').click(function (event) {
        event.preventDefault();

        let formData = {
            companyName: $('#company-name').val(),
            companyLocation: $('#company-canton').val(),
            companyCity: $('#company-city').val(),
            companyStreetAndBuilding: $('#company-street-and-building').val(),
            companyZipCode: $('#company-zip-code').val(),
            companySize: $('#company-size').val(),
            companyWebsite: $('#company-website').val(),
            userEmail: $('#company-email').val(),
            userFullName: $('#company-full-name').val(),
            userPhoneNumber: $('#company-phone-number').val()
        };

        //step 1 - registration user
        jQuery.ajax({
            url: myAjax.ajaxurl,
            method: 'POST',
            data: {
                action: 'process_registration_user',
                userEmail: formData.userEmail,
                userFullName: formData.userFullName,
                userPhoneNumber: formData.userPhoneNumber,
            },
            success: function (response) {
                console.log('Form data sent successfully.');
            },
            error: function (error) {
                console.error('Failed to send form data.');
                console.error(error);
            }
        });


    });

    //select amount_type range/exact
    $('input[name="amount_type"]:checked').parent().addClass('active');

    $('input[name="amount_type"]').on('change', function () {
        $('.text-rage-exactAmount').removeClass('active');
        if ($(this).is(':checked')) {
            $(this).parent().addClass('active');

            if ($(this).val() === 'exact') {
                $('div#salary-block-none').css('display', 'none');
                $('#salary-to').val('');
                $('.hide-from-for-p').css('display', 'none');
            } else {
                $('div#salary-block-none').css('display', 'flex');
                $('.hide-from-for-p').css('display', 'block');
            }

        }
    });

    //select date_type days/weeks
    $('input[name="date_type"]:checked').parent().addClass('active');

    $('input[name="date_type"]').on('change', function () {
        $('.text-rage-exactDate').removeClass('active');
        if ($(this).is(':checked')) {
            $(this).parent().addClass('active');
            console.log($(this).val());
            if ($(this).val() === 'days') {
                // $('.block-for-day-weeks span').text('Days');
                $('.block-for-day-weeks input').attr("placeholder", "Days");
            } else {
                // $('.block-for-day-weeks span').text('Weeks');
                $('.block-for-day-weeks input').attr("placeholder", "Weeks");
            }
        }
    });

    //count simbols in input-vacation-distributed
    const inputField = document.getElementById('input-vacation-distributed');
    const countSpan = document.querySelector('.count-symbol-for-block-for-comments');
    function updateCharacterCount() {
        const lengthOfInput = inputField.value.length;
        const maxChars = inputField.maxLength;
        countSpan.textContent = `${lengthOfInput}/${maxChars} symbols used`;
    }

    updateCharacterCount();

    inputField.addEventListener('input', updateCharacterCount);

    //check 100 symbols for - E.g., Montessori should be present in pedagogical work and consciously implemented
    var inputApproach = document.getElementById('input-approach');
    var counterApproach = document.getElementById('input-approach-check');

    function updateApproachCount() {
        const lengthOfInput = inputApproach.value.length;
        const maxChars = inputApproach.maxLength;
        counterApproach.textContent = `${lengthOfInput}/${maxChars} symbols used`;
    }

    updateApproachCount();

    inputApproach.addEventListener('input', updateApproachCount);



});
