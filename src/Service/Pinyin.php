<?php

/**
 * Created by PhpStorm.
 * User: jims
 * Date: 17-3-13
 * Time: 下午5:34
 */
namespace App\Service;

class Pinyin {
    static $data;
    public function __construct(){
    }
    public static function get($hz, $first = false){
        $hz = trim($hz);
        $len = strlen($hz);

        if($len < 3) return $hz;

        if(empty(self::$data)){
            $data = file_get_contents(__DIR__.'/../../../var/lib/pinyin_class.txt');

            preg_match_all('/([^:|]+):([a-z]+)/',$data,$hz_py);
            if(!empty($hz_py)){
                foreach ($hz_py[1] as $k=>$v){
                    self::$data[$v] = $hz_py[2][$k];
                }

            }else{
                return false;
            }

        }else{
            ;
        }
        $pinyin = '';
        $first_py = '';
        if(preg_match_all('/./u',$hz,$match)){
            if(empty($match)){return false;}
            $match = $match[0];
            foreach($match as $m){
                if(isset(self::$data[$m])){
                    $pinyin .= self::$data[$m];
                    if($first){$first_py .= self::$data[$m][0];}
                }else{
                    $pinyin .=$m;
                }
            }
        }else{
            return false;
        }
        return ($first)?$pinyin.'|'.$first_py:$pinyin;


    }


    public static function getPinyinFirstLetter($hz)
    {
        $hz = trim($hz);
        $len = strlen($hz);

        if($len < 3) return $hz;

        if(empty(self::$data)){
            $data = file_get_contents(__DIR__.'/../../../var/lib/pinyin_class.txt');

            preg_match_all('/([^:|]+):([a-z]+)/',$data,$hz_py);
            if(!empty($hz_py)){
                foreach ($hz_py[1] as $k=>$v){
                    self::$data[$v] = $hz_py[2][$k];
                }

            }else{
                return false;
            }

        }else{
            ;
        }

        $first_py = '';
        if(preg_match_all('/./u',$hz,$match)){
            if(empty($match)){return false;}
            $match = $match[0];
            foreach($match as $m){
                if(isset(self::$data[$m])){

                    $first_py .= self::$data[$m][0];
                }else{
                    $first_py .=$m;
                }
            }
        }else{
            return false;
        }
        return $first_py;
    }

}