<?php
use qpf\helper\Short;

include __DIR__ . '/boot.php';

class ShortTest
{
    /**
     * 将字符串效验值, 压缩为62进制的字符串
     */
    public function testStr()
    {
        echor([
            'http://www.x.com' => Short::str('http://www.x.com'),
            'abcdefghijklmnopqrsturwsyz'    => Short::str('abcdefghijklmnopqrsturwsyz'),
            'abcdefghijklmnopqrsturwsyz'    => Short::str('abcdefghijklmnopqrsturwsyz'),
            'string `1`' => Short::str('1'),
            'int 1' => Short::str(1),
        ]);
    }
    
    /**
     * 将字符串效验值, 映射到62个字符
     * 
     * - 可修改62个字符顺序, 生成不同的值
     */
    public function testHash()
    {
        echor([
            'http://www.x.com' => Short::hash('http://www.x.com'),
            'abcdefghijklmnopqrsturwsyz'    => Short::hash('abcdefghijklmnopqrsturwsyz'),
            'string `1`' => Short::hash('1'),
            'int 1' => Short::hash(1),
        ]);
    }
    
    /**
     * 数据循环冗余校验值
     */
    public function testCRC()
    {
        $str = 'abcdefghijklmnopqrsturwsyzabcdefghij';
        
        echor([
            Short::crc16($str), // 最快
            Short::crc32($str), 
            Short::crc64($str),
        ]);
    }
}

$test = new ShortTest();

$test->testStr();
$test->testHash();
$test->testCRC();



