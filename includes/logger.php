<?php
add_action('init', 'dfs_log_divi_form_submission');

function dfs_log_divi_form_submission() {
    if (
        isset($_POST['et_pb_contactform_submit_0']) &&
        $_POST['et_pb_contactform_submit_0'] === 'et_contact_proccess'
    ) {
        global $wpdb;
        $table = $wpdb->prefix . 'divi_form_submissions';

        // Match exact field names from your form
        $form_data = [
            'name' => isset($_POST['et_pb_contact_name_0']) ? sanitize_text_field($_POST['et_pb_contact_name_0']) : '',
            'email' => isset($_POST['et_pb_contact_email_0']) ? sanitize_email($_POST['et_pb_contact_email_0']) : '',
            'phone_number' => isset($_POST['et_pb_contact_phone_number_0']) ? sanitize_text_field($_POST['et_pb_contact_phone_number_0']) : '',
            'message' => isset($_POST['et_pb_contact_message_0']) ? sanitize_textarea_field($_POST['et_pb_contact_message_0']) : ''
        ];

        $status = (!empty($form_data['name']) || !empty($form_data['email']) || !empty($form_data['message']))
            ? 'Success'
            : 'Failed';

        $wpdb->insert($table, [
            'form_id' => 1,
            'submission' => json_encode($form_data),
            'status' => $status
        ]);
    }
}
