<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 17-11-7
 * Time: 下午4:23
 */

namespace App\Service;


class BitCategory
{
    /**
     * @param int $total_bits 二进制数的总位数
     * @return array  返回 含有1的不同组合的结果集合
     */
    public static function findCollectionAll($total_bits = 3)
    {
        $dec_total = (1 << $total_bits) - 1;
        $result = [];

        while ($dec_total > 0) {
            $tmp = $dec_total;
            $countOfOne = 0;
            while ($tmp > 0) {
                if ($tmp & 1 == 1) {
                    $countOfOne++;
                }
                $tmp = $tmp >> 1;
            }

            $result[$countOfOne][] = $dec_total;

            $dec_total--;
        }
        return $result;

    }

    /**
     * @param int $total_bits 二进制数的总位数
     * @param int $target_bit 目标位
     * @return array|bool  返回目标位为1 的所有组合
     */
    public static function findCollectionByBit($target_bit = 1, $total_bits = 5)
    {
        if ($target_bit > $total_bits) {
            return false;
        }

        $target_bit = $target_bit - 1;
        $dec_total = (1 << $total_bits) - 1;
        $result = [];

        while ($dec_total > 0) {
            if (($dec_total >> $target_bit) & 1 == 1) {
                $result[] = $dec_total;
            }
            $dec_total--;
        }

        return $result;
    }

    /**
     * @param $sum
     * @return array
     * 由和算出 每位为1的值的数组
     */
    public static function getCollectionFromSum($sum)
    {
        $bit = decbin($sum);
        $length = strlen($bit);
        $data = [];
        for ($i=0; $i<=($length-1); $i++){
            if (empty($bit[$i])) {
                continue;
            }
            array_push($data, pow(2,(($length-1)-$i)) );
        }

        return $data;

    }

    public static function transValueToBitPosition($value)
    {
        return self::getBaseLog($value, 2) + 1;
    }

    public static function getBaseLog($x, $y)
    {
        return log($x) / log($y);
    }

    /**
     * @param $sum
     * @param $targetNumber
     * 判断2个二进制分类(十进制状态)是否属于同一类或包含
     * 检查目标数字  是否包含于 指定 sum数字中？   比如： 目标2包含于3中
     */
    public static function checkContainOrEqual($sum, $targetNumber)
    {
        $collection = self::getCollectionFromSum($sum);

        return in_array($targetNumber, $collection);
    }


}