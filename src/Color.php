<?php
namespace qpf\helper;

/**
 * 颜色助手
 */
class Color
{
    /**
     * 生成随机十六进制颜色值
     * @return string 返回格式`#000000`
     */
    public static function randHex()
    {
        $color = [];
        
        for ($i = 0; $i < 6; $i++) {
            $color[] = dechex(rand(0,15));
        }
        
        return '#' . join('', $color);
    }
    
    /**
     * 生成随机RGB颜色值
     * @return string 返回格式`255,255,255`
     */
    public static function randRgb()
    {
        return mt_rand(50, 200) . ',' . mt_rand(50, 200) . ',' . mt_rand(50, 200);
    }
    
    /**
     * 获取颜色的RGB值
     * @param string|array $color 颜色值, 支持的格式:
     * - `#FFFFFF` : 十六进制颜色值
     * - `255,255,255` : 逗号分隔的RGB值
     * - [r, g, b] : 数组分隔的RGB值
     * @return array 返回包含RGB值的索引数组[0=>r, 1=>g, 2=>b]
     */
    public static function getRgb($color)
    {
        // RGB数组直接返回
        if (is_array($color)) {
            return $color;
        }
        
        // RGB字符串
        if (strpos($color, ',') !== false) {
            return explode(',', str_replace(' ', '', $color));
        }
        
        // 颜色哈希
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }
        
        if (strlen($color) == 6) {
            list ($r, $g, $b) = [$color[0] . $color[1],$color[2] . $color[3],$color[4] . $color[5]];
        } elseif (strlen($color) == 3) {
            list ($r, $g, $b) = [$color[0] . $color[0],$color[1] . $color[1],$color[2] . $color[2]];
        } else {
            throw new \InvalidArgumentException('Color error : ' . var_export($color, true));
        }
        
        return [hexdec($r), hexdec($g), hexdec($b)];
    }
}