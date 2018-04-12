<?php

function translate_list() {
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/translate-arrays/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Translate List</h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo admin_url('admin.php?page=translate_add'); ?>">Add New</a>
            </div>
            <br class="clear">
        </div>
        <?php
        global $wpdb;
        $table_name = $wpdb->prefix . "translate_array";

        $rows = $wpdb->get_results("SELECT id,`key`,`lang`,text from $table_name order by `key`,`lang`");
        ?>
        <table class='wp-list-table widefat fixed striped posts'>
            <tr style="background-color:#d5d5d5">
                <th class="manage-column ss-list-width">Key</th>
                <th class="manage-column ss-list-width">Lang</th>
                <th class="manage-column ss-list-width">Text</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($rows as $row) { ?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo $row->key; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->lang; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->text; ?></td>
                    <td>
                        <a class='button' href="<?php echo admin_url('admin.php?page=translate_update&id=' . $row->id); ?>">Update</a>
                        <form method="post" action="<?php echo admin_url('admin.php?page=translate_update&id=' . $row->id); ?>">
                            <input type='submit' name="delete" value='Delete' class='button' onclick="return confirm('&iquest;Est&aacute;s seguro de borrar este elemento?')">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <?php
}