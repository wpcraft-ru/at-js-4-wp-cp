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
    $plugin_dir = "/wp-content/plugins/AT_JS_Plugin/";

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
        'atwho'				=> $plugin_dir . "css/jquery.atwho{$min}.css",
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
    $selector = "#comment";

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
            at: "@",
            data:['.$users.']
        });
    });
    </script>';

}


?>