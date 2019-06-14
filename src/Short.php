<?php
namespace qpf\helper;

/**
 * 简短内容
 * 
 * 将内容字符串通过循环冗余生成校验值, 可用于检查传输内容的数据完整性! 不可逆.
 */
class Short
{
    /**
     * 短字符串
     *
     * - 生成唯一的6位的字符串标识
     *
     * @param string $str 字符串
     * @return string
     */
    public static function str(string $str): string
    {
        $result = sprintf("%u", crc32($str));
        $show = '';
        while ($result > 0) {
            $s = $result % 62;
            if ($s > 35) {
                $s = chr($s + 61);
            } elseif ($s > 9 && $s <= 35) {
                $s = chr($s + 55);
            }
            $show .= $s;
            $result = floor($result / 62);
        }
        return $show;
    }
    
    /**
     * 循环冗余校验32结果映射到（62个字符）
     * 
     * 通过不同的映射表来增加安全性, 生成不同的结果
     * @param string $data
     * @return string
     */
    public static function hash(string $data): string
    {
        static $map = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $hash = bcadd(sprintf('%u', crc32($data)), 0x100000000);
        $str = '';
        do {
            $str = $map[bcmod($hash, 62)] . $str;
            $hash = bcdiv($hash, 62);
        } while ($hash >= 1);
        return $str;
    }
    
    /**
     * 循环冗余校验32
     * 
     * 这通常用于检查传输的数据是否完整
     * @param string $data
     * @return int 返回计算数据段的CRC值
     */
    public static function crc32(string $data): int
    {
        return (int) sprintf("%u", crc32($data));
    }
    
    /**
     * 循环冗余校验16 - 数据完整性校验
     * @param string $data
     * @return int 返回计算数据段的CRC值
     */
    public static function crc16(string $data): int
    {
        $crc = 0xFFFF;
        for ($i = 0; $i < strlen($data); $i ++) {
            $crc ^= ord($data[$i]);
            
            for ($j = 8; $j != 0; $j --) {
                if (($crc & 0x0001) != 0) {
                    $crc >>= 1;
                    $crc ^= 0xA001;
                } else
                    $crc >>= 1;
            }
        }
        return $crc;
    }
    
    /**
     * 循环冗余校验64
     * @param string $string 数据
     * @param string $format 格式
     * @return mixed
     *
     * Formats:
     *  crc64('php'); // afe4e823e7cef190
     *  crc64('php', '0x%x'); // 0xafe4e823e7cef190
     *  crc64('php', '0x%X'); // 0xAFE4E823E7CEF190
     *  crc64('php', '%d'); // -5772233581471534704 signed int
     *  crc64('php', '%u'); // 12674510492238016912 unsigned int
     */
    public static function crc64($string, $format = '%x')
    {
        static $crc64tab;
        
        if ($crc64tab === null) {
            $crc64tab = self::crc64Table();
        }
        
        $crc = 0;
        
        for ($i = 0; $i < strlen($string); $i ++) {
            $crc = $crc64tab[($crc ^ ord($string[$i])) & 0xff] ^ (($crc >> 8) & ~ (0xff << 56));
        }
        
        return sprintf($format, $crc);
    }

    /**
     *
     * @return array
     */
    private static function crc64Table()
    {
        $crc64tab = [];
        
        // ECMA多项式
        $poly64rev = (0xC96C5795 << 32) | 0xD7870F42;
        
        // ISO多项式
        // $poly64rev = (0xD8 << 56);
        
        for ($i = 0; $i < 256; $i ++) {
            for ($part = $i, $bit = 0; $bit < 8; $bit ++) {
                if ($part & 1) {
                    $part = (($part >> 1) & ~ (0x8 << 60)) ^ $poly64rev;
                } else {
                    $part = ($part >> 1) & ~ (0x8 << 60);
                }
            }
            
            $crc64tab[$i] = $part;
        }
        
        return $crc64tab;
    }
}