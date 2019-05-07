<?php
namespace qpf\helper;

class Ip
{
    /**
     * 将IP转换为整型
     * @param string $ip 地址格式`192.168.1.1`
     * @return int
     */
    public static function toInt($ip)
    {
        $ipArr = explode('.', $ip);
        // 转换为无符号
        return sprintf('%u', ((int)$ipArr[0] << 24) | 
            ((int)$ipArr[1] << 16) | 
            ((int)$ipArr[2] << 8) | 
            ((int)$ipArr[3]));
    }
    
    /**
     * 将数值恢复为IP - 兼容x86 x64
     * @param int $int
     * @return string
     */
    public static function toIp($int)
    {
        $arr = [];
        // 跟0xff做与运算的目的是取低8位
        $arr[] = ($int >> 24) & 0xff;
        $arr[] = ($int >> 16) & 0xff;
        $arr[] = ($int >> 8) & 0xff;
        $arr[] = $int & 0xff;
        return join('.', $arr);
    }
}