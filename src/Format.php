<?php
namespace qpf\helper;

/**
 * 内容格式化
 */
class Format
{
    /**
     * 格式化字节大小
     * @param integer $size 字节数
     * @param string $delimiter 数字和单位分隔符
     * @return string 格式化后的带单位的大小
     */
    public static function sizecount($size, $delimiter = '')
    {
        $units = array('B','KB','MB','GB','TB','PB');
        for ($i = 0; $size >= 1024 && $i < 5; $i ++)
            $size /= 1024;
            return round($size, 2) . $delimiter . $units[$i];
    }
}