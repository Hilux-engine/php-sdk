<?php
namespace Hilux\Lib;


class Parser{

    private static $sToggleFile = "data.json";
    private static $sStorePath  = __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR;
    public static function init() {

    }
    /*
     * @param : $sKeyName 寻找规则文件
     * */
    public static function getRules($sKeyName) {
        $sFile = self::$sStorePath.self::$sToggleFile;
        $sRuleContent = file_get_contents($sFile);
        return json_decode($sRuleContent, true);
    }

}