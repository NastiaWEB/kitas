
jQuery(document).ready(function ($) {
	//getting query vars
	var link = new URL(window.location.href);
	var today = new Date().toISOString().split('T')[0];
	var selectedPeriod = link.searchParams.get("periodFilter") ? link.searchParams.get("periodFilter").toString().split('|') : []; //selected period of publication, used in php for filtering
	var displayedPeriod = link.searchParams.get("periodDisplay") ? link.searchParams.get("periodDisplay").toString().split('|') : []; //displayed period of publication, used to be displayed on the chip
	var selectedTypes = link.searchParams.get("employment_type") ? link.searchParams.get("employment_type").toString().split('|') : [];	 //employment type
	var selectedLangs = link.searchParams.get("langFilter") ? link.searchParams.getAll("langFilter").toString().split('|') : []; //languages needed for the job
	var selectedLocs = link.searchParams.get("locFilter") ? link.searchParams.getAll("locFilter").toString().split('|') : []; //locations
	var selectedCats = link.searchParams.get("catFilter") ? link.searchParams.getAll("catFilter").toString().split('|') : []; //job categories
	var selectedDate = link.searchParams.get("dateFilter") ? link.searchParams.getAll("dateFilter").toString() : ''; //date after which the job starts
	var whatTerm = link.searchParams.get("whatTermFilter") ? link.searchParams.getAll("whatTermFilter").toString() : ''; //which term we're searching: title or company?
	var searchName = link.searchParams.get("searchNameFilter") ? link.searchParams.getAll("searchNameFilter").toString() : ''; //search query from "What" field
	var minLoad = link.searchParams.get("minLoadFilter") ? link.searchParams.getAll("minLoadFilter").toString() : ''; //minimum workload from range
	var maxLoad = link.searchParams.get("maxLoadFilter") ? link.searchParams.getAll("maxLoadFilter").toString() : ''; //maximum workload from range
	var locSearchBar = link.searchParams.get("locSearch") ? link.searchParams.getAll("locSearch").toString().split('|') : []; //location search bar
	var paged = link.searchParams.get("currentPage") ? link.searchParams.getAll("currentPage").toString() : 1; //"paged" var from wp analog
	var is_load_more = 0; //check if user clicked pagination link or load more link
	var list = localStorage.getItem('featuredList') ? localStorage.getItem('featuredList').split(',') : []; //featured jobs list
	var selectedWorkload = link.searchParams.get("workloadFilter") ? link.searchParams.get("workloadFilter").toString().split('|') : [];
	var displayedWorkload = link.searchParams.get("workloadDisplay") ? link.searchParams.get("workloadDisplay").toString().split('|') : [];
	var filteredList = []; //used for deleting items from localstorage
	let pageLang = $('html').attr('lang');


	//AJAX call for "Featured Jobs" page
	if (window.location.href.toString().includes('featured-jobs')) {
		$.ajax({
			dataType: 'json',
			url: myAjax.ajaxurl,
			type: 'POST',
			data: {
				action: 'featured_jobs',
				featured: list,
			},
			beforeSend: function () {
				$('img#preloader').css('display', 'block');
				$('.lds-dual-ring').addClass('active');
			},
			success: function (filtered) {
				$('img#preloader').hide();
				$('.lds-dual-ring').removeClass('active');
				//unitializing slick slider for proper working
				$('.your-class').slick('slickRemove');

				//rendering filtered loop
				if (is_load_more == 0) {
					$('#jobsList').html(''); //if it's just a query, we reset loop
				}
				if (is_load_more == 1) {
					$('.pagination-links').css('display', 'none'); //if we clicked load more btn, we hide existing pagination links
					$('.button-container').css('display', 'none');
				}
				$('#jobsList').append(filtered.response); //and then render queried posts

				if (filtered.noMore == 1) {
					$('.load-more').hide(); //if there are no more jobs, we hide load more btn
				}

				//initializing slick slider again
				$('.your-class').not('.slick-initialized').slick({
					dots: true,
					infinite: true,
					arrows: true
				});
				is_load_more = 0;
			},
			complete: function () {
				$('img#preloader').hide();
				$('.lds-dual-ring').removeClass('active');
				$('.job-card').each(function () {
					if (list.includes($(this).data('postid').toString())) {
						$(this).find('.featuredToggle g').css('fill', '#07496E');
					}
				});
			}
		});



	}

	//handling feature button clicks
	function checkFeaturedToggle() {
		var featuredList = localStorage.getItem('featuredList');
		featuredList = featuredList ? featuredList.split(',') : [];

		var originalSrc = "/wp-content/themes/kitas-landing-theme/img/bookmark.svg";
		var newSrc = "/wp-content/themes/kitas-landing-theme/img/bookmark1.svg";

		function getPostIdFromBody() {
			var bodyClass = $('body').attr('class');
			var match = bodyClass.match(/postid-(\d+)/);
			return match ? match[1] : null;
		}

		//handling feature button clicks
		$(document).on("click", '.featuredToggle', function () {
			var data = $(this).closest('.job-card').data('postid') || $(this).closest('.job-card-main').data('postid') || getPostIdFromBody();

			var img = $(this).find('img');

			if (!featuredList.includes(data)) {
				featuredList.push(data);
			} else {
				featuredList = featuredList.filter(function (e) { return e !== data });
			}

			localStorage.setItem('featuredList', featuredList.join(','));

			// Update all buttons with the same postid
			updateFeaturedButtons(data);
		});

		function updateFeaturedButtons(postId) {
			$('.job-card, .reactions').each(function () {
				var currentPostId = $(this).closest('.job-card').data('postid') || $(this).closest('.job-card-main').data('postid') || getPostIdFromBody();
				var img = $(this).find('.featuredToggle img');

				if (currentPostId.toString() === postId.toString()) {
					if (featuredList.includes(postId)) {
						img.attr('src', newSrc);
					} else {
						img.attr('src', originalSrc);
					}
				}
			});
		}

		// Initialize buttons on page load
		$('.job-card, .reactions').each(function () {
			var postId = $(this).closest('.job-card').data('postid') || $(this).closest('.job-card-main').data('postid') || getPostIdFromBody();
			var img = $(this).find('.featuredToggle img');

			if (featuredList.includes(postId.toString())) {
				img.attr('src', newSrc);
			} else {
				img.attr('src', originalSrc);
			}
		});
	}


	checkFeaturedToggle();


	function checkLikeOrDislike() {
		var dislikeList = localStorage.getItem('dislikeList');
		dislikeList = dislikeList ? dislikeList.split(',') : [];

		var originalSrc = "/wp-content/themes/kitas-landing-theme/img/dislike.svg";
		var newSrc = "/wp-content/themes/kitas-landing-theme/img/dislikeblack.svg";

		function getPostIdFromBodyDes() {
			var bodyClass = $('body').attr('class');
			var match = bodyClass.match(/postid-(\d+)/);
			return match ? match[1] : null;
		}

		$(document).on("click", '.dislike-job', function () {
			var data = $(this).closest('.job-card').data('postid');
			data = data ? data.toString() : (getPostIdFromBodyDes() || '');
			var img = $(this).find('img');

			if (!dislikeList.includes(data)) {
				dislikeList.push(data);
			} else {
				dislikeList = dislikeList.filter(function (e) { return e !== data });
			}

			localStorage.setItem('dislikeList', dislikeList.join(','));

			// Update all dislike buttons with the same postid
			updateDislikeButtons(data);
		});

		function updateDislikeButtons(postId) {
			$('.job-card, .reactions').each(function () {
				var currentPostId = $(this).closest('.job-card').data('postid');
				currentPostId = currentPostId ? currentPostId.toString() : (getPostIdFromBodyDes() || '');
				var img = $(this).find('.dislike-job img');

				if (currentPostId === postId) {
					if (dislikeList.includes(postId)) {
						img.attr('src', newSrc);
					} else {
						img.attr('src', originalSrc);
					}
				}
			});
		}

		// Initialize buttons on page load
		$('.job-card, .reactions').each(function () {
			var postId = $(this).closest('.job-card').data('postid');
			postId = postId ? postId.toString() : (getPostIdFromBodyDes() || '');
			var img = $(this).find('.dislike-job img');

			if (dislikeList.includes(postId)) {
				img.attr('src', newSrc);
			} else {
				img.attr('src', originalSrc);
			}
		});
	}


	checkLikeOrDislike();


	$(document).on('click', '.pagination-links a', function (e) {
		setTimeout(() => {
			checkFeaturedToggle();
			checkLikeOrDislike();
		}, 1200);
	});

	$(document).on('click', '.load-more', function (e) {
		setTimeout(() => {
			checkFeaturedToggle();
			checkLikeOrDislike();
		}, 1200);
	});


	//check if job is featured
	$('.job-card').each(function () {
		if (list.includes($(this).data('postid').toString())) {
			$(this).find('.featuredToggle g').css('fill', '#07496E');
		}
	});

	//setting up lang parameter for jobs filter(queries only posts in the said language)
	var url = window.location.href;
	var lang = 'en' //by default language is English
	if (url.indexOf('/de') !== -1) {
		lang = 'de';

	}
	link.searchParams.set("current_locale", lang);

	//getting chips on page load
	chipsRender();

	//application form modal size changes and timeouts

	//open and close modal send CV form
	// $(document).on("click", function (event) {
	// 	if ($(event.target).hasClass("applicationToggle")) {
	// 		$('.modal-form-send-cv').addClass("show");
	// 	} else {
	// 		if ($('.modal-form-send-cv').hasClass("show")) {
	// 			if (!$(event.target).closest('.modal-form-send-cv-content').length) {
	// 				$('.modal-form-send-cv').removeClass("show");
	// 			}
	// 		}
	// 	}

	// 	//swap blocks send
	// 	let firstBlock = $('.penultimate-block-form');
	// 	let lastBlock = $('.last-block-form');
	// 	lastBlock.before(firstBlock);
	// });
	$(document).on("click", '.modal-close', function () {
		$('.modal-form-send-cv').removeClass("show");
	});

	//show textareas in application form
	$('.modal-form-send-cv-content .check-compose-cover-letter').click(function () {
		var displayValue = $('.modal-form-send-cv-content .hide-compose-cover-letter').css('display');
		if (displayValue === 'none') {
			$('.modal-form-send-cv-content .hide-compose-cover-letter').css({
				'display': 'block',
				'border': '1px solid #7C95BB',
				'margin-bottom': '16px'
			});
		} else {
			$('.modal-form-send-cv-content .hide-compose-cover-letter').css('display', 'none');
		}
	});

	$(document).on("click", '.lwa-links-register-inline', function () {
		$('.modal-content').css('height', 'auto');
	}); //registration form

	$(document).on("click", '.button-primary', function () {
		$('.modal-content').css('height', '490px'); //register btn click
		setTimeout(function () {
			$('.lwa-status-confirm').attr("style", "display:none!important");
			$('.lwa-status-invalid').attr("style", "display:none!important");
			$('.modal-content').css('height', '425px');
		}, 1500); //timeout for the form to get to the normal state
	});

	$(document).on("click", '.login-btn', function () {
		$('.modal-content').css('height', '370px'); //login btn click
		setTimeout(function () {
			$('.lwa-status-confirm').attr("style", "display:none!important");
			$('.lwa-status-invalid').attr("style", "display:none!important");
			$('.modal-content').css('height', '300px');
		}, 1500); //timeout for the form to get to the normal state
	});

	$(document).on("click", '.lwa-links-register-inline-cancel', function () {
		$('.modal-content').css('height', '300px');
	}); //going back to login form

	$(document).on("click", '.wpcf7-submit', function () {
		$('.modal-content').css('height', 'auto');
	}); //application form submission

	$(document).on("click", '.close', function () {
		$('.modal-content').css('height', '384px');
		$('.modal').removeClass("show");

		$("#lwa-1").css('display', 'none');
		$(".cf7sg-container.cf7sg-not-grid").css('display', 'block');
	}); //closing modal

	$(document).on("change", '#application-file-upload', function () {
		var file = $('#application-file-upload')[0].files[0].name;
		$('.custom-file-upload p.attach-caption').html('<i class="fa-solid fa-paperclip"></i> ' + file);
	}); //setting the title of attachment block to the name of attached file

	$(document).on('wpcf7submit', function (event) {
		$('.custom-file-upload p.attach-caption').html('<i class="fa-solid fa-paperclip"></i> Attach your CV file');
		setTimeout(function () {
			$('form.wpcf7-form').removeClass('sent');
			$('form.wpcf7-form').removeClass('failed');
			$('form.wpcf7-form').addClass('init');
			$('.screen-reader-response').attr('style', 'display:none!important;');
			$('.modal-content').css('height', '384px');
		}, 1500);
	}); //resetting form on submission


	//Slick slider
	$('.your-class').slick({
		dots: true,
		infinite: true,
		arrows: true
	});

	//datepicker setup
	$('#startDate').attr('min', today);

	//range picker setup
	function rangepickerSetup() {
		minLoad = '';
		maxLoad = '';
	}

	rangepickerSetup(); //confirming workload filter

	$(document).on("change", '#workloadSelect input[type="checkbox"]', function () {
		var filterJobDiv = $(this).closest('div.filter-job');
		var labels = filterJobDiv.find('label');
		selectedWorkload = [];
		var displayedWorkload = [];
		paged = 1;

		function checkValueDataAttr() {
			let dataMinValueDefault = 100;
			let dataMaxValueDefault = 0;
			let anyChecked = false;

			labels.each(function () {
				var checkbox = $(this).find('input[type="checkbox"]');
				if (checkbox.is(':checked')) {
					anyChecked = true;
					let dataminValue = $(this).find('p.item-title').data('min');
					let datamaxValue = $(this).find('p.item-title').data('max');

					if (dataminValue < dataMinValueDefault) {
						dataMinValueDefault = dataminValue;
					}

					if (datamaxValue > dataMaxValueDefault) {
						dataMaxValueDefault = datamaxValue;
					}
				}
			});

			if (!anyChecked) {
				dataMinValueDefault = 0;
				dataMaxValueDefault = 100;
			}

			minLoad = dataMinValueDefault;
			maxLoad = dataMaxValueDefault;
		}



		checkValueDataAttr();

		for (i = 0; i < labels.length; i++) {
			if ($(labels[i]).find('input').is(':checked')) {
				selectedWorkload.push($(labels[i]).find('p.item-title').data('term'));
				displayedWorkload.push($(labels[i]).find('p.item-title').html().trim());
			}
		}
		filtersAndSearch();
	});


	//employment type filter setup, if input is checked, we append array with a respective value
	$(document).on("change", '#employmentTypeConfirm input[type="checkbox"]', function () {
		var filterJobDiv = $(this).closest('div.filter-job');
		var labels = filterJobDiv.find('label');
		selectedTypes = [];
		paged = 1;

		for (i = 0; i < labels.length; i++) {
			if ($(labels[i]).find('input').is(':checked')) {
				selectedTypes.push($(labels[i]).find('p.item-title').data('term'));
			}
		}
		filtersAndSearch();
	});

	//language filter setup, if input is checked, we append array with a respective value
	$(document).on("change", '#langConfirm input[type="checkbox"]', function () {
		var filterJobDiv = $(this).closest('div.filter-job');
		var labels = filterJobDiv.find('label');
		selectedLangs = [];
		paged = 1;

		for (i = 0; i < labels.length; i++) {
			if ($(labels[i]).find('input').is(':checked')) {
				selectedLangs.push($(labels[i]).find('p.item-title').data('term'));
			}
		}
		filtersAndSearch();
	});

	//category filter setup, if input is checked, we append array with a respective value
	$(document).on("change", '#catConfirm input[type="checkbox"]', function () {
		var filterJobDiv = $(this).closest('li');
		var labels = filterJobDiv.find('label');
		selectedCats = [];
		paged = 1;

		for (i = 0; i < labels.length; i++) {
			if ($(labels[i]).find('input').is(':checked')) {
				selectedCats.push($(labels[i]).find('p.item-title').data('term'));

			}
		}
		filtersAndSearch();
	});

	//location filter setup, if input is checked, we append array with a respective value
	$(document).on("change", '#locationsConfirm input[type="checkbox"]', function () {
		var filterJobDiv = $(this).closest('div.filter-job');
		var labels = filterJobDiv.find('label');
		selectedLocs = [];
		paged = 1;

		for (i = 0; i < labels.length; i++) {
			if ($(labels[i]).find('input').is(':checked')) {
				selectedLocs.push($(labels[i]).find('p.item-title').data('term'));
			}
		}
		if ($('#whereInput').val().trim().length > 0) {
			locSearchBar = $('#whereInput').val();
		}
		filtersAndSearch();
	});

	//period of publication filter setup, if a certain input is checked, we append both arrays with a respective value
	$(document).on("change", '#dateOfPostConfirm input[type="checkbox"]', function () {
		var filterJobDiv = $(this).closest('div.filter-job');
		var labels = filterJobDiv.find('label');
		selectedPeriod = [];
		displayedPeriod = [];
		paged = 1;

		for (i = 0; i < labels.length; i++) {
			//last 24 hours option
			if ($(labels[i]).find('input#lastDayFilter').is(':checked')) {
				selectedPeriod.push('after-1-day-ago');
				displayedPeriod.push($(labels[i]).find('p.item-title.lastDay').html().trim());

			}
			//last week option
			if ($(labels[i]).find('input#lastWeekFilter').is(':checked')) {
				selectedPeriod.push('after-1-week-ago');
				displayedPeriod.push($(labels[i]).find('p.item-title.lastWeek').html().trim());

			}
			//more then 1 week ago option
			if ($(labels[i]).find('input#moreThanWeekFilter').is(':checked')) {
				selectedPeriod.push('before-1-week-ago');
				displayedPeriod.push($(labels[i]).find('p.item-title.moreThanWeek').html().trim());

			}
		}
		filtersAndSearch();
	});

	// id startsAfterConfirm
	$('#startDate').on('change', function () {
		var selectedDate = $(this).val();
		console.log(selectedDate);
		if (selectedDate.length > 0) {
			$('#startsAfterConfirm').click();
		}

		$('.label-container p[data-term="' + selectedDate + '"]').each(function () {
			$(this).closest('.label-container').find('input[type="checkbox"]').removeAttr('checked');
		});

	});

	//reset buttons setup for different types of filters
	$(document).on("click", '.emplTypeReset', function () {
		var toReset = $(this).parent().find('p').data('term');
		selectedTypes = $.grep(selectedTypes, function (value) {
			return value != toReset;
		});

		$('.label-container p[data-term="' + toReset + '"]').each(function () {
			$(this).closest('.label-container').find('input[type="checkbox"]').removeAttr('checked');
		});
		//updateLinkStyles();
	}); //epmloyment type reset, the clicked button's value is excluded from array

	$(document).on("click", '.langReset', function () {
		var toReset = $(this).parent().find('p').data('term');
		selectedLangs = $.grep(selectedLangs, function (value) {
			return value != toReset;
		});

		$('.label-container p[data-term="' + toReset + '"]').each(function () {
			$(this).closest('.label-container').find('input[type="checkbox"]').removeAttr('checked');
		});
		//updateLinkStyles();
	}); //language reset, the clicked button's value is excluded from array

	$(document).on("click", '.catReset', function () {
		var toReset = $(this).parent().find('p').data('term');
		selectedCats = $.grep(selectedCats, function (value) {
			return value != toReset;
		});

		$('.label-container p[data-term="' + toReset + '"]').each(function () {
			$(this).closest('.label-container').find('input[type="checkbox"]').removeAttr('checked');
		});
		//updateLinkStyles();
	}); //category reset, the clicked button's value is excluded from array

	//reset buttons setup for different types of filters
	$(document).on("click", '.locReset', function () {
		var toReset = $(this).parent().find('p').data('term');
		selectedLocs = $.grep(selectedLocs, function (value) {
			return value != toReset;
		});

		$('.label-container p[data-term="' + toReset + '"]').each(function () {
			$(this).closest('.label-container').find('input[type="checkbox"]').removeAttr('checked');
		});
		//	updateLinkStyles();
	}); //location reset, the clicked button's value is excluded from array

	$(document).on("click", '.periodReset', function () {
		var toResetBack = $(this).parent().find('p').data('term');
		var toResetFront = $(this).parent().find('p').html();

		selectedPeriod = $.grep(selectedPeriod, function (value) {
			return value != toResetBack && value != toResetFront;
		});

		$('.label-container p[data-term="' + toResetBack + '"]').each(function () {
			$(this).closest('.label-container').find('input[type="checkbox"]').removeAttr('checked');
		});

		$('.label-container p[data-term="' + toResetFront + '"]').each(function () {
			$(this).closest('.label-container').find('input[type="checkbox"]').removeAttr('checked');
		});
		//updateLinkStyles();
	}); //period of publication reset, the clicked button's values are excluded from both arrays

	$(document).on("click", '.dateReset', function () {
		$('#startDate').val('');
		//updateLinkStyles();
	}); //"Starts after" date reset, the value of date picker is reset

	$(document).on("click", '.workloadReset', function () {
		var toResetBack = $(this).parent().find('p').data('term');
		var toResetFront = $(this).parent().find('p').html();
		selectedWorkload = $.grep(selectedWorkload, function (value) {
			return value != toResetBack && value != toResetFront;
		});

		$('.label-container p[data-term="' + toResetBack + '"]').each(function () {
			$(this).closest('.label-container').find('input[type="checkbox"]').prop('checked', false);
		});

		$(this).parent().remove();

		if (selectedWorkload.length === 0) {
			minLoad = '0';
			maxLoad = '100';
		}

		filtersAndSearch();

		//updateLinkStyles();
	}); //workload reset, the value of range picker is reset

	$(document).on("click", '.searchReset', function () {
		$('#whatInput').val('');
		searchName = '';
		whatTerm = '';
	}); //search reset, the value of search bar is reset

	$(document).on("click", '.locSearchReset', function () {
		$('#whereInput').val('');
		locSearchBar = '';
	}); // location search bar reset, the value of search bar is reset

	//search bars toggle and autocompleting tips for users
	function whatFilterFunction() {
		$('#whatDropdown').addClass('show');
		searchName = '';
		var input, filter, a, i;
		input = $('#whatInput')[0];
		filter = input.value.toUpperCase();
		var div = $('#whatDropdown')[0];
		a = div.getElementsByTagName('a');
		for (i = 0; i < a.length; i++) {
			var txtValue = a[i].textContent || a[i].innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
				a[i].style.display = '';
			} else {
				a[i].style.display = 'none';
			}
		}
		searchName = $('#whatInput').val();
	}

	function whereFilterFunction() {
		$('#whereDropdown').addClass('show');
		var input, filter, a, i;
		input = $('#whereInput')[0];
		filter = input.value.toUpperCase();
		var div = $('#whereDropdown')[0];
		a = div.getElementsByTagName('a');
		for (i = 0; i < a.length; i++) {
			var txtValue = a[i].textContent || a[i].innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
				a[i].style.display = '';
			} else {
				a[i].style.display = 'none';
			}
		}
	}

	//handling clicks using functions above
	$(document).on("input", '#whatInput', whatFilterFunction);
	$(document).on("keypress", '#whatInput', whatFilterFunction);

	$(document).on("input", '#whereInput', whereFilterFunction);
	$(document).on("keypress", '#whereInput', whereFilterFunction);

	//autocompletion when user clicks the tip
	if ($('.search-panel').length > 0) {
		$(document).on("click", "#whatDropdown a", function (event) {
			var chosenElement = event.target.closest('a').innerText;
			var putIntoBar = chosenElement.replace(' - job', '');
			putIntoBar = putIntoBar.replace(' - company', '');
			$('#whatInput').val();
			if ($(this).parent().attr('id') == 'companies') {
				whatTerm = 'company';
			}
			if ($(this).parent().attr('id') == 'jobs') {
				whatTerm = 'job';
			}
			$('#whatInput').val(putIntoBar);
			$('#whatDropdown').removeClass('show');

			return false;
		});

		$(document).on('click', function (event) {
			var dropDown = $('#whatDropdown')[0];
			var whatInput = $('#whatInput')[0];


			if (!dropDown.contains(event.target) && !whatInput.contains(event.target)) {
				$('#whatDropdown').removeClass('show');
			}
		});


		//

		$(document).on('click', function (event) {
			var whereDropDown = $('#whereDropdown')[0];
			var whereInput = $('#whereInput')[0];


			if (!whereDropDown.contains(event.target) && !whereInput.contains(event.target)) {
				$('#whereDropdown').removeClass('show');
			}
		});

	}

	$(document).on("click", "#whereDropdown a", function (event) {
		var chosenElement = event.target.closest('a').innerText;
		var putIntoBar = chosenElement.split(' - ');
		$('#whereInput').val();
		$('#whereInput').val(putIntoBar[0]);
		$('#whereDropdown').removeClass('show');
		return false;
	});

	$(document).on("click", "#whereInput", function () {
		if ($('#whereInput').val().trim().length > 0) {
			$('#whereDropdown').addClass('show');
		}
	});
	$(document).on("click", "#whatInput", function () {
		if ($('#whatInput').val().trim().length > 0) {
			$('#whatDropdown').addClass('show');
		}
	});

	//auto search when user clicks the tip
	$(document).on("click", "#whatUnfiltered a, #whereUnfiltered a", function () {
		document.getElementById("searchConfirm").click();
	});



	$(document).on("click", "#searchConfirm", function () {
		if ($('#whereInput').val().trim().length > 0) {
			/////
			locSearchBar = $('#whereInput').val();
			let match = locSearchBar.match(/([A-Z]{2})\s*\(/);

			if (match) {
				locSearchBar = match[1].toLowerCase();
			} else {
				locSearchBar = locSearchBar.split(' ')[0];
			}

		}
		searchName = $('#whatInput').val();
	});

	var orderBy;
	var metaKey;


	$(document).on("click", "button.reset-all-chips", function () {
		$('.filters-list .label-container input[type="checkbox"]').prop('checked', false); //resetting all checkboxes
		filtersAndSearch(true);
		//updateLinkStyles();
	});


	// //change font weight of the link when the checkbox is checked
	// function updateLinkStyles() {
	// 	$('.category-list').each(function () {
	// 		var $categoryList = $(this);
	// 		//var $link = $categoryList.find('> a');
	// 		var isChecked = $categoryList.find('.filter-job input[type="checkbox"]:checked').length > 0;

	// 		if (isChecked) {
	// 			//$link.css('font-weight', '600');
	// 			$(this).addClass('category-list' , 'selected');

	// 		} else {
	// 			//$link.css('font-weight', '400');
	// 			$(this).css('background-color', '#fff');
	// 		}
	// 	});
	// }


	//updateLinkStyles();

	//call the function when the checkbox is changed
	//$('.category-list input[type="checkbox"]').on('change', updateLinkStyles);


	//rendering chips for different filters
	function chipsRender() {

		$('#postFilters .job-card-tags').html(''); //first we reset existing chips

		let tagsAdded = false;

		for (i = 0; i < selectedTypes.length; i++) {
			if ($('.item-title[data-term=' + selectedTypes[i] + ']').length) {
				$('#postFilters .job-card-tags').append('<div class="top-tag tag-light-gray"><p class="chip" data-term="' + selectedTypes[i] + '">' + $('.item-title[data-term="' + selectedTypes[i] + '"]').html() + '</p><span class="emplTypeReset filtersConfirm">&times</span></div>');
			}
		} //emlpoyment type

		for (i = 0; i < selectedLangs.length; i++) {
			if ($('.item-title[data-term=' + selectedLangs[i] + ']').length) {
				$('#postFilters .job-card-tags').append('<div class="top-tag tag-light-gray"><p class="chip" data-term="' + selectedLangs[i] + '">' + $('.item-title[data-term="' + selectedLangs[i] + '"]').html() + '</p><span class="langReset filtersConfirm">&times;</span></div>');
			}
		} //languages

		for (i = 0; i < selectedCats.length; i++) {
			if ($('.item-title[data-term=' + selectedCats[i] + ']').length) {
				$('#postFilters .job-card-tags').append('<div class="top-tag tag-light-gray"><p class="chip" data-term="' + selectedCats[i] + '">' + $('.item-title[data-term="' + selectedCats[i] + '"]').html() + '</p><span class="catReset filtersConfirm">&times;</span></div>');
			}
		} //languages

		for (i = 0; i < selectedPeriod.length; i++) {
			if ($('.item-title[data-term=' + selectedPeriod[i] + ']').length) {
				$('#postFilters .job-card-tags').append('<div class="top-tag tag-light-gray"><p class="chip" data-term="' + selectedPeriod[i] + '">' + $('.item-title[data-term="' + selectedPeriod[i] + '"]').html() + '</p><span class="periodReset filtersConfirm">&times;</span></div>');
			}
		} //period of publication

		if (selectedDate.length > 0) {
			$('#postFilters .job-card-tags').append('<div class="top-tag tag-light-gray"><p class="chip">' + selectedDate + '</p><span class="dateReset filtersConfirm">&times;</span></div>');

		} //"Starts after" date

		for (i = 0; i < selectedWorkload.length; i++) {
			if ($('.item-title[data-term=' + selectedWorkload[i] + ']').length) {
				$('#postFilters .job-card-tags').append('<div class="top-tag tag-light-gray"><p class="chip" data-term="' + selectedWorkload[i] + '">' + $('.item-title[data-term="' + selectedWorkload[i] + '"]').html() + '</p><span class="workloadReset filtersConfirm">&times;</span></div>');
			}
		}
		//workload

		if (searchName.length > 0) {
			$('#postFilters .job-card-tags').append('<div class="top-tag tag-light-gray"><p class="chip">' + searchName + '</p><span class="searchReset filtersConfirm">&times;</span></div>');
		} //search by name


		if (locSearchBar.length > 0) {
			$('#postFilters .job-card-tags').append('<div class="top-tag tag-light-gray"><p class="chip" data-term="' + locSearchBar + '">' + $('.item-title[data-term="' + locSearchBar + '"]').html() + '</p><span class="locSearchReset filtersConfirm">&times;</span></div>');
		} //search by location

		for (i = 0; i < selectedLocs.length; i++) {
			if ($('.item-title[data-term=' + selectedLocs[i] + ']').length) {
				$('#postFilters .job-card-tags').append('<div class="top-tag tag-light-gray"><p class="chip" data-term="' + selectedLocs[i] + '">' + $('.item-title[data-term="' + selectedLocs[i] + '"]').html() + '</p><span class="locReset filtersConfirm">&times;</span></div>');
			}
		} //filter by location

		if (selectedTypes.length > 0 || selectedLangs.length > 0 || selectedCats.length > 0 || selectedPeriod.length > 0 || selectedDate.length > 0 || selectedWorkload.length > 0 || searchName.length > 0 || locSearchBar.length > 0 || selectedLocs.length > 0) {
			tagsAdded = true;

		}

		if (tagsAdded) {
			$('.block-reset-all').css('display', 'block');
		} else {
			$('.block-reset-all').css('display', 'none');
		}

	}

	function filtersAndSearch(reset = false) {

		//resetting all filters
		if (reset) {
			selectedTypes = [];
			selectedCats = [];
			selectedDate = '';
			selectedLangs = [];
			selectedLocs = [];
			selectedPeriod = [];
			displayedPeriod = [];
			startsAfter = '';
			minLoad = '';
			maxLoad = '';
			whatTerm = '';
			searchName = '';
			paged = 1;
			locSearchBar = [];
			selectedWorkload = [];
			displayedWorkload = [];

			$('input[type="text"]').val('');
			$('input[type="checkbox"]').prop('checked', false);
			$('input[type="radio"]').prop('checked', false);
			$('textarea').val('');
			$('select').prop('selectedIndex', 0);
			$('#startDate').val('');

		} else {
			selectedDate = $('#startDate').val(); // setting variable to the date selected in date picker
		}


		//setting new query params
		if (selectedTypes.length > 0) {
			link.searchParams.set("employment_type", selectedTypes.join('|'));
		}
		else {
			link.searchParams.delete("employment_type");
		}
		if (selectedCats.length > 0) {
			link.searchParams.set("catFilter", selectedCats.join('|'));
		}
		else {
			link.searchParams.delete("catFilter");
		}
		if (selectedDate != '') {
			link.searchParams.set("dateFilter", selectedDate);
		}
		else {
			link.searchParams.delete("dateFilter");
			selectedDate = '';
		}
		if (selectedLangs.length > 0) {
			link.searchParams.set("langFilter", selectedLangs.join('|'));
		}
		else {
			link.searchParams.delete("langFilter");
		}
		if (selectedLocs.length > 0) {
			link.searchParams.set("locFilter", selectedLocs.join('|'));
		}
		else {
			link.searchParams.delete("locFilter");
		}
		if (selectedPeriod.length > 0) {
			link.searchParams.set("periodFilter", selectedPeriod.join('|'));
			link.searchParams.set("periodDisplay", displayedPeriod.join('|'));
		}
		else {
			link.searchParams.delete("periodFilter");
			link.searchParams.delete("periodDisplay");
		}
		if (minLoad != '') {
			link.searchParams.set("minLoadFilter", minLoad);
			link.searchParams.set("maxLoadFilter", maxLoad);
		}
		else {
			link.searchParams.delete("minLoadFilter");
			link.searchParams.delete("maxLoadFilter");
		}
		if (whatTerm == 'job' || whatTerm == 'company') {
			link.searchParams.set("whatTermFilter", whatTerm);
		}
		else {
			link.searchParams.delete("whatTermFilter");
		}
		if (searchName != '') {
			link.searchParams.set("searchNameFilter", searchName);
		}
		else {
			link.searchParams.delete("searchNameFilter");
		}
		if (paged != 0) {
			link.searchParams.set("currentPage", paged);
		}
		else {
			link.searchParams.delete("currentPage");
		}
		if (locSearchBar != '') {
			link.searchParams.set("locSearch", locSearchBar);
		}
		else {
			link.searchParams.delete("locSearch");
		}
		if (selectedWorkload.length > 0) {
			link.searchParams.set("workloadFilter", selectedWorkload.join('|'));
			link.searchParams.set("workloadDisplay", displayedWorkload.join('|'));
		} else {
			link.searchParams.delete("workloadFilter");
			link.searchParams.delete("workloadDisplay");
		}
		chipsRender();

		window.history.pushState({}, null, link); //so the page doesn't reload on filters

		//AJAX call
		$.ajax({
			dataType: 'json',
			url: myAjax.ajaxurl,
			type: 'POST',
			data: {
				action: 'look_for_jobs',
				types: selectedTypes,
				startsAfter: selectedDate,
				cats: selectedCats,
				langs: selectedLangs,
				minLoad: minLoad.toString(),
				maxLoad: maxLoad.toString(),
				period: selectedPeriod,
				locale: lang,
				searchBy: whatTerm,
				searchTermWhat: searchName,
				searchTermWhere: selectedLocs,
				locSearchBar: [locSearchBar],
				paged: paged,
				orderby: orderBy,
				metaKey: metaKey
			},
			beforeSend: function () {
				$('img#preloader').css('display', 'block');
				$('.lds-dual-ring').addClass('active');
			},
			success: function (filtered) {
				$('img#preloader').hide();
				$('.lds-dual-ring').removeClass('active');
				//unitializing slick slider for proper working
				$('.your-class').slick('slickRemove');

				//rendering filtered loop
				if (is_load_more == 0) {
					$('#jobsList').html(''); //if it's just a query, we reset loop
				}
				if (is_load_more == 1) {
					$('.pagination-links').css('display', 'none');; //if we clicked load more btn, we hide existing pagination links
					$('.button-container').css('display', 'none');
				}
				$('#jobsList').append(filtered.response); //and then render queried posts

				if (filtered.noMore == 1) {
					$('.load-more').hide(); //if there are no more jobs, we hide load more btn
				}

				//initializing slick slider again
				$('.your-class').not('.slick-initialized').slick({
					dots: true,
					infinite: true,
					arrows: true
				});
				is_load_more = 0;
			},
			complete: function () {
				$('img#preloader').hide();
				$('.lds-dual-ring').removeClass('active');
				$('.job-card').each(function () {
					if (list.includes($(this).data('postid').toString())) {
						$(this).find('.featuredToggle g').css('fill', '#07496E');
					}
				});

			}
		});

	}

	$('.sort-item').on('click', function () {
		var selectedSort = $(this).text();
		$('#current-sort').text(selectedSort);
	});

	//Ajax for sorting posts
	//processing sort buttons
	$(document).on("click", '#sort-most-recent, #sort-top-rated', function (e) {
		e.preventDefault(); //Canceled behavior for button
		// metaKey = 'work_start_time'; //take mera for sort date
		orderBy = 'sort-most-recent';
		paged = 1;
		filtersAndSearch();
	});

	$(document).on("click", '#sort-earliest-start-date', function (e) {
		e.preventDefault(); //Canceled behavior for button
		// metaKey = 'sort-earliest-start-date'; //take mera for sort date
		orderBy = 'sort-earliest-start-date';
		paged = 1;
		filtersAndSearch();
	});

	//handling all "confirm" and "reset" buttons: ajax call, chips render, slider reload etc.
	$(document).on("click", '.filtersConfirm', function () {

		paged = 1;
		filtersAndSearch();
	});

	//search on "Enter" button press
	$(document).on("keypress", "#whatInput", function (event) {
		if (event.keyCode === 13) {
			searchName = $('#whatInput').val();
			paged = 1;
			filtersAndSearch();
		}
	});
	$(document).on("keypress", "#whereInput", function (event) {
		if (event.keyCode === 13) {
			if ($('#whereInput').val().trim().length > 0) {
				locSearchBar = $('#whereInput').val();
			}
			paged = 1;
			filtersAndSearch();
		}
	});

	//pagination
	$(document).on("click", "a.page-numbers", function () {
		switch ($(this).data('paged')) {
			case 'next': //works only for button which leads to next page in wp
				paged++;
				break;
			case 'prev': //works only for button which leads to previous page in wp
				paged--;
				break;
			default: //works only for buttons with numbers
				if (parseInt($(this).html().trim()) != NaN) { //additional check if link contains a number
					paged = parseInt($(this).html().trim());
				}
		}
		filtersAndSearch(); //and then run filters
		return false; //prevent from going to url from response
	});

	//load more btn
	$(document).on("click", '.load-more button', function () {
		paged++; //on click we add 1 to paged(if it gets more than max_num_pages we don't get more posts loaded, handled in PHP)
		is_load_more = 1; //set this var so we know if we laod more posts or just query
		filtersAndSearch(); //and then run filter
	});

	//YY
	//add text
	let additionalText = '<p class="modal-form-send-cv-content-text-file">.pdf, .doc, .docx, .jpg, .jpeg, .png <br><br> Max 3 files up to 4MB</p>';
	$('.modal-form-send-cv-content .ff_upload_btn').after(additionalText);


	//validation for the form
	function runValidation() {
		if (!$('.ff-uploaded-list .ff-upload-preview').length) {
			$('.modal-form-send-cv .block-attach').css('border', '1px solid red');
		} else {
			$('.modal-form-send-cv .block-attach').css('border', '1px solid #7C95BB');
		}

		$('.block-fields').has('.error.text-danger').css('border', '1px solid red');
		$('.block-fields').each(function () {
			var $input = $(this).find('input');
			if ($input.val().trim() === '') {
				$(this).css('border', '1px solid red');
			} else {
				$(this).css('border', '1px solid #7C95BB');
			}
		});
	}

	//error handling for the form
	$('.ff-btn-submit').on('click', function () {
		runValidation();
	});


	$(document).on('fluentform_submission_success', function () {
		//save link to local storage
		let inputText1Elements = document.getElementsByName('input_text_1');
		if (inputText1Elements.length > 0) {
			let inputValueLink = inputText1Elements[0].value;
			updateLocalStorage(inputValueLink);

			let postId = inputText1Elements[0].getAttribute('data-id-offer');
			if (postId) {
				updateLocalStorageId(postId);
			}
		}



		//check if form is submitted
		setTimeout(() => {
			$('.modal-form-send-cv .block-attach').css('border', '1px solid #7C95BB');
			$('.block-fields').css('border', '1px solid #7C95BB');
			$('.modal-form-send-cv').find('input[type="text"], input[type="email"], textarea').not('[name="input_text_1"]').val('');
		}, 100);

		//show block for login if user is not logged in
		if (document.querySelector('.custom-login-in-ajax-form-false')) {
			setTimeout(() => {
				$('.custom-login-in-ajax-form-true').css('display', 'none');
				$('.custom-login-in-ajax-form-false').css('display', 'block');
			}, 2000);
		}

		$('.applied-window').css('display', 'block');
		setTimeout(() => {
			$('.applied-window').css('display', 'none');
		}, 3000);
	})

	//take link
	// $('.applicationToggle').on('click', function () {
	// 	let readFullLink = $(this).closest('.job-card').find('.job-card-title a').attr('href');
	// 	let getPostIdOdder = $(this).closest('.job-card').find('#get_post_id_offer').html();
	// 	let postId = getPostIdOdder.match(/\d+/g).join('');
	// 	$('.ff-el-group.send-link').html('<div class="ff-el-input--content"><input type="text" name="input_text_1" class="ff-el-form-control" data-name="input_text_1" id="ff_3_input_text_1" value="' + readFullLink + '"  data-id-offer="' + postId + '"></div>');

	// 	$('.custom-login-in-ajax-form-true').css('display', 'block');
	// 	$('.custom-login-in-ajax-form-false').css('display', 'none');
	// });

	//Local storage - save link
	function updateLocalStorage(postId) {
		let links = localStorage.getItem('links') || '';
		let linksArray = links ? links.split(',') : [];

		if (!linksArray.includes(postId.toString())) {
			linksArray.push(postId);
			localStorage.setItem('links', linksArray.join(','));
		}
	}




	function updateLocalStorageId(postId) {
		let ids = JSON.parse(localStorage.getItem('get_post_id_offer')) || [];
		if (!ids.includes(postId)) {
			ids.push(postId);
			localStorage.setItem('get_post_id_offer', JSON.stringify(ids));
		}
	}

	//if user send form
	document.addEventListener('click', function (event) {
		if (event.target.matches('.applicationToggle.send-cv-button-green')) {
			$('.custom-login-in-ajax-form-true').css('display', 'none');
			$('.custom-login-in-ajax-form-false').css('display', 'block');
		} else if (event.target.matches('.applicationToggle')) {
			$('.custom-login-in-ajax-form-true').css('display', 'block');
			$('.custom-login-in-ajax-form-false').css('display', 'none');
		}
	});



	//check block with send form
	function checkBlockForApply() {
		let linksForm = localStorage.getItem('links') || '';
		let idsForm = linksForm ? linksForm.split(',').map(Number) : [];

		$('.job-card').each(function () {
			let idForm = parseInt($(this).attr('data-postid').trim());

			if (idsForm.includes(idForm)) {
				$(this).css('border', '1px solid green');
				$(this).addClass('border-green');
				$(this).find('.text-link').addClass('applied');

				// After sending the form, change style and text
				if ($(this).hasClass('border-green')) {
					$(this).find('.button.color-teal.applicationToggle').addClass('send-cv-button-green');
					let buttonsChangeTextGreen = document.querySelectorAll('.button.color-teal.applicationToggle.send-cv-button-green');
					buttonsChangeTextGreen.forEach(function (buttonChangeTextGreen) {
						buttonChangeTextGreen.textContent = 'Applied';
					});
				}
			}
		});
	}

	checkBlockForApply();

	function updateButtonsBasedOnPostId() {
		if (window.location.href.includes('job-offer')) {
			let bodyClasses = $('body').attr('class').split(' ');
			let postId = null;
			for (let i = 0; i < bodyClasses.length; i++) {
				if (bodyClasses[i].startsWith('postid-')) {
					postId = bodyClasses[i].replace('postid-', '');
					break;
				}
			}

			if (postId) {
				let links = localStorage.getItem('links') || '';
				let ids = links.split(',').map(Number);
				if (ids.includes(parseInt(postId))) {
					$('.applicationToggle').each(function () {
						$(this).addClass('send-cv-button-green');



						if (pageLang === 'de-DE') {
							$(this).text('Angewandt');
						} else {
							$(this).text('Applied');
						}
					});
				}
			}
		}
	}

	if (window.location.href.includes('job-offer')) {
		updateButtonsBasedOnPostId();
	}
	//////////////////////////////
	$(document).on('DOMSubtreeModified', function () {


		checkBlockForApply();
		//
	});
	//////////////////////////////



	// //clear form if it's closed
	$(document).on('DOMSubtreeModified', function () {



		if ($('.modal-form-send-cv').hasClass('show')) {
		} else {
			$('.modal-form-send-cv').find('input[type="text"], input[type="email"], textarea').not('[name="input_text_1"]').val('');
			$('.modal-form-send-cv .block-attach').css('border', '1px solid #7C95BB');
			$('.block-fields').css('border', '1px solid #7C95BB');

			let fileInputDownload = $('.modal-form-send-cv').find('input[type="file"]');
			fileInputDownload.val('');
			$('.ff-uploaded-list').empty();
		}
	});

	$('.close-applied-window').click(function () {
		$('.applied-window').css('display', 'none');
	});
	//language

	$('li.pll-parent-menu-item.menu-item.menu-item-type-custom.menu-item-object-custom.menu-item-has-children').on('click', function () {
		$('.pll-parent-menu-item.menu-item.menu-item-type-custom.menu-item-object-custom.menu-item-has-children > .sub-menu').toggle();
		$('.pll-parent-menu-item.menu-item.menu-item-type-custom.menu-item-object-custom.menu-item-has-children').toggleClass('active');
	});
	$(document).on('click', function (event) {
		if (!$(event.target).closest('li.pll-parent-menu-item.menu-item.menu-item-type-custom.menu-item-object-custom.menu-item-has-children').length) {
			$('.pll-parent-menu-item.menu-item.menu-item-type-custom.menu-item-object-custom.menu-item-has-children > .sub-menu').hide();
			$('.pll-parent-menu-item.menu-item.menu-item-type-custom.menu-item-object-custom.menu-item-has-children').removeClass('active');
		}
	});

	//if we open vacation block
	function getSavedIds() {
		let savedIds = localStorage.getItem('ClickVaca');
		return savedIds ? JSON.parse(savedIds) : [];
	}

	function saveId(id) {
		let savedIds = getSavedIds();
		if (!savedIds.includes(id)) {
			savedIds.push(id);
			localStorage.setItem('ClickVaca', JSON.stringify(savedIds));
		}
	}

	function applySavedStyles() {
		let savedIds = getSavedIds();
		savedIds.forEach(function (id) {
			$('.job-card[data-postid="' + id + '"]').find('.text-link').addClass('applied');
		});
	}

	applySavedStyles();


	$(document).on('click', '.applicationToggle', function () {
		var jobCard = $(this).closest('.job-card');
		var postId = jobCard.data('postid');

		if (jobCard.attr('id') === 'date_valid') {
			jobCard.find('.text-link').addClass('applied');
			saveId(postId);
		}
	});


	$(document).on('click', '.text-link', function () {
		var jobCard = $(this).closest('.job-card');
		var postId = jobCard.data('postid');
		saveId(postId);
	});


	var bodyClass = $('body').attr('class');
	var match = bodyClass.match(/postid-(\d+)/);
	if (match) {
		var postId = match[1];
		saveId(postId);
		$('.text-link').addClass('applied');
	}

	/////////////////// 05 07 - Clear form
	function clearFormAndReload(formId) {
		$.ajax({
			url: myAjax.ajaxurl,
			method: 'POST',
			data: {
				action: 'fluentform_clear_form',
				form_id: formId
			},
			success: function (response) {
				if (response.success) {
					console.log(response.data);
				} else {
					console.log('Errors: ' + response.data);
				}
			},
			error: function () {
				console.log('Errors');
			}
		});
	}


	$(document).on('click', '#refresh-block-button', function () {
		var formId = 3;
		clearFormAndReload(formId);
	});

	//show text for sort button
	$('.sort-item').on('click', function () {
		let selectedSort = $(this).text();
		$('#active-sort-word').text(selectedSort);
	});

	//send cv form
	// Hide form
	$('.custom_cv_form_shortcode_block .modal-close').on('click', function () {
		$('.custom_cv_form_shortcode_block').css('display', 'none');
	});

	// Hide form
	$(document).on('click', function (event) {
		if (!$(event.target).closest('#cvForm').length && !$(event.target).is('#cvForm') && !$(event.target).hasClass('remove-file')) {
			$('.custom_cv_form_shortcode_block').hide();
		}
	});



	// Show form
	$(document).on("click", function (event) {
		if ($(event.target).hasClass("applicationToggle")) {
			$('.custom_cv_form_shortcode_block').show();
		}
	});

	$(document).on("click", function (event) {
		if ($(event.target).hasClass(".color-teal.applicationToggle.job-offer-button")) {
			$('.custom_cv_form_shortcode_block').show();
		}
	});

	$('span.file_upd_for_send_cv_uc').on('click', function () {
		$('#cv_file_send_for_cv_doc').click();
	});

	// Preview selected files
	$('#cv_file_send_for_cv_doc').on('change', function () {
		$('.error-message-for-file').hide(); // Hide error message when files change
		let files = $(this)[0].files;
		let previewContainer = $('#file-preview');
		let allowedExtensions = /(\.pdf|\.doc|\.docx|\.jpg|\.jpeg|\.png)$/i;
		let fileSizeLimit = 4 * 1024 * 1024; // 4MB

		previewContainer.html(''); // Clear previous files

		if (files.length > 3) {
			$('#cv_file_send_for_cv_doc').closest('.form-border-send-cv').addClass('error');
			$('.error-message-for-file').text('Max 3 files up to 4MB').css('display', 'block');
		} else {
			let valid = true;
			for (let i = 0; i < files.length; i++) {
				let file = files[i];
				if (!allowedExtensions.exec(file.name) || file.size > fileSizeLimit) {
					$('#cv_file_send_for_cv_doc').closest('.form-border-send-cv').addClass('error');
					$('.error-message-for-file').text('This file format is not allowed. Max 4MB per file.').css('display', 'block');
					valid = false;
					break;
				}
			}

			if (valid) {
				$('#cv_file_send_for_cv_doc').closest('.form-border-send-cv').removeClass('error');
				$('.error-message-for-file').hide();
			}
		}

		for (let i = 0; i < files.length; i++) {
			let file = files[i];
			let fileItem = $('<div class="file-item"></div>');
			let fileName = $('<span class="add-file"></span>').text(file.name);
			let removeButton = $('<span class="remove-file"> </span>');

			removeButton.on('click', function () {
				let fileList = Array.from(files);
				fileList.splice(i, 1);
				$('#cv_file_send_for_cv_doc')[0].files = new FileListItems(fileList);
				$(this).parent().remove();

				if ($('#cv_file_send_for_cv_doc')[0].files.length === 0) {
					$('#cv_file_send_for_cv_doc').closest('.form-border-send-cv').addClass('error');
					$('.error-message-for-file').text('This field is required.').css('display', 'block');
				} else if ($('#cv_file_send_for_cv_doc')[0].files.length <= 3) {
					$('#cv_file_send_for_cv_doc').closest('.form-border-send-cv').removeClass('error');
					$('.error-message-for-file').hide();
				}
				updateFileCount();
			});

			fileItem.append(fileName).append(removeButton);
			previewContainer.append(fileItem);
		}
		updateFileCount();
	});

	// Count files in the preview container
	function updateFileCount() {
		let previewContainerBlock = $('#file-preview');
		let count = $('#file-preview .file-item').length;
		if (count === 0) {
			previewContainerBlock.css('display', 'none');
			return false;
		} else {
			previewContainerBlock.css('display', 'block');
			return true;
		}
	}

	// Initial count
	updateFileCount();
	const observer = new MutationObserver(updateFileCount);

	observer.observe(document.getElementById('file-preview'), {
		childList: true,
		subtree: true
	});

	function FileListItems(files) {
		let b = new DataTransfer();
		for (let i = 0, len = files.length; i < len; i++) b.items.add(files[i]);
		return b.files;
	}

	// Clear form
	function clearForm() {
		$('#cvForm')[0].reset();
		$('#file-preview').empty();
		$('.error-message, .error-message-for-file').hide();
	}

	// Send CV form validation
	$('#send_cv_form_button').on('click', function (event) {
		event.preventDefault();

		let fileCountValid = updateFileCount();

		let isValid = true;
		$('.error-message').hide();
		$('.form-border-send-cv').removeClass('error');

		$('#cvForm input[type="text"], #cvForm input[type="email"]').each(function () {
			if ($(this).val().trim() === '') {
				isValid = false;
				$(this).closest('.form-border-send-cv').addClass('error');
				$(this).parent().next('.error-message').text('This field is required.').show();
			}
		});

		let fileInput = $('#cv_file_send_for_cv_doc')[0];
		let files = fileInput.files;

		if (files.length > 3) {
			isValid = false;
			$('#cv_file_send_for_cv_doc').closest('.form-border-send-cv').addClass('error');
			$('.error-message-for-file').text('Max 3 files up to 4MB').css('display', 'block');
		}

		if (!fileCountValid || files.length === 0) {
			isValid = false;
			$('#cv_file_send_for_cv_doc').closest('.form-border-send-cv').addClass('error');
			$('.error-message-for-file').text('This field is required.').css('display', 'block');
		}

		if (isValid) {
			let formData = new FormData();
			formData.append('name_user', $('#name_user').val());
			formData.append('email', $('#email_user').val());
			formData.append('description', $('#description_user').val());

			for (let i = 0; i < files.length; i++) {
				formData.append('cv_files[]', files[i]);
			}

			let idValue = $('.id_vacations_send_sv_for_list_ajax').text().trim();
			formData.append('id', idValue);

			formData.append('action', 'functions_for_send_cv_form');

			$.ajax({
				url: myAjax.ajaxurl,
				method: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: function (response) {
					if (response.success) {
						console.log(response.data);
						$('.custom_cv_form_shortcode_block').css('display', 'none');
						updateLocalStorage(idValue);
						checkBlockForApply();
						updateButtonsBasedOnPostId();
						$('.applied-window').css('display', 'block');
						setTimeout(() => {
							$('.applied-window').css('display', 'none');
							clearForm();
						}, 3000);




					} else {
						console.log('Errors: ' + response.data);
					}
				},
				error: function () {
					console.log('Errors');
				}
			});
		}
	});



	$('#cvForm input[type="text"], #cvForm input[type="email"]').on('input', function () {
		$(this).closest('.form-border-send-cv').removeClass('error').css('border', '1px solid rgba(124, 149, 187, 1)');
		$(this).parent().next('.error-message').hide();
	});

	//tike id form
	$('.applicationToggle').on('click', function () {
		let parentCardEnd = $(this).closest('.card-end');
		let postId = parentCardEnd.find('#get_post_id_offer').text().trim();

		if (!postId) {
			let bodyClasses = $('body').attr('class').split(' ');
			for (let i = 0; i < bodyClasses.length; i++) {
				if (bodyClasses[i].startsWith('postid-')) {
					postId = bodyClasses[i].replace('postid-', '');
					break;
				}
			}
		}

		$('.id_vacations_send_sv_for_list_ajax').text(postId);
	});


	//dislike global
	function updateDislikeList() {
		let dislikeList = localStorage.getItem('dislikeList');
		let postIds = [];

		if (dislikeList && dislikeList.trim() !== '') {
			postIds = dislikeList.split(',').map(function (id) {
				return parseInt(id, 10);
			});
		}

		if (postIds.length === 0) {
			postIds = [0];
		}

		$.ajax({
			url: myAjax.ajaxurl,
			type: 'POST',
			data: {
				action: 'update_user_dislike_list',
				post_ids: postIds,
			},
			success: function (response) {
				console.log('Dislike list updated:', response);
			},
			error: function (xhr, status, error) {
				console.log('Error updating dislike list:', error);
			}
		});
	}

	window.addEventListener('storage', function (event) {
		if (event.key === 'dislikeList') {
			updateDislikeList();
		}
	});

	$(document).on('click', '.dislike-job', function () {
		let dislikeList = localStorage.getItem('dislikeList') || '';




		localStorage.setItem('dislikeList', dislikeList);
		updateDislikeList();
	});

	updateDislikeList();
	//dislike global end


	$(document).on("click", '.dislike-job', function () {
		var jobCard = $(this).closest('.job-card');
		var postId = jobCard.find('#get_post_id_offer').text().trim();
		if (postId) {
			var reviewBlock = $('.block-for-rewiews-dislike.' + postId);
			if (reviewBlock.length) {
				if (reviewBlock.css('display') === 'none') {
					reviewBlock.css('display', 'flex');
				} else {
					reviewBlock.css('display', 'none');
				}
			} else {
				console.log('Review block not found for post ID: ' + postId);
			}
		}
	});

	//if user is not logged
	$(document).on("click", function (event) {
		let target = $(event.target).closest('.no-login-but-ld.like, .no-login-but-ld.dislike');

		if (target.length && target.hasClass('no-login-but-ld')) {
			event.preventDefault();
			$('.custom-login-in-ajax-form-false').css('display', 'block');
			$('.custom_cv_form_shortcode_block').css('display', 'block');
		}
	});




});
