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
        $str = ob_get_clean();
        $isCli = PHP_SAPI == 'cli';
        echo ($isCli ? '' : '<pre style="white-space: pre-wrap;word-wrap: break-word;">') . 
        $str . ($isCli ? '' : '</pre>');
    }
    
    /**
     * 易读输出
     * @param mixed $var 变量
     * @param bool $return 返回输出
     * @return void
     */
    public static function print($var)
    {
        $isCli = PHP_SAPI == 'cli';
        echo ($isCli ? '': '<pre>') . print_r($var, true) .  ($isCli ? '': '</pre>');

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
            $str = self::varArray($var);
        } elseif (is_object($var)) {
            $str = 'Object("' . get_class($var) . '") {';
            $vars = ParseObject::getobjectVars($var);
            if (is_array($vars) && isset($vars[2])) {
                $str .= self::varArray($vars[2], true);
            }
            $str .= '}';
        } elseif (is_string($var)) {
            $str = var_export($var, true);
        } else {
            $str = self::varStr($var);
        }
        
        if ($return) {
            return $str;
        }
        
        echo  $str . self::eol();
    }
    
    /**
     * 对象输出
     * @param object $var
     * @param bool $return
     * @return array
     */
    public static function objct($var, $return = false)
    {
        return self::echor(self::varObject($var), $return);
    }
    
    /**
     * 高亮输出脚本代码
     * @param string $var 代码
     * @param bool $return 返回输出
     * @return string
     */
    public static function codeHighlight($var, $return = false)
    {
        $result = highlight_string("<?php\n" . $var, true);
        $result = preg_replace('/&lt;\\?php<br \\/>/', '', $result, 1);
        if ($return) {
            return $result;
        }
        
        echo $result;
    }
    
    /**
     * 安全的输出带html的内容
     * @param string $var 字符串
     * @param bool $return 返回输出
     * @return mixed
     */
    public static function html($var, $return = false)
    {
        $result = str_replace(' ', '&nbsp;', htmlspecialchars($var, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', true));
        if ($return) {
            return $result;
        }
        echo $result;
    }
    
    /**
     * 获取变量内容描述
     * @param mixed $var 变量
     * @return mixed
     */
    public static function varStr($var)
    {
        if (is_array($var)) {
            $map_varstr = function (array $arr) use (&$map_varstr) {
                foreach ($arr as $i => $v) {
                    if (is_array($v)) {
                        $arr[$i] = $map_varstr($v);
                    } else {
                        $arr[$i] = self::varStr($v);
                    }
                }
                return $arr;
            };
            
            return print_r($map_varstr($var), true);
        } elseif ($var === null) {
            return 'null';
        } elseif ($var === true || $var === false) {
            return $var ? 'true' : 'false';
        } elseif (is_int($var) || is_float($var)) {
            return $var;
        } elseif (is_numeric($var)) {
            return '\'' . $var . '\'';
        } elseif (is_string($var)) {
            if (strpos($var, '<') !== false || strpos($var, '>') !== false) {
                $var = html_encode($var);
            }
            return '\'' . trim($var, '\'') . '\'';
        } elseif ($var instanceof \Closure) {
            return 'function(){}';
        } elseif (is_object($var)) {
            return 'Object("' . get_class($var) . '"){}';
        } elseif (is_resource($var)) {
            return '{resource}';
        } else {
            return '{unknown}';
        }
    }
    
    /**
     * 获取数组的字符串描述
     * @param array $array 数组
     * @return string
     */
    public static function varArray($array, $level = 1)
    {
        if (!is_array($array)) {
            return self::varStr($array);
        } 

        $tab_level = str_repeat(self::tab(), $level);
        $str = '';
        if (empty($array)) {
            $str = '[]';
        } else {
            $tmp = '[' . self::eol();
            $lastKey = array_last_key($array);
            
            foreach ($array as $index => $value) {
                $comma = $lastKey == $index ? '' : ',';
                if (is_array($value)) {
                    $tmp .= $tab_level . var_export($index, true) . ' => ';
                    $tmp .= self::varArray($value, $level + 1) . $comma . self::eol();
                } else {
                    $tmp .= $tab_level . var_export($index, true) . ' => ' . self::varArray($value) . $comma . self::eol();
                }
            }
            
            if ($level > 1) {
                $str = $tmp . $tab_level = str_repeat(self::tab(), $level - 1) . ']';
            } else {
                $str = $tmp . ']';
            }
        }
        return $str;
    }

    /**
     * 获取对象的字符串描述
     * @param object $var 对象
     * @return array
     */
    public static function varObject($var)
    {
        return ParseObject::getObjectArray($var);
    }
    
    /**
     * 自适应换行符
     *
     * 网页以br标签, 控制台以文本\r\n
     * @return string
     */
    public static function eol()
    {
        return PHP_SAPI == 'cli' ? PHP_EOL : '<br>';
    }
    
    /**
     * 自适应制表符
     * 
     * 网页以&nbsp;标签, 控制台以文本\t
     * @return string
     */
    public static function tab()
    {
        return PHP_SAPI == 'cli' ? "\t" : '&nbsp;&nbsp;&nbsp;&nbsp;';
    }
    
    /**
     * 紧凑格式
     * @param string $str 包含空白(空格)与换行的字符串
     * @return string
     */
    public static function compact($str)
    {
        return str_replace([' ', PHP_EOL, '<br>', "\t", ',]'], ['', '', '', '',']'], $str);
    }
}