<?php
namespace qpf\helper;

/**
 * ģ������������
 */
class Moni
{
    /**
     * ��������ַ���
     * ```
     * string(2); //oj
     * string('1-4'); // o, ed, sdf, 4agu
     * string([1, 4]);
     * string(4, 'abcdefg'); // aegd
     * ```
     * @param mixed $rule �ַ���
     * @param string $seed �Զ�������
     * @return string
     */
    public static function string($rule, $seed = null)
    {
        $chars = $seed ?: self::buildStrData(true, true, false);
        
        if (is_numeric($rule)) {
            return self::length($rule, $chars);
        }
        
        list($min, $max) = self::parseRule($rule);
        
        if ($max > strlen($chars) - 1) {
            $chars = str_pad($chars, $max, $chars);
        }
        
        return substr(str_shuffle($chars), 0, mt_rand(max(1, $min), $max));
    }
    
    /**
     * �����������
     * @param mixed $rule λ��, `length|min-max`
     * @param string $seed �Զ�������
     * @return int
     */
    public static function number($rule, $seed = null)
    {
        $chars = $seed ?: '0123456789';
        
        if (is_numeric($rule)) {
            return (int) self::length($rule, $chars);
        }
        
        list($min, $max) = self::parseRule($rule);
        
        return (int) mt_rand(max(1, $min), $max);
    }
    
    /**
     * ���ɸ�����
     * @param mixed $intRule �������ֹ��� `length|min-max`
     * @param mixed $tinyRule С�����ֹ��� `length|min-max`
     * @return float
     */
    public static function float($intRule, $tinyRule)
    {
        return (float) self::number($intRule) . '.' . self::number($tinyRule);
    }
    
    /**
     * �����������ֵ
     * @param bool $rule �ֶ�ָ��
     * @return bool
     */
    public static function boolean($rule = null)
    {
        if (null === $rule) {
            return (bool) mt_rand(0, 1);
        }
        
        return (bool) $rule;
    }
    
    /**
     * ���ɸ����Trueֵ
     * @param int $rule 100 - 90 = 10%�ļ��ʻ�false
     * @return boolean
     */
    public static function booleanTrue($rule = 90)
    {
        return mt_rand(1, 100) < $rule;
    }
    
    /**
     * ���ɸ����Falseֵ
     * @param int $rule 100 - 90 = 10%�ļ��ʻ�true
     * @return boolean
     */
    public static function booleanFalse($rule = 90)
    {
        return mt_rand(1, 100) > $rule;
    }
    
    /**
     * �������һ��Ԫ�ص�ֵ
     * @param array $array ��������
     * @param int $rule ����Ԫ������`length|min-max`
     * @return array
     */
    public static function arr($array, $rule)
    {
        $max_key = count($array) - 1;
        
        $num = is_numeric($rule) ? $rule : self::number($rule);
        
        $rand_value = [];
        for ($i = 0; $i < $num; $i++) {
            $rand_value[] = $array[mt_rand(0, $max_key)];
        }
        return $rand_value;
    }
    
    /**
     * �������
     *
     * ȡֵ��Χ`1~99`
     * @param string|array $rule ����`Y-m-d`, `[Y, m, d]`
     * @return string
     */
    public static function date($rule)
    {
        list($y, $m, $d) = self::parseRule($rule, 3);
        
        $y = is_numeric($y) ? $y : self::number($y);
        $m = min(is_numeric($m) ? $m : self::number($m), 99);
        $d = min(is_numeric($d) ? $d : self::number($d), 99);
        
        return \DateTime::createFromFormat('Y-m-d', "$y-$m-$d")->format('Y-m-d');
    }
    
    /**
     * ����������� - ����
     * @param string $rule ����`Y-m-d`
     * @param int $num ��������
     * @param string $incRule ��������, 'int'�̶����ֵ, 'min-max'������ֵ
     * @return array
     */
    public static function dateIncrement($rule, $num , $incRule = '1-2')
    {
        list($y, $m, $d) = self::parseRule($rule, 3);
        
        $result = [];
        $isNum = is_numeric($incRule);
        $date = date_create("$y-$m-$d");
        $inc = $isNum ? $incRule : self::number($incRule);
        
        for ($i = 0; $i < $num; $i++) {
            date_add($date, date_interval_create_from_date_string(intval($inc).' day'));
            $result[] = date_format($date, 'Y-m-d');
        }
        
        return $result;
    }
    
