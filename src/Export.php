<?php
// ╭───────────────────────────────────────────────────────────┐
// │ QPF Framework [Key Studio]
// │-----------------------------------------------------------│
// │ Copyright (c) 2016-2019 quiun.com All rights reserved.
// │-----------------------------------------------------------│
// │ Author: qiun <qiun@163.com>
// ╰───────────────────────────────────────────────────────────┘
namespace qpf\helper;

/**
 * 变量输出助手
 * @author qpfsoft
 */
class Export
{
    /**
     * 类型输出
     * @param mixed $var 变量
     * @return void
     */
    public static function dump($var)
    {
        ob_start();
        var_dump($var);
        echo ob_get_clean();
    }
    
    /**
     * 易读输出
     * @param mixed $var 变量
     * @return void
     */
    public static function print($var)
    {
        $isCli = PHP_SAPI == 'cli';
        echo ($isCli ? '': '<pre>') . print_r($var, true) . ($isCli ? '': '</pre>');
    }
    
    /**
     * 原样换行并输出
     * @param mixed $var 变量
     * @return void
     */
    public static function echo($var)
    {
        echo $var . self::eol();
    }
    
    /**
     * 输出变量
     * @param mixed $var 变量
     * @param bool $return 返回打印内容
     * @return string
     */
    public static function echor($var, $return = false)
    {
        if (is_array($var)) {
            $var = self::varArray($var);
        } elseif (is_object($var)) {
            $var = self::varObject($var);
        } else {
            $var = self::varStr($var);
        }
        
        if ($return) {
            return $var;
        }
        
        echo  $var . self::eol();
    }
    
    /**
     * 获取变量内容描述
     * @param mixed $var 变量
     * @return mixed
     */
    public static function varStr($var)
    {
        return var_export($var, true);
    }
    
    /**
     * 将数组转换为字符串
     *
     * 该方法相当于[[Export::compact(Export::varArray($arr))]]的执行效果,
     * 但区别的是, 有适当的空格更方便查看.
     *
     * @param array $var 数组
     * @return string
     */
    public static function arrsrt($var)
    {
        if (is_array($var)) {
            $temp = [];
            foreach ($var as $key => $value) {
                $temp[] =  var_export($key, true) . ' => ' . self::arrsrt($value);
            }
            
            return '[' . implode(', ', $temp) . ']';
        } else {
            return var_export($var, true);
        }
    }
    
    /**
     * 获取数组的字符串描述
     * @param array $var 数组
     * @return string
     */
    public static function varArray(array $var)
    {
        $export = var_export($var, true);
        
        if (is_array($var)) {
            $export = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $export);
            $array = preg_split("/\r\n|\n|\r/", $export);
            $array = preg_replace(["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"], [NULL, ']$1', ' => ['], $array);
            $export = implode(PHP_EOL, array_filter(['['] + $array));
            return $export;
        }
    }
    
    /**
     * 获取对象的字符串描述
     * @param object $var 对象
     * @return string
     */
    public static function varObject($var)
    {
        $export = var_export($var, true);
        
        if (is_object($var)) {
            $export = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $export);
            $export = preg_replace(['/(\w+)::__set_state\(array\(/', '/\)\)/'], ['[\'$1 (object)\' => $2', ']'], $export);
            $export = implode(self::eol(), preg_split("/\r\n|\n|\r/", $export));
            return $export;
        }
    }
    
    /**
     * 自适应换行符
     *
     * 网页以br标签, 控制台以文本换行
     * @return string
     */
    public static function eol()
    {
        return PHP_SAPI == 'cli' ? PHP_EOL : '<br>';
    }
    
    /**
     * 紧凑格式
     * @param string $str 包含空白(空格)与换行的字符串
     * @return string
     */
    public static function compact($str)
    {
        return str_replace([' ', PHP_EOL, '<br>', ',]'], ['', '', '', ']'], $str);
    }
}