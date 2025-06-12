<?php
add_action('admin_menu', function () {
    add_menu_page('Divi Submissions', 'Divi Submissions', 'manage_options', 'divi-submissions', 'dfs_view_submissions', 'dashicons-feedback');
});

function dfs_view_submissions() {
    global $wpdb;
    $table = $wpdb->prefix . 'divi_form_submissions';

    echo '<div class="wrap"><h1>Divi Form Submissions</h1>';

    // Handle Edit View
    if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'edit') {
        $id = intval($_GET['id']);
        $entry = $wpdb->get_row("SELECT * FROM $table WHERE id = $id");

        if ($entry) {
            $data = json_decode($entry->submission, true);
            echo '<h2>Edit Submission</h2>';
            echo '<form method="post">';
            wp_nonce_field('dfs_edit_submission_' . $id);
            echo '<input type="hidden" name="id" value="' . esc_attr($id) . '">';
            echo '<p><label>Name: <input type="text" name="name" value="' . esc_attr($data['name']) . '" class="regular-text"></label></p>';
            echo '<p><label>Email: <input type="email" name="email" value="' . esc_attr($data['email']) . '" class="regular-text"></label></p>';
            echo '<p><label>Phone: <input type="text" name="phone_number" value="' . esc_attr($data['phone_number']) . '" class="regular-text"></label></p>';
            echo '<p><label>Message: <textarea name="message" class="large-text" rows="5">' . esc_textarea($data['message']) . '</textarea></label></p>';
            echo '<p><input type="submit" name="dfs_update_submission" class="button button-primary" value="Update Submission"></p>';
            echo '</form><hr>';
        }
    }

    // Table Display
    $entries = $wpdb->get_results("SELECT * FROM $table ORDER BY submitted_at DESC");

    echo '<table class="widefat fixed striped"><thead><tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Message</th>
        <th>Status</th>
        <th>Submitted At / Actions</th>
    </tr></thead><tbody>';

    foreach ($entries as $entry) {
        $data = json_decode($entry->submission, true);
        $status = $entry->status;
        $submitted_at = $entry->submitted_at;

        $edit_url = admin_url('admin.php?page=divi-submissions&action=edit&id=' . $entry->id);
        $delete_url = wp_nonce_url(admin_url('admin.php?page=divi-submissions&action=delete&id=' . $entry->id), 'dfs_delete_submission_' . $entry->id);

        echo '<tr>';
        echo '<td>' . esc_html($data['name'] ?? '-') . '</td>';
        echo '<td>' . esc_html($data['email'] ?? '-') . '</td>';
        echo '<td>' . esc_html($data['phone_number'] ?? '-') . '</td>';
        echo '<td>' . esc_html($data['message'] ?? '-') . '</td>';
        echo '<td><strong style="color:' . ($status === 'Success' ? 'green' : 'red') . '">' . esc_html($status) . '</strong></td>';
        echo '<td>' . esc_html($submitted_at) . '<br>';
        echo '<a href="' . esc_url($edit_url) . '">Edit</a> | ';
        echo '<a href="' . esc_url($delete_url) . '" onclick="return confirm(\'Are you sure you want to delete this submission?\')">Delete</a>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody></table></div>';
}

// Admin form handlers
add_action('admin_init', function () {
    global $wpdb;
    $table = $wpdb->prefix . 'divi_form_submissions';

    // Handle delete
    if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'delete') {
        $id = intval($_GET['id']);
        if (wp_verify_nonce($_GET['_wpnonce'], 'dfs_delete_submission_' . $id)) {
            $wpdb->delete($table, ['id' => $id]);
            wp_redirect(admin_url('admin.php?page=divi-submissions'));
            exit;
        }
    }

    // Handle update
    if (isset($_POST['dfs_update_submission'])) {
        $id = intval($_POST['id']);
        check_admin_referer('dfs_edit_submission_' . $id);

        $form_data = [
            'name' => sanitize_text_field($_POST['name']),
            'email' => sanitize_email($_POST['email']),
            'phone_number' => sanitize_text_field($_POST['phone_number']),
            'message' => sanitize_textarea_field($_POST['message']),
        ];

        $wpdb->update($table, [
            'submission' => json_encode($form_data),
            'status' => 'Success'
        ], ['id' => $id]);

        wp_redirect(admin_url('admin.php?page=divi-submissions'));
        exit;
    }
});
