<?php
use qpf\helper\Export;

include 'boot.php';

// 对象
class Foo
{
    public $name;
    protected $num = 5;
    private $key = 'ok';
    const TYPE_INT = 1;
    public function getName()
    {
        
    }
}

// =====================================================================

/**
 * 测试类
 */
class ExportTest
{
    // 数组数据
    public $arr = ['name'=> 'a', 'b' => [54, 95, 85], 'c'];
    // 普通变量
    public $int = '5';
    
    /**
     * 返回一个测试对象
     * @return Foo
     */
    public function getObj()
    {
        $obj = new Foo();
        $obj->name = new Foo();
        
        return $obj;
    }
    
    /**
     * 数组转字符串
     */
    public function base1()
    {
        // 紧凑格式, 使用echor来输出会进行转义
        echo Export::compact(Export::varArray($this->arr)) . Export::eol();
        
        // 在一行内显示数组描述文本, 带合适的间隔
        echo Export::arrsrt($this->arr) . Export::eol();
        
        // 当然也可以进行紧凑. 不过建议直接清除空格即可.
        // Export::compact(Export::arrsrt($this->arr));
    }
    
    /**
     * 打印数组
     */
    public function base2()
    {
        // 打印数组, 标准数组格式描述
        Export::echor($this->arr);
        
        // 打印数组, 适合人眼查看
        Export::print($this->arr);
        
        // 打印数组, 带类型与长度
        Export::dump($this->arr);
    }
    
    /**
     * 打印对象
     */
    public function base3()
    {
        // 打印对象, 标准数组格式描述
        Export::echor($this->getObj());
        
        // 打印对象, 适合人眼查看
        Export::print($this->getObj());
        
        // 打印对象, 带类型与长度
        Export::dump($this->getObj());
    }
    
    /**
     * 普通换行输出与增强输出
     */
    public function base4()
    {
        // 原样输出, 必须传入字符串, 否则会报错!
        Export::echo('1'); // 1
        Export::echo(null); //    , 空白
        
        // 增强输出
        
        // 可区分 字符串 1 与 整形 1 
        Export::echor('1'); // '1' 带引号
        Export::echor(1); // 1
        
        Export::echor(null); //  NULL
        
        // 总结:
        // echo() 用于需要原样输出字符串内容时
        // 因为 echor() 对于字符串会进行转义 `\name\' 影响查看.
    }
    
    /**
     * 代码高亮
     */
    public function base5()
    {
        $code = <<<'tag'
function test()
{
    return 'pl';
}
tag;
        Export::codeHighlight($code);
    }
    
    /**
     * 安全的输出含HTML的字符串
     */
    public function base6()
    {
        $var = '<h1>标题</h1>';
        Export::html($var);
    }
}


$test = new ExportTest();

$test->base3();

