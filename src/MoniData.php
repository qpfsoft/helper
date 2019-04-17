<?php
// ╭───────────────────────────────────────────────────────────┐
// │ QPF Framework [Key Studio]
// │-----------------------------------------------------------│
// │ Copyright (c) 2016-2019 quiun.com All rights reserved.
// │-----------------------------------------------------------│
// │ Author: qiun <qiun@163.com>
// ╰───────────────────────────────────────────────────────────┘
namespace qpf\helper;

/**
 * 生成模拟数据
 */
class MoniData
{
    /**
     * 生成随机中文名
     * @return string
     */
    public static function nameChinese()
    {
        $name = ['王','李','张','刘','陈','杨','赵','黄','周','吴','徐','孙','胡','朱','高','林','何','郭','马'];
        return Moni::arrVal($name) . Moni::chinese('1-2');
    }
    
    /**
     * 生成随机手机号
     * @param array $prefix 手机号前缀
     * @return string
     */
    public static function mobile(array $prefix = [])
    {
        $prefix = $prefix ?: [135,136,137,138,139,144,147,150,151,152,153,155];
        
        return Moni::arrVal($prefix) . Moni::number(8);
    }
    
    /**
     * 生成URL地址
     * @param array $domain 域名集合
     * @param array $suffix 后缀名集合
     * @param array $protocol 协议集合
     * @return string
     */
    public static function url(array $domain = [], array $suffix = [], array $protocol = [])
    {
        $protocol = $protocol ?: ['http', 'https'];
        $domain = $domain ?: ['www.baidu.com', 'www.soso.com', 'www.sogou.com', 'www.so.com'];
        $suffix = $suffix ?: ['html', 'htm'];
        
        return Moni::arrVal($protocol) . '://' . Moni::arrVal($domain) .
        '/'.  Moni::string('4-8') .  '.' . Moni::arrVal($suffix);
    }
    
    /**
     * 生成随机邮箱地址
     * @param array $suffix 邮箱后缀名
     * @return string
     */
    public static function email(array $suffix = [])
    {
        $suffix = $suffix ?: ['@qq.com','@163.com','@yahoo.com','@gmail.com','@hotmail.com'];
        
        $suffix = Moni::arrVal($suffix);
        
        if ($suffix == '@qq.com') {
            return Moni::number('10000-100000000') . $suffix;
        }
        
        return Moni::string('6-8', Moni::buildStrData(false, false, false) . '_') . $suffix;
    }
    
    
    /**
     * 随机银行名称
     * @return string
     */
    public static function bankName()
    {
        return Moni::arrVal(self::bankData());
    }
    
    /**
     * 随机银行标识
     * @return mixed
     */
    public static function bankId()
    {
        return array_rand(self::bankData());
    }
    
    /**
     * 随机银行信息
     * @return array [英文标识, 中文名称]
     */
    public static function bankItem()
    {
        $data = self::bankData();
        $key = array_rand($data, 1);
        
        return [$key, $data[$key]];
    }
    
    /**
     * 银行类型数据
     * @return array
     */
    protected static function bankData()
    {
        return [
            'ICBC'=> '中国工商银行',
            'CCB' => '中国建设银行',
            'ABC' => '中国农业银行',
            'CMBC'=> '中国民生银行',
            'CEB' => '中国光大银行',
            'BOC' => '中国银行',
            'CMB' => '招商银行',
            'BCM' => '交通银行',
            'CIB' => '兴业银行',
            'GDB' => '广东发展银行'
        ];
    }
    
    public static function country()
    {
        
    }
}