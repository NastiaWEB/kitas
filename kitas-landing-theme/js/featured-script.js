document.addEventListener('DOMContentLoaded', function () {

    // Check if featured posts are saved in local storage
    function checkFeaturedToggle() {
        var featuredList = localStorage.getItem('featuredList');
        featuredList = featuredList ? featuredList.split(',') : [];

        var originalSrc = "http://104.131.170.77/wp-content/themes/kitas-landing-theme/img/bookmark.svg";
        var newSrc = "http://104.131.170.77/wp-content/themes/kitas-landing-theme/img/bookmark1.svg";

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


    var savedIds = localStorage.getItem('featuredList');
    var paged = 1;
    var is_load_more = 0;



    setTimeout(() => {
        checkFeaturedToggle();
    }, 500);

    function filtersAndSearch() {
        if (savedIds) {
            var idsArray = savedIds.split(',');
            jQuery.ajax({
                url: myAjax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'get_featured_posts',
                    ids: idsArray,
                    currentPage: paged
                },
                success: function (response) {
                    checkFeaturedToggle();
                    jQuery('.button-container').remove();
                    jQuery('.pagination-links').remove();


                    if (is_load_more) {
                        jQuery('#jobsList').append(response);
                    } else {
                        jQuery('#jobsList').html(response);
                    }

                    is_load_more = 0;

                    setTimeout(() => {
                        checkFeaturedToggle();
                    }, 500);

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
    }

    $(document).on("click", "a.page-numbers", function (e) {
        e.preventDefault(); // Prevent default link behavior
       
        var dataPaged = $(this).data('paged');
        if (dataPaged === 'next') {
            paged++;
        } else if (dataPaged === 'prev') {
            paged--;
        } else {
            var pageNum = parseInt($(this).text().trim());
            if (!isNaN(pageNum)) {
                paged = pageNum;
            }
        }

        filtersAndSearch();
        
        return false; // Prevent from going to URL from response
    });

    // Load more button
    $(document).on("click", '.load-more button', function () {
        checkFeaturedToggle();
        paged++; // On click we add 1 to paged
        is_load_more = 1; // Set this var so we know if we load more posts or just query
        filtersAndSearch(); // Run filter
    });

    filtersAndSearch(); // Initial load
});
