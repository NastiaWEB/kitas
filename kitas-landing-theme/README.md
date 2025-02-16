[![Build Status](https://travis-ci.org/Automattic/_s.svg?branch=master)](https://travis-ci.org/Automattic/_s)

Hey there! It's Stepan. I've been a developer of this project for a month and made this notes for you so you can track what has been made and is still to be done. Take a good care of the project and I believe that you'll get wonderful results! I've put a part of my soul in it, so good luck and have fun making it even better!

# Changes history
08-15.02.24: last week of my work on the project. Remade posts render to work with WP_Query where needed. Made pagination functionality that also works with filters and doesn't reload the page. Added AJAX "Load More" functionality. Made filtering logic on page load using query vars. Remade search by name and workload filters. Remade all filters to work by slug instead of name. Remade location search bar so it would be compabitable with filtering by slug while also allowing user to enter name of location. Added preloader and made some CSS changes. Made automatically checking applied filters on page load. Made "Featured Jobs" functionality: user can add/remove featired jobs, it will be displayed by stars. Also made functionality of "Featured Jobs" page. Many bug fixes and overall improvements. Edited files: functions.php, customJquery.js, offers-loop.php, author-offers-loop.php, featured-jobs.php, style.css, author.php. 

07.02.24: added breadcrumb with redirect to filtered search page(by category). Added pagination(needs setup to support filters). Fixed issues with workload chips. Edited files: homepage.php, offers-loop.php, functions.php, customJquery.js.

06.02.24: rewrote filtering output to be displayed as a single template, added new taxonomy "Job Categories" for "Job Offers" cpt, added dynamic displaying of categories as a list to filters block, added filtering by job category, added translation to the new taxonomy. Edited files: customJquery.js, functions.php, homepage.php, offers-loop.php.

05.02.24: overall changes and improvements. Added translation to company page, remade exact workload value as a "min-max" range using jQuery-ui library for front-end. Remade filtering by workload to match range instead of exact value. Added "salary" custom field to jobs loop. Edited files: customJquery.js, functions.php, homepage.php, offers-loop.php, author-offers-loop.php, header.php, single-job.php.

02.02.24: fixed issues with search chips and key bindings. Created company page, added company page template. Uploaded company page css. Made company page dynamic, added embedded map and dynamic photo gallery. Edited files: homepage.php, offers-loop.php, author-offers-loop.php(new file), author.php(new file), style.css, company-page.css(new file), customJquery.js, functions.php.

01.02.24: added autocompletion to "Where" search block and implemented its logic. Created tree of locations in filter block and implemented filtering by location. Added chips and reset for location filter and "What" and "Where" search. Edited files: style.css, functions.php, customJquery.js, homepage.php.

31.01.24: finished translation of filters block. Fixed some issues with filters. Added search block template. Implemented search by company name/job title with autocompletion and compability with other filters. Files changed: functions.php, customJquery.js, style.php, homepage.php.

30.01.24: added reset functionality and filter chips, fixed styling and locale issues, added publication period filter, remade logic of "Immediate" and "Temporary" tags, added comments and formatting to the code. Files changed: homepage.php, customJquery.js, style.css, offers-loop.php, single-job.php.

29.01.24: made essential filters logic, added frot-end template for displaying filtered offers loop. Files changed: functions.php, customJquery.js, homepage.php, created file offers-loop.php to wrap unfiltered offers as a template part. 

26.01.24: made template for filters. Added some basic jQuery to handle them. No GH commit due to my absence, files changed: customJquery.js, style.css, homepage.php

25.01.24: made EN/DE translation. Worked mostly with WP core files/settings, changed customJquery.js, login.php, single-job.php, homepage.php, style.css

24.01.24: Fixed styling issues. Added controls to slick slider in job cards, added form cleaning on submission and adaptive modal size depending on the type of form. Files changed: slick-theme.css, style.css, customJquery.js, functions.php, uploaded images for slick slider arrows.

23.01.24: Added second step of application form, edited files: homepage.php, functions.php, header.php, style.css, customJquery.js. Uploaded files of Slick Clider into a separate assets/src/library folder.

22.01.24: Added first step of application form, edited files: main.js, functions.php, wp-config.php, homepage.php, header.php, style.css. Created new file for jquery, customJquery.js

19.01.24: Created and set up single job page, made it dynamic w/ custom fields, edited files: functions.php, homepage.php. Created single job template, single-job.php

18.01.24: Added job page template and made job cards. They're already dynamic, so content loop is correct. Edited files: functions.php, style.css. Created jobs page template, homepage.php. Uploaded media, css and js related to the project.

17.01.24: Added header and footer from html. Also configured custom scripts and styles, added 3 of 4 menus. Created custom post types. Edited files: functions.php, header.php, footer.php. Uploaded essential css and js along with logo image.
