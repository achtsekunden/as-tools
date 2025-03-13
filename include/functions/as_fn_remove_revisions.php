<?php

/*
** Version: 0.3 - AS OOP Class for Removing Revisions
** Changelog:
** 0.3 - 04.03.2025 - Added reset_revisions_option() function
** 0.2 - 04.03.2025 - Refactored to OOP
** 0.1 - 27.02.2025 - Initial basic function
*/

class AS_Revision_Remover {

    private $batch_size = 100; // Anzahl der Revisionen pro Durchlauf

    public function __construct() {
        add_action('admin_action_as_delete_revisions_page', [$this, 'render_delete_revisions_page']);
        add_action('wp_ajax_as_delete_revisions_ajax', [$this, 'delete_revisions_ajax']);
        add_action('wp_ajax_as_reset_revisions_option', [$this, 'reset_revisions_option']);
    }

    /**
     * Erstellt das Admin-Popup für das Löschen der Revisionen.
     */
    public function render_delete_revisions_page() {
        global $wpdb;
        $total_revisions = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->posts WHERE post_type = 'revision'");

        ?>
        <div style="font-family: Arial, sans-serif; text-align: center; padding: 20px;">
            <h2>Revisions are being deleted...</h2>
            <p id="revision-status">Please wait...</p>

            <!-- Fortschrittsbalken -->
            <div style="width: 100%; background-color: #ddd; border-radius: 10px; overflow: hidden; margin-top: 20px;">
                <div id="progress-bar" style="height: 30px; width: 0%; background-color: #4CAF50; text-align: center; color: white; line-height: 30px; border-radius: 10px;">0%</div>
            </div>

            <script>
                let totalRevisions = <?php echo $total_revisions; ?>;

                function deleteRevisionsBatch() {
                    fetch('<?php echo admin_url('admin-ajax.php?action=as_delete_revisions_ajax'); ?>')
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                let remaining = data.data.remaining;
                                let deleted = totalRevisions - remaining;
                                let progress = totalRevisions > 0 ? (deleted / totalRevisions) * 100 : 100;

                                document.getElementById('revision-status').innerText = remaining + ' revisions remaining...';

                                // Fortschrittsbalken aktualisieren
                                document.getElementById('progress-bar').style.width = progress + '%';
                                document.getElementById('progress-bar').innerText = Math.round(progress) + '%';

                                if (remaining > 0) {
                                    setTimeout(deleteRevisionsBatch, 2000);
                                } else {
                                    document.getElementById('revision-status').innerText = 'All revisions have been deleted!';
                                    document.getElementById('progress-bar').style.width = '100%';
                                    document.getElementById('progress-bar').innerText = '100%';

                                    setTimeout(() => {
                                        fetch('<?php echo admin_url('admin-ajax.php?action=as_reset_revisions_option'); ?>'); // Setzt Option zurück
                                        window.close();
                                    }, 2000);
                                }
                            }
                        });
                }

                deleteRevisionsBatch();
            </script>
        </div>
        <?php
        exit;
    }

    /**
     * Löscht Revisionen in Batches und gibt den Fortschritt zurück.
     */
    public function delete_revisions_ajax() {
        global $wpdb;

        $revision_ids = $wpdb->get_col("
            SELECT ID FROM $wpdb->posts
            WHERE post_type = 'revision'
            LIMIT {$this->batch_size}
        ");

        if (!empty($revision_ids)) {
            foreach ($revision_ids as $revision_id) {
                wp_delete_post($revision_id, true);
            }
        }

        $remaining = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->posts WHERE post_type = 'revision'");

        if ($remaining == 0) {
            $this->reset_revisions_option();
        }

        wp_send_json_success(['remaining' => $remaining]);
    }

    /**
     * Setzt die Option `as_check_revisions_db` auf 0 zurück.
     */
    public function reset_revisions_option() {
        update_option('as_check_revisions_db', 0);
        wp_send_json_success();
    }
}

// Initialisiert die Klasse
new AS_Revision_Remover();
