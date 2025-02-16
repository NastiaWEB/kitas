# Kitas - Custom theme for employment agency website

This website based on https://underscores.me/ theme.

Main goal of this project was to create a custom job board theme for job seekers and companies. 
It includes job board with filtering, job offers management, user profile editing, company page editing, and account settings and much more.

Key Features

1. Multilingual Support

The theme is built with compatibility with the Polylang multilingual plugin (currently we only have DE and EN versions)

2. Custom Post Types (CPT)

Custom post types have been registered in functions.php to create job offers.

3. Custom User Roles

Custom user roles are implemented for companies and job seekers to create and manage accounts in the interface.

4. Advanced Custom Queries

Custom queries using WP_Query are implemented to filter job offers. For example, in the query search-jobs.php, inc/applied-jobs, inc/applied-jobs.php, look_for_jobs ajax.

5. Ajax query for filtering

On the homepage, if you select some filter parameters, the results will be updated immediately using ajax.


![image](https://github.com/user-attachments/assets/595f6f71-a76a-41ef-86f7-0b55c85186b9)
