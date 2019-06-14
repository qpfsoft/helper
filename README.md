# helper V1

> QPF Common Helper library

- php >= 5.6

## Export

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
## Moni

根据规则生成随机内容, 模拟(Moni)数据.

规则:
```
legnth // 长度
min-max // 取值范围 1~100
minLength-maxLength // 最小长度-最大长度
```

注意: 数字类型的规则, 4有时候不是代表生成的长度, 而是固定值.