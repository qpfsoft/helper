<?php
use qpf\helper\ParseObject;

include 'boot.php';

// 示例父类
class Doo
{
    public $doo_public = 1;
    protected $doo_protected = 2;
    private $doo_private = 3;
    
    public function fun_public() 
    {
        
    }
    
    protected function fun_protected()
    {
        
    }
    
    private function fun_private()
    {
        
    }
}

// 示例类
class Foo extends Doo
{
    public $public = 1;
    protected $protected = 2;
    private $private = 3;
    
    public function me_public()
    {
        
    }
    
    protected function me_protected()
    {
        
    }
    
    private function me_private()
    {
        
    }
}

class ParseObjectTest
{
    /**
     * 获取类的公共属性, 属性值为类文件内的默认值
     */
    public function base1()
    {
        $class = Foo::class;
        $object = new Foo(); // 做兼容, 实际上会转换为类名
        $object->public = 0; // 无效, 因为值为类默认值
        $arr = ParseObject::getPublicProperty($object);
        echor($arr);
    }
    
    /**
     * 获取类的公共方法, 不含继承来的方法
     */
    public function base2()
    {
        $arr = ParseObject::getPublicMethods(Foo::class);
        echor($arr);
    }
}

$test = new ParseObjectTest();

$test->base2();