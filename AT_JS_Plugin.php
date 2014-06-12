<?php
/*
Plugin Name: AT_JS_Plugin
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: At.js_Plugin
Version: 0.1
Author: Evgeny Popov
Author URI: http://www.ru
*/

add_action('wp_enqueue_scripts', 'AT_JS_Plugin_ScriptsAction');
function AT_JS_Plugin_ScriptsAction()
{
    // min
    //define ('SCRIPT_DEBUG', true);
    $SCRIPT_DEBUG = false;

    $min = $SCRIPT_DEBUG ? '' : '.min';
    // URL адрес для нашего плагина
    $plugin_dir = trailingslashit(plugins_url('',__FILE__));



    // register scripts
    $scripts = array();
    $scripts[] = array(
        'handle'	=> 'caret',
        'src'		=> $plugin_dir . "js/jquery.caret{$min}.js",
        'deps'		=> array('jquery')
    );
    $scripts[] = array(
        'handle'	=> 'atwho',
        'src'		=> $plugin_dir . "js/jquery.atwho{$min}.js",
        'deps'		=> array('jquery', 'caret')
    );

    foreach( $scripts as $script )
    {
        wp_register_script( $script['handle'], $script['src'], $script['deps']);
    }


    // register styles
    $styles = array(
        'atwho'		=> $plugin_dir . "css/jquery.atwho{$min}.css",
    );

    foreach( $styles as $k => $v )
    {
        wp_register_style( $k, $v, false);
    }


    // Подключаем js скрипты
    wp_enqueue_script('atwho');

    // Подключаем CSS стили
    wp_enqueue_style('atwho');
}

add_filter('the_content', 'AT_JS_Plugin_MainHook');
function AT_JS_Plugin_MainHook()
{
    // Селектор для выбора ID или класса элемента HTML в котором должен работать плагин
    $selector = get_option('at_js_selector');
    // Символ для активации выпадающего списка
    $at = get_option('at_js_atchar');

    $subscribers = get_users();
    //$users=array();     // Массив с логинами зарегистрированных пользователей
    $users="";
    foreach ($subscribers as $subscriber)
    {
        $users .='"' .$subscriber -> user_login. '",';
    }
    $users = rtrim($users, ",");

    print '<script language="javascript">jQuery( document ).ready(function( $ ) {
        $("' .$selector. '").atwho({
            at: "'.$at.'",
            data:['.$users.']
        });
    });
    </script>';

}


// Если мы в адм. интерфейсе
if ( is_admin() ) {
    // Добавляем меню для плагина
    add_action( 'admin_menu', 'admin_generate_menu');

    // Была нажата кнопка сохранения настроек плагина
    if ($_POST['cmd'] == 'AT_JS_save_opt')
    {
        $AT_JS_Selector = $_POST['AT_JS_Plugin_Selector'];
        $AT_JS_ATChar = $_POST['AT_JS_Plugin_atchar'];
        // Save the posted value in the database
        update_option('at_js_selector', $AT_JS_Selector);
        update_option('at_js_atchar', $AT_JS_ATChar);
    }
}

/*
  Генерируем меню настроек
*/
function admin_generate_menu()
{
    // Добавляем основной раздел меню
    add_menu_page('At.js Plugin', 'At.js Plugin', 'manage_options', __FILE__, 'AT_JS_Plugin_options_page');
}

// Страница с настройкаим плагина
function AT_JS_Plugin_options_page()
{
?>
        <div class="wrap">
            <h2>At.js Plugin</h2>

            <h3>Settings:</h3>

        <form method="post" action="<? echo $_SERVER['REQUEST_URI'];?>">
            <table class="form-table">
                <tr>
                    <th colspan=2 scope="row">
                        HTML Selector (e.g. #comment): <input name="AT_JS_Plugin_Selector" type="text" value="<?php echo(get_option('at_js_selector')); ?>" placeholder="#comment" required/>
                    </th>
                </tr>
                <tr>
                    <th colspan=2 scope="row">
                        "AT" Char (e.g. @): <input name="AT_JS_Plugin_atchar" type="text" maxlength="1" min="1" value="<?php echo(get_option('at_js_atchar')); ?>" placeholder="@" required size="1"/>
                    </th>
                </tr>
            </table>
            <input type="hidden" name="cmd" value="AT_JS_save_opt"> <!--"Функциональная" часть кнопки сохранения настроек-->
            <p class="submit">
                <input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" /> <!--Вывод кнопки сохранения настроек в браузер. Стандартная функция Wordpress-->
            </p>
        </form>
<?php
}


// Действия при активации плагина
register_activation_hook(__FILE__, 'AT_JS_Plugin_set_options');
function AT_JS_Plugin_set_options(){
    // Настройки плагина по умолчанию
    update_option('at_js_selector', '#comment');
    update_option('at_js_atchar', '@');
}

// Действия при деактивации плагина
register_deactivation_hook(__FILE__, 'AT_JS_Plugin_unset_options');
function AT_JS_Plugin_unset_options(){
    // Удалим настройки плагина
    delete_option('at_js_selector');
    delete_option('at_js_atchar');
}


?>