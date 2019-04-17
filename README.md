# helper
QPF Common Helper library


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