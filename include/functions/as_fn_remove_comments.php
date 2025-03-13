<?php

/*
** Version: 0.2 - AS OOP Class for Removing Comments
** Changelog:
** 0.2 - 04.03.2025 - Refactored to OOP
** 0.1 - 27.02.2025 - Initial basic function
*/

class AS_Comment_Remover {

    private $batch_size = 50; // Anzahl der Kommentare pro Durchlauf

    public function __construct() {
        add_action('admin_action_as_delete_comments_page', [$this, 'render_delete_comments_page']);
        add_action('wp_ajax_as_delete_comments_ajax', [$this, 'delete_comments_ajax']);
        add_action('wp_ajax_as_reset_comments_option', [$this, 'reset_comments_option']);
    }

    /**
     * Erstellt das Admin-Popup für das Löschen der Kommentare mit Fortschrittsbalken.
     */
    public function render_delete_comments_page() {
        global $wpdb;
        $total_comments = $wpdb->get_var("SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE comment_approved = '0'");

        ?>
        <div style="font-family: Arial, sans-serif; text-align: center; padding: 20px;">
            <h2>Deleting unpublished comments...</h2>
            <p id="comment-status">Please wait...</p>

            <!-- Fortschrittsbalken -->
            <div style="width: 100%; background-color: #ddd; border-radius: 10px; overflow: hidden; margin-top: 20px;">
                <div id="progress-bar" style="height: 30px; width: 0%; background-color: #4CAF50; text-align: center; color: white; line-height: 30px; border-radius: 10px;">0%</div>
            </div>

            <script>
                let totalComments = <?php echo $total_comments; ?>;

                function deleteCommentsBatch() {
                    fetch('<?php echo admin_url('admin-ajax.php?action=as_delete_comments_ajax'); ?>')
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                let remaining = data.data.remaining;
                                let deleted = totalComments - remaining;
                                let progress = totalComments > 0 ? (deleted / totalComments) * 100 : 100;

                                document.getElementById('comment-status').innerText = remaining + ' comments remaining...';

                                // Fortschrittsbalken aktualisieren
                                document.getElementById('progress-bar').style.width = progress + '%';
                                document.getElementById('progress-bar').innerText = Math.round(progress) + '%';

                                if (remaining > 0) {
                                    setTimeout(deleteCommentsBatch, 2000);
                                } else {
                                    document.getElementById('comment-status').innerText = 'All comments have been deleted!';
                                    document.getElementById('progress-bar').style.width = '100%';
                                    document.getElementById('progress-bar').innerText = '100%';

                                    setTimeout(() => {
                                        fetch('<?php echo admin_url('admin-ajax.php?action=as_reset_comments_option'); ?>');
                                        window.close();
                                        window.opener.location.reload();
                                    }, 2000);
                                }
                            }
                        });
                }

                deleteCommentsBatch();
            </script>
        </div>
        <?php
        exit;
    }

    /**
     * Löscht unbestätigte Kommentare in Batches und gibt den Fortschritt zurück.
     */
    public function delete_comments_ajax() {
        global $wpdb;

        $comment_ids = $wpdb->get_col("
            SELECT comment_ID FROM $wpdb->comments
            WHERE comment_approved = '0'
            LIMIT {$this->batch_size}
        ");

        if (!empty($comment_ids)) {
            foreach ($comment_ids as $comment_id) {
                wp_delete_comment($comment_id, true);
            }
        }

        $remaining = $wpdb->get_var("SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE comment_approved = '0'");

        if ($remaining == 0) {
            update_option('as_check_comments_db', 0);
        }

        wp_send_json_success(['remaining' => $remaining]);
    }

    /**
     * Setzt die Option `as_check_comments_db` auf 0 zurück.
     */
    public function reset_comments_option() {
        update_option('as_check_comments_db', 0);
        wp_send_json_success();
    }
}

// Initialisiert die Klasse
new AS_Comment_Remover();
