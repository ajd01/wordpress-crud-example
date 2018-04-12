<?php

function translate_add() {
    //$id = $_POST["id"];
    $key = str_replace("\r\n", '',$_POST["key"]);
    $lang = $_POST["lang"];
    $text = str_replace("\r\n", '',$_POST["text"]);
    //insert
    if (isset($_POST['insert'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . "translate_array";

        $wpdb->insert(
                $table_name, //table
                array('key' => $key, 'lang' => $lang, 'text' => $text), //data
                array('%s', '%s', '%s', '%s') //data format			
        );
        $message.="Added";
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/translate-array/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Add New Row</h2>
        <?php if (isset($message)): ?>
            <div class="updated"><p><?php echo $message; ?></p></div>
            <a href="<?php echo admin_url('admin.php?page=translate_list') ?>">&laquo; Back to list</a>
        <?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <p>Add new entry</p>
            <table class='wp-list-table widefat fixed'>
                <tr>
                    <th width="20%"><a href="<?php echo admin_url('admin.php?page=translate_list') ?>">&laquo; Back to list</a></th>
                    <th width="80%"></th>
                </tr>
                <tr>
                    <th class="ss-th-width">Lang</th>
                    <td><input type="text" name="lang" value="<?php echo $lang; ?>" class="ss-field-width" ></input></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Key</th>
                    <td><textarea type="text" name="key" value="<?php echo $key; ?>" class="ss-field-width" rows="4" cols="70" ></textarea></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Text</th>
                    <td><textarea type="text" name="text" value="<?php echo $text; ?>" class="ss-field-width" rows="4" cols="70" ></textarea></td>
                </tr>
                <tr>
                    <th width="20%"></th>
                    <th width="80%"><input type='submit' name="insert" value='Save' class='button'></th>
                </tr>
            </table>
        </form>
    </div>
    <?php
}