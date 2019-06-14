<?php
namespace qpf\helper;

/**
 * Unicode 编码转换
 * 
 * - 常用于将js代码中的中文字符串转换为Unicode编码,
 * 因为游览器会正确的识别出内容
 */
class Unicode
{
    /**
     * UTF-8转Unicode
     * @param string $str 文本字符串 
     * @param bool $en 是否编码英文, 默认`false`仅编码中文,
     * 设置为`true`同时也可转换英文字母
     * @return string
     */
    public static function encode(string $str, bool $en = false): string
    {
        if($en) {
            return self::encodeAll($str);
        }
        return json_encode($str);
    }
    
    /**
     * 字符串全部转Unicode
     * @param string $str 文本字符串
     * @return string
     */
    public static function encodeAll(string $str): string
    {
        /**
         * 将字母转换为ASCCII码, 即 ord('='); // 61
         * 将ASCCII码转换为16进制, 即 base_convert('61', 10, 16); // 3d
         * `=`的Unicode码为\u003d
         * \u之后跟4位十六进制数。取值范围：\u0000 到 \uffff
         * \x之后跟2位十六进制数。取值范围：\x00 到 \xff
         */
        $com = '';
        $arr = preg_split('/(?<!^)(?!$)/u', $str );
        foreach ($arr as $s) {
            if (preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $s) > 0) {
                $com .= trim(json_encode($s), '"');
            } else {
                $com .= '\u00'. base_convert(ord($s), 10, 16);
            }
        }
        
        return $com;
    }
    
    /**
     * 仅编码英文字母
     * @param string $str 文本字符串
     * @return string
     */
    public static function encodeABC(string $str): string
    {
        $com = '';
        $arr = preg_split('/(?<!^)(?!$)/u', $str);
        foreach ($arr as $s) {
            $i = ord($s);
            if($i > 64 && $i < 91) { // A
                $com .= '\u00'. base_convert(ord($s), 10, 16);
            } elseif($i > 96 && $i < 123) { // a
                $com .= '\u00'. base_convert(ord($s), 10, 16);
            } else {
                $com .= $s;
            }
        }
        
        return $com;
    }

    /**
     * 仅编码特殊符号
     * @param string $str 文本字符串
     * @return string
     */
    public static function encodeSymbol(string $str): string
    {
        $arr = preg_split('/(?<!^)(?!$)/u', $str);
        foreach ($arr as $s) {
            if (preg_match('/((?=[\x21-\x7e]+)[^A-Za-z0-9])/', $s)) {
                $com .= '\u00' . base_convert(ord($s), 10, 16);
            } else {
                $com .= $s;
            }
        }
        return $com;
    }
    
    /**
     * Unicode转UTF-8
     * @param string $unicode Unicode字符
     * @return string
     */
    public static function decode(string $unicode): string
    {
        $json = '{"str":"' . $unicode . '"}';
        $arr = json_decode($json, true);
        
        if ($arr === null) {
            return '';
        }
            
        return $arr['str'];
    }
    
    /**
     * 将Unicode中文编码转换成Utf8中文
     * @param string $str Unicode字符
     * @return string
     */
    public static function unicodeToUtf8(string $str): string
    {
        return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 
            create_function('$matches', 'return iconv("UCS-2BE","UTF-8",pack("H*", $matches[1]));'), $str);
    }
}