<?php
if (!function_exists('echor')) {
    /**
     * 输出变量
     * @param mixed $var 变量
     * @param bool $return 返回打印内容
     * @return string
     */
    function echor($var, $return = false)
    {
        return \qpf\helper\Export::echor($var, $return);
    }
}