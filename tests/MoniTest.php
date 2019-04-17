<?php
include __DIR__ . '/../src/Moni.php';

use qpf\helper\Moni;

class MoniTest
{
    /**
     * 生成4位字符串[a-zA-Z0-9]
     */
    public function string1()
    {
        $str = Moni::string(4);
        var_dump($str);
    }
    
    /**
     * 生成随机1~4位字符串
     */
    public function string2()
    {
        $str = Moni::string('62-64');
        var_dump($str);
    }
    
    /**
     * 指定字符串种子
     */
    public function string3()
    {
        $str = Moni::string('4', '!@#$%^^&*()-=');
        var_dump($str);
    }
    
    /**
     * 生成指定长度的随机数字
     */
    public function number1()
    {
        $num = Moni::number(4);
        var_dump($num);
    }
    
    /**
     * 生成指定长度的随机数字, 按指定字符
     */
    public function number2()
    {
        $num = Moni::number(4, '10');
        var_dump($num);
    }
    
    /**
     * 生成指定范围的数字
     */
    public function number3()
    {
        // 100~200之间的数
        $num = Moni::number('100-200');
        var_dump($num);
    }
    
    /**
     * 生成随机小数
     */
    public function float1()
    {
        // 整数部分, 随机4位
        // 小数部分, 随机2位
        $str = Moni::float('1', '2');
        var_dump($str);
    }
    
    /**
     * 生成随机小数
     */
    public function float2()
    {
        // 整数与小数, 都在范围内取值
        $str = Moni::float('1-100', '10-999');
        var_dump($str);
    }
    
    /**
     * 生成随机小数
     */
    public function float3()
    {
        // 小数部分范围 1~999
        $str = Moni::float('3', '1-999');
        var_dump($str);
    }
    
    /**
     * 随机布尔值
     */
    public function boolean1()
    {
        $str = Moni::boolean();
        var_dump($str);
    }
    
    /**
     * 固定布尔值
     */
    public function boolean2()
    {
        $str = Moni::boolean(false);
        var_dump($str);
    }
    
    /**
     * 大概率 true 值
     */
    public function boolean3()
    {
        $str = Moni::booleanTrue();
        var_dump($str);
    }
    
    /**
     * 大概率 false 值
     */
    public function boolean4()
    {
        $str = Moni::booleanFalse();
        var_dump($str);
    }
    
    /**
     * 随机数组的值
     */
    public function arr1()
    {
        // 返回固定数量的元素
        $str = Moni::arr(['a', 'b', 'c'], 1);
        var_dump($str);
    }
    
    /**
     * 随机数组的值, 获取多个随机值
     */
    public function arr2()
    {
        // 返回随机数量的元素
        $str = Moni::arr(['a', 'b', 'c'], '2-3');
        var_dump($str);
    }
    
    /**
     * 生成随机日期
     */
    public function date1()
    {
        // 传入整数将直接使用. 指定范围才会随机
        $str = Moni::date(['2017', '1-12', '1-30']);
        var_dump($str);
    }
    
    /**
     * 生成随机日期
     */
    public function date2()
    {
        $str = Moni::date(['2015-2017', '1-12', '1-30']);
        var_dump($str);
    }
    
    /**
     * 生成递增日期
     */
    public function date3()
    {
        // 参照年月日, 以固定的值递增天数.
        $str = Moni::dateIncrement('2017-5-1', 10, 1);
        var_dump($str);
    }
    
    /**
     * 生成递增日期
     */
    public function date4()
    {
        // 参照年月日, 以随机范围的值递增天数.
        $str = Moni::dateIncrement('2017-5-1', 10, '1-5');
        var_dump($str);
    }
    
    /**
     * 生成递减日期
     */
    public function date5()
    {
        // 参照年月日, 以随机范围的值递减天数.
        $str = Moni::dateDecrement('2017-5-1', 10, 1);
        var_dump($str);
    }
    
    /**
     * 生成随机时间
     */
    public function time1()
    {
        $str = Moni::time();
        var_dump($str);
    }
    
    /**
     * 生成随机日期时间
     */
    public function datetime1()
    {
        $str = Moni::datetime(['2017-2018', '1-12', '1-30']);
        var_dump($str);
    }
}


$moniTest = new MoniTest();

$moniTest->string1();