<?php
namespace qpf\helper;

/**
 * 计算器
 * 
 * # DOC
 * max - 求最大值
 * min - 求最小值
 * pi - 获取圆周率
 */
class Calculator
{
    /**
     * 求绝对值 - 非负数
     * ```
     * abs(-4.2); // 4.2
     * ```
     * @param mixed $number
     * @return number
     */
    public static function abs($number)
    {
        return abs($number);
    }
    
    /**
     * 浮点数四舍五入
     * @param float $val 浮点数
     * @param int $scale 保留的小数位数
     * @return float
     */
    public static function round($val, $scale = 0)
    {
        return round($val);
    }
    
    /**
     * 进一取整法
     * ```
     * ceil(4.3) // 5
     * ceil(-3.14) // -3
     * ```
     * 正数任意小数位, 都将进一
     *
     * @param float $value 小数
     * @return float 返回下一个整数
     */
    public static function ceil($value)
    {
        return ceil($value);
    }
    
    /**
     * 舍去小数部分取整
     * ```
     * floor(4.5); // 4
     * ```
     * @param float $value 小数
     * @return mixed
     */
    public static function floor($value)
    {
        return floor($value);
    }
    
    /**
     * 乘方值
     * ```
     * 2的3次方 = 2*2*2 = 8
     * ```
     * @param string $x 基础值
     * @param string $y n次方, n个基础值相乘
     * @param int $scale 可选,设置结果的小数位数
     * @return string
     */
    public static function pow($x, $y, $scale = null)
    {
        return bcpow($x, $y, $scale);
    }
    
    /**
     * 二次方根
     * @param string $operand 操作数
     * @param int $scale 可选,设置结果的小数位数
     * @return string 如果操作数为负数则返回null
     */
    public static function sqrt($operand, $scale = null)
    {
        return bcsqrt($operand, $scale);
    }
    
    /**
     * 除法运算
     * ```
     * chu('105', '6.55957', 3); // 16.007
     * ```
     * 被除数=除数×商+余数
     *
     * @param string $x 被除数, 任意数字
     * @param string $y 除数. 任意数字
     * @param integer $scale 可选,设置结果的小数位数
     * @return string 返回x/y的结果，如果$num2是0结果为null
     */
    public static function chu($num1, $num2, $scale = null)
    {
        return bcdiv($num1, $num2, $scale = null);
    }
    
    /**
     * 商 x ÷ y
     * ```
     * 23 / 5 , 商4 (4x5=20), 余数3 (23-20)
     * ```
     * @param integer $num1 值1
     * @param integer $num2 值2
     * @return integer|null 返回商值,如果商为0则返回null
     */
    public static function shang($num1, $num2)
    {
        return bcmod($num2, $num1);
    }
    
    /**
     * 加 x + y
     *
     * @param string $x 值1
     * @param string $y 值2
     * @param int $scale 可选,设置结果的小数位数
     * @return string
     */
    public static function jia($x, $y, $scale = null)
    {
        return bcadd($x, $y, $scale);
    }
    
    /**
     * 减 x - y
     * @param string $x 值1
     * @param string $y 值2
     * @param int $scale 可选,结果小数点保留位数
     * @return int
     */
    public static function jian($x, $y, $scale = null)
    {
        return bcsub($x, $y, $scale);
    }
    
    /**
     * 乘 - x * y
     * @param string $x 值1
     * @param string $y 值2
     * @param int $scale 可选,结果小数点保留位数
     * @return string
     */
    public static function cheng($x, $y, $scale = null)
    {
        return bcmul($x, $y, $scale);
    }
}