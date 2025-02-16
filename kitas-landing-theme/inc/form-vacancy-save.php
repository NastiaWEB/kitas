<?php

function process_form_data()
{
    $formData = $_POST['formData'];

    if (!empty($formData)) {
        save_vacancy($formData);

    } else {
        echo json_encode(array('success' => false, 'message' => 'Data not received'));
    }

    wp_die();
}

add_action('wp_ajax_process_form_data', 'process_form_data');
add_action('wp_ajax_nopriv_process_form_data', 'process_form_data');

function save_images($base64Images)
{
    $attachment_ids = [];
    $upload_dir = wp_upload_dir();
    $upload_path = $upload_dir['path'] . '/';

    foreach ($base64Images as $index => $base64_img) {
        $img = str_replace('data:image/jpeg;base64,', '', $base64_img);
        $img = str_replace(' ', '+', $img);
        $decoded = base64_decode($img);
        $filename = 'image_' . $index . '.jpeg';
        $file_type = 'image/jpeg';
        $hashed_filename = md5($filename . microtime()) . '_' . $filename;

        $full_path = $upload_path . $hashed_filename;
        if (file_put_contents($full_path, $decoded)) {
            $attachment = array(
                'post_mime_type' => $file_type,
                'post_title' => preg_replace('/\.[^.]+$/', '', basename($hashed_filename)),
                'post_content' => '',
                'post_status' => 'inherit',
                'guid' => $upload_dir['url'] . '/' . basename($hashed_filename)
            );

            $attachment_id = wp_insert_attachment($attachment, $full_path);
            require_once (ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata($attachment_id, $full_path);
            wp_update_attachment_metadata($attachment_id, $attach_data);
            $attachment_ids[] = $attachment_id;
        }
    }

    return $attachment_ids;
}


function save_vacancy($formData)
{

    $current_language = $formData['languagePost']; 


    $post = array(
        'post_title' => $formData['title'],
        'post_status' => 'publish',
        'post_author' => get_current_user_id(),
        'post_type' => 'job-offer',
        'lang' => $current_language,
    );

    $post_id = wp_insert_post($post);

    //languages check
    if (is_array($formData['language'])) {
        $termsLanguage = $formData['language'];
    } else {
        $termsLanguage = explode(', ', $formData['language']);
    }

    //employment-type check
    $immediate_value = $formData['urgency'];
    $immediate_value = $immediate_value === 'true' ? true : false;

    $temporary_value = $formData['temporary'];
    $temporary_value = $temporary_value === 'true' ? true : false;

    echo "Save vacancy success!";

    if ($post_id) {

        //acf fields
        //step 1
        update_field('address', $formData['location'], $post_id);
        update_field('starts_on',  $formData['startOn'], $post_id);
        update_field('apply_by', $formData['startOf'], $post_id);
        update_field('immediate', $immediate_value, $post_id);
        update_field('temporary', $temporary_value, $post_id);

        //step 2
        wp_set_object_terms($post_id, $formData['contractType'], 'employment-type');
        update_field('workload', $formData['workLoadMin'], $post_id);
        update_field('max_workload', $formData['workLoadMax'], $post_id);
        update_field('work_start_time', $formData['timeStart'], $post_id);
        update_field('work_end_time', $formData['timeFinish'], $post_id);
        update_field('salary', $formData['salary'], $post_id);
        update_field('vacation', $formData['vacation'], $post_id);
        update_field('other_benefits', $formData['otherBenefits'], $post_id);

        //step 3
        update_field('teaching_approach', $formData['approach'], $post_id);
        update_field('teaching_approach_additionally', $formData['approachAdditionally'], $post_id);
        update_field('kids_age', $formData['approachOptions'], $post_id);
        update_field('languages', $formData['language'], $post_id);

        //step 4
        update_field('requirements', $formData['requirements'], $post_id);
        update_field('nice_to_have', $formData['niceToHave'], $post_id);
        update_field('responsibilities', $formData['responsibilities'], $post_id);
        update_field('benefits', $formData['benefits'], $post_id);
        update_field('other_details', $formData['otherDetails'], $post_id);
        update_field('applying_process', $formData['applyingProcess'], $post_id);
        update_field('about_company', $formData['aboutCompany'], $post_id);
        $attachment_ids = save_images($formData['galleryImages']);
        update_field('media_gallery', $attachment_ids, $post_id);   

        //category
        wp_set_object_terms($post_id, $formData['category'], 'job_category');

        //languages
        $termsLanguage = is_array($formData['language']) ? $formData['language'] : explode(', ', $formData['language']);
        wp_set_object_terms($post_id, $termsLanguage, 'offer_language');

        //location -- for creating new location in admin panel category for job offer
       // wp_set_object_terms($post_id, $formData['city'], 'location');

        //template for single-job
        update_post_meta($post_id, '_wp_page_template', 'single-job-offer.php');

        
    }

}