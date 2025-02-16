jQuery(document).ready(function ($) {
    
    let currentPage = parseInt(getUrlParameter('currentPage')) || 1;
    let authorID = getUrlParameter('author') || $('main').data('author-id');
    let lang = getUrlParameter('current_locale') || 'en';

    function loadPosts(page) {
        console.log('Loading posts for page: ' + page);
        $.ajax({
            url: myAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'vaca_author_more_prev_next',
                paged: page,
                author: authorID,
                lang: lang
            },
            success: function (response) {
                console.log('AJAX response:', response);
                if (response.html) {
                    $('#jobsList').html(response.html);
                    $('.pagination-links').html(response.pagination);
                    updateActivePage(response.current_page);
                }
                if (response.current_page >= response.max_num_pages) {
                    $('.load-more').hide();
                } else {
                    $('.load-more').show();
                }
                updateUrl(page);
            },
            error: function (xhr, status, error) {
                console.log('AJAX error:', error);
                console.log('AJAX error details:', xhr.responseText);
            }
        });
    }

    function updateUrl(page) {
        var url = new URL(window.location.href);
        url.searchParams.set('currentPage', page);
        url.searchParams.set('author', authorID);
        url.searchParams.set('current_locale', lang);
        window.history.pushState({ path: url.href }, '', url.href);
    }

    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    function updateActivePage(currentPage) {
        $('.pagination-links a').each(function () {
            var page = parseInt($(this).text());
            if (page === currentPage) {
                $(this).addClass('current').attr('aria-current', 'page');
            } else {
                $(this).removeClass('current').removeAttr('aria-current');
            }
        });
    }

    $('.pagination-links').on('click', 'a', function (e) {
        e.preventDefault();
        var page = $(this).data('paged');
        if (page === 'next') {
            currentPage++;
        } else if (page === 'prev') {
            currentPage--;
        } else {
            currentPage = parseInt($(this).text());
        }
        loadPosts(currentPage);
    });

    $('.load-more').on('click', 'button', function () {
        currentPage++;
        loadPosts(currentPage);
    });

    
    if (currentPage > 1) {
        loadPosts(currentPage);
    }
});
