<?php
use qpf\helper\Export;

include 'boot.php';


// 数组数据
$arr = ['name'=> 'a', 'b' => [54, 95, 85], 'c'];
// 普通变量
$int = '5';
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

$obj = new Foo();
$obj->name = new Foo();


// 打印数组
Export::echor($arr);

// 紧凑格式, 使用echor来输出会进行转义
echo Export::compact(Export::varArray($arr)) . Export::eol();

// 
echo Export::arrsrt($arr) . Export::eol();

Export::print($obj);

Export::dump($arr);

//Export::echor($obj);


//Export::echor( Export::varObject($obj) );
//Export::echor( Export::compact(Export::varObject($obj)) );


