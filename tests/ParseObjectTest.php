<?php
use qpf\helper\ParseObject;

include 
include __DIR__ . '/../src/ParseObject.php';

class Foo
{
    public $public = 1;
    protected $protected = 2;
    private $private = 3;
}

class ParseObjectTest
{
    public function base1()
    {
        $class = Foo::class;
        $arr = ParseObject::getPublicProperty($class);
    }
}