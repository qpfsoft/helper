# helper
QPF Common Helper library


## 打印对象或数组

示例对象:
```
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

```
Export::print($obj);
```

输出效果:
```
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