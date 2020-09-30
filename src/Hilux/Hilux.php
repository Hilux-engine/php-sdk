<?php
namespace Hilux;
use Hilux\Lib\Murmurhash;
use Hilux\Lib\Parser;

class Hilux{

    private $iBucketMax = 1000;
    //private $sToggleFile = "";
    public function __construct() {
        //$this->sToggleFile = "./data.json";
    }

    /*
     * @param : $sToggleName | 名称
     * @param : $aParam      | array数组
     * @return : bool
     * */
    public function toggle($sToggleName, $aParam) {
        $bRet = true;
        if (empty($aParam['key'])) {
            return false;
        }

        $sKeyName = $aParam['key'];
        $iHashNum = Murmurhash::hash3_int($sKeyName);

        $aRules = Parser::getRules($sKeyName);
        if (!$aRules) {
            return false;
        }
        //print_r($aRules);

        $iBucketIndex = $iHashNum % $this->iBucketMax;
        $aBucketInfo  = $aRules['bucket_info'];
        $iStartBucketIndex = $aBucketInfo['begin'];
        $iBucketRate       = $aBucketInfo['rate'];

        if ($iBucketRate == $this->iBucketMax) {
            return true;
        }
        if (0 == $iBucketRate) {
            return false;
        }

        $iEndBukectIndex = $iStartBucketIndex + $iBucketRate;
        echo $iStartBucketIndex." | ".$iBucketRate." | ".$iEndBukectIndex.PHP_EOL;

        return $bRet;
    }

}