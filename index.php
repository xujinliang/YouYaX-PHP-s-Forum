<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
header("Content-type: text/html; charset=utf-8");
if (get_magic_quotes_gpc()) {
    function stripslashes_deep($value)
    {
        $value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
        return $value;
    }
    $_POST    = array_map('stripslashes_deep', $_POST);
    $_GET     = array_map('stripslashes_deep', $_GET);
    $_COOKIE  = array_map('stripslashes_deep', $_COOKIE);
    $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
}
class LOAD
{
    static function loadClass($class_name)
    {
        $filename = "./Lib/" . $class_name . ".php";
        if (is_file($filename))
            return require($filename);
        $filename = "./Plugin/" . $class_name . ".php";
        if (is_file($filename))
            return require($filename);
    }
}
if (!file_exists("./install")) {
    require("ORG/YouYa.php");
    spl_autoload_register(array(
        'LOAD',
        'loadClass'
    ));
    App::run();
} else {
    $status = file_get_contents("./install/status.txt");
    if ($status == "complete") {
        require("ORG/YouYa.php");
        spl_autoload_register(array(
            'LOAD',
            'loadClass'
        ));
        App::run();
    } else {
        echo '<script>window.location.href="./install";</script>';
    }
}
?>