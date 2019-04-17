# helper
QPF Common Helper library

## functions

```php
dump(); // 类型与长度输出
print(); // 易读输出, 适合数组与对象.
echo(); // 原样输出, 带换行.
echor(); // 自适应输出
arrstr(); // 返回数组的字符串, 数组描述将会显示在一行并带有适合的空白.
varStr(); // 返回变量的描述
varArray(); // 返回数组的描述, 有缩进与换行
varObject(); // 返回对象的描述, 有缩进与换行
eol(); // 根据运行环境返回合适的换行符
compact(); // 紧凑格式字符串, 去除 (换行, 空白, 结尾多余的逗号)
```


## 打印对象或数组

示例对象:
```php
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
```

### print

适合打印对象与数组.

```php
$obj = new Foo();
$obj->name = new Foo();

Export::print($obj); // 会直接输出
```

输出效果:
```php
Foo Object
(
    [name] => Foo Object
        (
            [name] => 
            [num:protected] => 5
            [key:Foo:private] => ok
        )

    [num:protected] => 5
    [key:Foo:private] => ok
)
```

### dump

打印时带数据类型, 可查看字符长度

```php
Export::dump($obj); // 会直接输出

// output :
object(Foo)#1 (3) {
  ["name"]=>
  object(Foo)#2 (3) {
    ["name"]=>
    NULL
    ["num":protected]=>
    int(5)
    ["key":"Foo":private]=>
    string(2) "ok"
  }
  ["num":protected]=>
  int(5)
  ["key":"Foo":private]=>
  string(2) "ok"
}
```
