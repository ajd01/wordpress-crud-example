<?php

function translate_update() {
    global $wpdb;
    $table_name = $wpdb->prefix . "translate_array";
    $id = $_GET["id"];
    $key = str_replace("\r\n", '',$_POST["key"]);
    $lang = $_POST["lang"];
    $text = str_replace("\r\n", '',$_POST["text"]);
    //update
    if (isset($_POST['update'])) {
        $wpdb->update(
                $table_name, //table
                array('key' => $key, 'lang' => $lang, 'text' => $text), //data
                array('ID' => $id), //where
                array('%s'), //data format
                array('%s') //where format
        );
    }
    //delete
    else if (isset($_POST['delete'])) {
        $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %s", $id));
    } else {//selecting value to update	
        $schools = $wpdb->get_results($wpdb->prepare("SELECT * from $table_name where id=%s", $id));
        foreach ($schools as $s) {
            $key = $s->key;
            $lang = $s->lang;
            $text = $s->text;
        }
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/translate-array/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Edit translate</h2>

        <?php if ($_POST['delete']) { ?>
            <div class="updated"><p>Translation deleted</p></div>
            <a href="<?php echo admin_url('admin.php?page=translate_list') ?>">&laquo; Back to list</a>

        <?php } else if ($_POST['update']) { ?>
            <div class="updated"><p>Translation updated</p></div>
            <a href="<?php echo admin_url('admin.php?page=translate_list') ?>">&laquo; Back to list</a>

        <?php } else { ?>
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
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
                        <td><textarea type="text" name="key" class="ss-field-width" rows="4" cols="70" ><?php echo $key; ?></textarea></td>
                    </tr>
                    <tr>
                        <th class="ss-th-width">Text</th>
                        <td><textarea type="text" name="text" class="ss-field-width" rows="4" cols="70" ><?php echo $text; ?></textarea></td>
                    </tr>
                    <tr>
                        <th width="20%"></th>
                        <th width="80%">
                            <input type='submit' name="update" value='Save' class='button'> &nbsp;&nbsp;
                            <input type='submit' name="delete" value='Delete' class='button' onclick="return confirm('&iquest;Est&aacute;s seguro de borrar este elemento?')">
                        </th>
                    </tr>
                </table>
            </form>
        <?php } ?>

    </div>
    <?php
}