<?php
use qpf\helper\NameChinese;

include 'boot.php';

class NameChineseTest
{
    public function getNameChinese()
    {
        return new NameChinese();
    }
    
    /**
     * 生成随机名字
     */
    public function base1()
    {
        $obj = $this->getNameChinese();
        
        echo $obj->build();
    }
    
    /**
     * 生成男生名
     */
    public function base2()
    {
        $obj =$this->getNameChinese();
        
        echo $obj->buildBoy();
    }
    
    /**
     * 生成女生名
     */
    public function base3()
    {
        $obj =$this->getNameChinese();
        
        echo $obj->buildGirl();
    }
}

$test = new NameChineseTest();

$test->base3();