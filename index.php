<?php

// 定义系统常量
define( 'DS', DIRECTORY_SEPARATOR );
define( 'ROOT', __DIR__.DS );
function autoload( $sClass ){
    $sIncludePath = str_replace( '\\', DS, $sClass );
    $sTargetFile = ROOT."src".DS.$sIncludePath.'.php';
    require_once( $sTargetFile );
}
spl_autoload_register( 'autoload' );
//require_once "./vendor/autoload.php";

$oHilux = new Hilux\Hilux();
$bToggle = $oHilux->toggle('test', array(
    'key' => "xoxoxo",
));
var_dump($bToggle);