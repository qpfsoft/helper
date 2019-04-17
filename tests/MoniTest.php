<?php
include __DIR__ . '/../src/Moni.php';

use qpf\helper\Moni;

class MoniTest
{
    /**
     * ����4λ�ַ���[a-zA-Z0-9]
     */
    public function string1()
    {
        $str = Moni::string(4);
        var_dump($str);
    }
    
    /**
     * �������1~4λ�ַ���
     */
    public function string2()
    {
        $str = Moni::string('62-64');
        var_dump($str);
    }
    
    /**
     * ָ���ַ�������
     */
    public function string3()
    {
        $str = Moni::string('4', '!@#$%^^&*()-=');
        var_dump($str);
    }
    
    /**
     * ����ָ�����ȵ��������
     */
    public function number1()
    {
        $num = Moni::number(4);
        var_dump($num);
    }
    
    /**
     * ����ָ�����ȵ��������, ��ָ���ַ�
     */
    public function number2()
    {
        $num = Moni::number(4, '10');
        var_dump($num);
    }
    
    /**
     * ����ָ����Χ������
     */
    public function number3()
    {
        // 100~200֮�����
        $num = Moni::number('100-200');
        var_dump($num);
    }
    
    /**
     * �������С��
     */
    public function float1()
    {
        // ��������, ���4λ
        // С������, ���2λ
        $str = Moni::float('1', '2');
        var_dump($str);
    }
    
    /**
     * �������С��
     */
    public function float2()
    {
        // ������С��, ���ڷ�Χ��ȡֵ
        $str = Moni::float('1-100', '10-999');
        var_dump($str);
    }
    
    /**
     * �������С��
     */
    public function float3()
    {
        // С�����ַ�Χ 1~999
        $str = Moni::float('3', '1-999');
        var_dump($str);
    }
    
    /**
     * �������ֵ
     */
    public function boolean1()
    {
        $str = Moni::boolean();
        var_dump($str);
    }
    
    /**
     * �̶�����ֵ
     */
    public function boolean2()
    {
        $str = Moni::boolean(false);
        var_dump($str);
    }
    
    /**
     * ����� true ֵ
     */
    public function boolean3()
    {
        $str = Moni::booleanTrue();
        var_dump($str);
    }
    
    /**
     * ����� false ֵ
     */
    public function boolean4()
    {
        $str = Moni::booleanFalse();
        var_dump($str);
    }
    
    /**
     * ��������ֵ
     */
    public function arr1()
    {
        // ���ع̶�������Ԫ��
        $str = Moni::arr(['a', 'b', 'c'], 1);
        var_dump($str);
    }
    
    /**
     * ��������ֵ, ��ȡ������ֵ
     */
    public function arr2()
    {
        // �������������Ԫ��
        $str = Moni::arr(['a', 'b', 'c'], '2-3');
        var_dump($str);
    }
    
    /**
     * �����������
     */
    public function date1()
    {
        // ����������ֱ��ʹ��. ָ����Χ�Ż����
        $str = Moni::date(['2017', '1-12', '1-30']);
        var_dump($str);
    }
    
    /**
     * �����������
     */
    public function date2()
    {
        $str = Moni::date(['2015-2017', '1-12', '1-30']);
        var_dump($str);
    }
    
    /**
     * ���ɵ�������
     */
    public function date3()
    {
        // ����������, �Թ̶���ֵ��������.
        $str = Moni::dateIncrement('2017-5-1', 10, 1);
        var_dump($str);
    }
    
    /**
     * ���ɵ�������
     */
    public function date4()
    {
        // ����������, �������Χ��ֵ��������.
        $str = Moni::dateIncrement('2017-5-1', 10, '1-5');
        var_dump($str);
    }
    
    /**
     * ���ɵݼ�����
     */
    public function date5()
    {
        // ����������, �������Χ��ֵ�ݼ�����.
        $str = Moni::dateDecrement('2017-5-1', 10, 1);
        var_dump($str);
    }
    
    /**
     * �������ʱ��
     */
    public function time1()
    {
        $str = Moni::time();
        var_dump($str);
    }
    
    /**
     * �����������ʱ��
     */
    public function datetime1()
    {
        $str = Moni::datetime(['2017-2018', '1-12', '1-30']);
        var_dump($str);
    }
}


$moniTest = new MoniTest();

$moniTest->string1();