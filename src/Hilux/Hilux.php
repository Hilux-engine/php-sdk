<?php
namespace Hilux;
use Hilux\Lib\Murmurhash;
use Hilux\Lib\Parser;

class Hilux{

    private $iBucketMax = 1000;
    private $iBucketMin = 0;
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

        $aRules = Parser::getRules($sToggleName);
        if (!$aRules) {
            return false;
        }
        print_r($aRules);

        // white-list
        if (!empty($aRules['white_list']['list'])) {
            $aWhiteList = $aRules['white_list']['list'];
            if (in_array($sKeyName, $aWhiteList)) {
                return true;
            }
        }

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
        //echo "hashNum:{$iHashNum} | bucketIndex:{$iBucketIndex} | start:{$iStartBucketIndex} | rate:{$iBucketRate}".PHP_EOL;
        //echo $iStartBucketIndex." | ".$iBucketRate." | ".$iEndBukectIndex.PHP_EOL;
        if ($iEndBukectIndex <= $this->iBucketMax) {
            if ($iBucketIndex >= $iStartBucketIndex && $iBucketIndex <= $iEndBukectIndex) {
                $bRet = true;
            } else {
                $bRet = false;
            }
        } else {
            if ($iBucketIndex >= ($iEndBukectIndex - $this->iBucketMax) && $iBucketIndex <= $iStartBucketIndex) {
                $bRet = false;
            } else {
                $bRet = true;
            }
        }

        return $bRet;
    }

}