    /**
     * ���ڵݼ�
     * @param string $rule ����`Y-m-d`
     * @param int $num ��������
     * @param string $incRule ��������, 'int'�̶����ֵ, 'min-max'������ֵ
     * @return array
     */
    public static function dateDecrement($rule, $num , $incRule = '1-2')
    {
        list($y, $m, $d) = self::parseRule($rule, 3);
        
        $result = [];
        $isNum = is_numeric($incRule);
        $date = date_create("$y-$m-$d");
        $inc = $isNum ? $incRule : self::number($incRule);
        
        for ($i = 0; $i < $num; $i++) {
            date_add($date, date_interval_create_from_date_string('- '. intval($inc) .' day'));
            $result[] = date_format($date, 'Y-m-d');
        }
        
        return $result;
    }
    
    /**
     * ���ʱ��
     * @param string $rule
     * @return string
     */
    public static function time()
    {
        $h = mt_rand(1, 12);
        $i = mt_rand(0, 59);
        $s = mt_rand(0, 59);
        
        $date = date_create("1999-1-1 $h:$i:$s");
        
        date_add($date, date_interval_create_from_date_string('+ '. intval($h) .' hours'));
        date_add($date, date_interval_create_from_date_string('+ '. intval($i) .' minutes'));
        date_add($date, date_interval_create_from_date_string('+ '. intval($s) .' seconds'));
        
        return date_format($date, 'H:i:s');
    }
    
    
    public static function datetime($rule)
    {
        return self::date($rule) . ' ' . self::time();
    }
    
    /**
     * �����������
     * ```
     * '1-4' => [1, 4]
     * ```
     * @param string|array $rule ����
     * @param int $num �ָ�����, Ĭ��`2`
     * @return array
     */
    private static function parseRule($rule, $num = 2)
    {
        if (!is_array($rule)) {
            $rule = explode('-', $rule, $num);
        }
        
        return $rule;
    }
    
    /**
     * ����ָ�����ȵ�����ַ���
     * @param int $length ���ɳ���
     * @param string $chars �ַ�����
     * @return string
     */
    private static function length($length, $chars)
    {
        $length = max(1, $length); // ��С1λ
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $result;
    }
    
    /**
     * ʹ�ù�������
     *
     * ```
     * useRuleBuild(1);
     * useRuleBuild('1-4');
     * useRuleBuild([1, 4]);
     * useRuleBuild(1, 'abc');
     * ```
     * @param mixed $rule ����`length|minLength-maxLength`
     * @param string $chars �ַ�����
     * @return mixed
     */
    private static function useRuleBuild($rule, $chars)
    {
        if (is_numeric($rule)) {
            $rule = max(1, $rule);
            $result = '';
            for ($i = 0; $i < $rule; $i++) {
                $result .= $chars[mt_rand(0, strlen($chars) - 1)];
            }
            return $result;
        }
        
        if (!is_array($rule)) {
            $rule = explode('-', $rule, 2);
        }
        
        list($min, $max) = $rule;
        
        if ($max > strlen($chars) - 1) {
            $chars = str_pad($chars, $max, $chars);
        }
        
        return substr(str_shuffle($chars), 0, mt_rand(max(1, $min), $max));
    }
    
    /**
     * ��ȡ�ַ�����������
     * @param bool $upper �Ƿ������д��ĸ
     * @param bool $number �Ƿ��������
     * @param bool $rand �Ƿ����˳��
     * @return string
     */
    public static function buildStrData($upper = true, $number = true, $rand = false)
    {
        $data = 'abcdefghijklmnopqrstuvwxyz';
        $data .= $upper ? 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' : '';
        $data .= $number ? '1234567890' : '';
        
        return $rand ? str_shuffle($data) : $data;
    }
    
    /**
     * ��ȡ�������
     * @param int $num ��ȡ����
     * @param string $charset �ַ���
     * @return array ����ָ�������ĺ�������
     */
    public static function buildStrChinese($num, $charset = 'utf-8')
    {
        $result = [];
        for ($i = 0; $i < $num; $i ++) {
            $result[] = iconv('GB2312', $charset, chr(mt_rand(0xB0, 0xD0)) . chr(mt_rand(0xA1, 0xF0)));
        }
        
        return $result;
    }
}