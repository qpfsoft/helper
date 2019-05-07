<?php
namespace qpf\helper;

class Qcid
{
    /**
     * 时间ID - 支持并发
     * @return string
     */
    public static function timeid()
    {
        $arr = explode(' ', microtime());
        return $arr[1] . substr($arr[0], 2);
    }

    /**
     * 有符号整型转换为无符号整型
     * @param float $int
     * @return string
     */
    public static function unsigned($int)
    {
        return (float) sprintf('%u', $int);
    }
}

