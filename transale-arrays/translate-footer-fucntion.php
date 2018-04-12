<?php
/* Add JS to footer and translate actions */
function your_function_name(){
    //Print Flags in float div
?>
    <div style="padding: 15px;
    right: 0;
    position: fixed;
    text-align: center;
    bottom: 0;
    width: 10%;
    -webkit-border-top-left-radius: 10px;
    -moz-border-radius-topleft: 10px;
    border-top-left-radius: 10px;
    background-color: #7fffd48f;">
            <a href="#en" class="chngtra" data-lang="en">
                <img src="<?php echo WP_PLUGIN_URL; ?>/transale-arrays/images/enghlish_.png" width="30px"/>
            </a>
            <a href="#es" class="chngtra" data-lang="es">
                <img src="<?php echo WP_PLUGIN_URL; ?>/transale-arrays/images/castellano_.png" width="30px"/>
            </a>
    </div>

    <script src="<?php echo WP_PLUGIN_URL; ?>/transale-arrays/jquery.translate.js"></script>
        <?php
            //Get de data and formated to JSON needed from jquery.translate
            global $wpdb;
            $table_name = $wpdb->prefix . "translate_array";
            $rows = $wpdb->get_results("SELECT * from $table_name order by `key`,`lang`");
            $lang_array = [];
            $_array = array();
            $_key = "";
            foreach ($rows as $key => $value) {
                if ($_key == $value->key) {
                    if (is_null($_array[$value->key])) {
                        $_array[$value->key] = array($value->lang => $value->text);
                    } else {
                        $_array[$value->key] = $_array[$value->key] + array($value->lang => $value->text);
                    }                 
                } else {
                    $lang_array = $lang_array + $_array;
                    $_array = array();
                    $_array[$value->key] = array($value->lang => $value->text);
                    $_key = $value->key;
                }
            }
            $lang_array = $lang_array + $_array;
            //JSON reary
            $lang_array = json_encode($lang_array);
        ?>
    <script>
        //Parsing JSON text to JS Object
        var dict = JSON.parse('<?=$lang_array?>')
        $("document").ready(function() { 
            var class_translate = 'tx'
            $('label').each(function() {$(this).addClass(class_translate)})
            $('h1').each(function() {$(this).addClass(class_translate)})
            $('a').each(function() {$(this).addClass(class_translate)})

            /* Custom function to copy, paste all strings available to translate, in the future need to make an automatic process. */
            
            $('.tx').each(function() {
                //console.log("INSERT INTO colamex_translate_array (`key`,`lang`,`text`) VALUES "+" ('"+$(this).html()+"','en','"+$(this).html()+"');");
                //console.log(" ('"+$(this).html()+"','es','"+$(this).html()+"');")
            })

            function langHammy() {
                var lang = localStorage.getItem("localLang")
                $('.imglang').each(function() {
                    src = $(this).data('src')
                    ext = $(this).data('ext')
                    $(this).attr('src',src+'-'+lang+'.'+ext)
                })
            }

            var lange = 'es' //Default language, need to change in the jquery.translate.js file to.
            if (localStorage.getItem("localLang") !== null) {
                lange = localStorage.getItem("localLang")
            }

            var translator = $('body').translate({
                lang: lange, 
                t: dict
            });

            localStorage.setItem("localLang",lange);
            langHammy()
            
            $('.chngtra').click(function() {
                localStorage.setItem("localLang",$(this).data('lang'));
                translator.lang($(this).data('lang'))
                langHammy()
            })
        }); 
    </script>
<?php
};

add_action('wp_footer', 'your_function_name');