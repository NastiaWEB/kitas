$(document).ready(function () {

    // Check if featured posts are saved in local storage
    function checkFeaturedToggle() {
        var featuredList = localStorage.getItem('featuredList');
        featuredList = featuredList ? featuredList.split(',') : [];

        var originalSrc = "/wp-content/themes/kitas-landing-theme/img/bookmark.svg";
        var newSrc = "/wp-content/themes/kitas-landing-theme/img/bookmark1.svg";

        //handling feature button clicks
        $(document).on("click", '.featuredToggle', function () {
            var data = $(this).closest('.job-card').data('postid').toString();
            var img = $(this).find('img');

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
            var postId = $(this).data('postid').toString();
            var img = $(this).find('.featuredToggle img');

            if (featuredList.includes(postId)) {
                img.attr('src', newSrc);
            } else {
                img.attr('src', originalSrc);
            }
        });
    }



    function checkLikeOrDislike() {
		var dislikeList = localStorage.getItem('dislikeList');
		dislikeList = dislikeList ? dislikeList.split(',') : [];
	
		var originalSrc = "/wp-content/themes/kitas-landing-theme/img/dislike.svg";
		var newSrc = "/wp-content/themes/kitas-landing-theme/img/dislikeblack.svg";
	
		$(document).on("click", '.dislike-job', function() {
			var data = $(this).closest('.job-card').data('postid').toString();
			var img = $(this).find('img');
	
			if (!dislikeList.includes(data)) {
				dislikeList.push(data);
				img.attr('src', newSrc);
			} else {
				dislikeList = dislikeList.filter(function(e) { return e !== data });
				img.attr('src', originalSrc);
			}
	
			localStorage.setItem('dislikeList', dislikeList.join(','));
		});
	
		$('.job-card').each(function() {
			var postId = $(this).data('postid').toString();
			var img = $(this).find('.dislike-job img');
	
			if (dislikeList.includes(postId)) {
				img.attr('src', newSrc);
                
			} else {
				img.attr('src', originalSrc);
			}
		});
	}

    setTimeout(() => {
        checkFeaturedToggle();
        checkLikeOrDislike();
    }, 500);

    // Select tab and show offers
    function updateShowOffers() {
        $('.show-offers').hide();
        var activeTabId = $('.select-tab.active').attr('id');
        $('#show-offers-' + activeTabId).show();
    }


    updateShowOffers();

    // Save offer
    let savedIds = localStorage.getItem('featuredList');
    if (savedIds) {
        let idsArray = savedIds.split(',');

        let countSavedIds = idsArray.length;
        let countSavedElements = document.querySelectorAll('.count-saved');
        countSavedElements.forEach(function (element) {
            element.textContent = countSavedIds;
        }); // Update count of saved offers

        setTimeout(() => {
            if (countSavedIds === 0) {
                document.querySelector('.applied-jobs .empty-show-offer').style.display = 'block';
            } else {
                document.querySelector('.applied-jobs .empty-show-offer').style.display = 'none';
            }
        }, 400);

        jQuery.ajax({
            url: myAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'get_save_offers',
                ids: idsArray
            },
            success: function (response) {
                jQuery('#offers-saved').html(response);
                checkFeaturedToggle();
                checkLikeOrDislike();
                $('.your-class').not('.slick-initialized').slick({
                    dots: true,
                    infinite: true,
                    arrows: true
                });
            },
            error: function () {
                console.log('Error retrieving posts');
            }
        });
    }

    // Applied offer
    let savedAppliedIds = localStorage.getItem('links');
    if (savedAppliedIds) {
       // let idsApplieArray = JSON.parse(savedAppliedIds); dislikeIds.split(',');
        let idsArray = savedAppliedIds.split(',');

        let countSavedIds = idsArray.length;
        let countSavedElements = document.querySelectorAll('.count-applied');
        countSavedElements.forEach(function (element) {
            element.textContent = countSavedIds;
        });

        setTimeout(() => {
            if (countSavedIds === 0) {
                document.querySelector('.applied-jobs .empty-applied-offer').style.display = 'block';
            } else {
                document.querySelector('.applied-jobs .empty-applied-offer').style.display = 'none';
            }
        }, 400);

        jQuery.ajax({
            url: myAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'get_applied_offers',
                ids: idsArray
            },
            success: function (response) {
                jQuery('#offers-applied').html(response);
                checkFeaturedToggle();
                checkLikeOrDislike();
                $('.your-class').not('.slick-initialized').slick({
                    dots: true,
                    infinite: true,
                    arrows: true
                });
            },
            error: function () {
                console.log('Error retrieving posts');
            }
        });
    }

    // dislike offer
    let dislikeIds = localStorage.getItem('dislikeList');
    if (dislikeIds) {
        let idsArray = dislikeIds.split(',');

        let countSavedIds = idsArray.length;
        let countSavedElements = document.querySelectorAll('.count-hidden-offers');
        countSavedElements.forEach(function (element) {
            element.textContent = countSavedIds;
        });

        setTimeout(() => {
            if (countSavedIds === 0) {
                document.querySelector('.applied-jobs .empty-dislike-offer').style.display = 'block';
            } else {
                document.querySelector('.applied-jobs .empty-dislike-offer').style.display = 'none';
            }
        }, 400);

        jQuery.ajax({
            url: myAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'get_dislike_offers',
                ids: idsArray
            },
            success: function (response) {
                jQuery('#offers-hidden-offers').html(response); 
                checkFeaturedToggle();
                checkLikeOrDislike();
                $('.your-class').not('.slick-initialized').slick({
                    dots: true,
                    infinite: true,
                    arrows: true
                });
            },
            error: function () {
                console.log('Error retrieving posts');
            }
        });
    }
});
