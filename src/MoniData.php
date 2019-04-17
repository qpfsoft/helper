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
     * 随机邮编
     * @return int
     */
    public static function zipCode()
    {
        return Moni::number('100000-860000');
    }
    
    /**
     * 随机IP地址
     * @return string
     */
    public static function ip()
    {
        $long = [
            ['607649792', '608174079'], //36.56.0.0-36.63.255.255
            ['975044608', '977272831'], //58.30.0.0-58.63.255.255
            ['999751680', '999784447'], //59.151.0.0-59.151.127.255
            ['1019346944', '1019478015'], //60.194.0.0-60.195.255.255
            ['1038614528', '1039007743'], //61.232.0.0-61.237.255.255
            ['1783627776', '1784676351'], //106.80.0.0-106.95.255.255
            ['1947009024', '1947074559'], //116.13.0.0-116.13.255.255
            ['1987051520', '1988034559'], //118.112.0.0-118.126.255.255
            ['2035023872', '2035154943'], //121.76.0.0-121.77.255.255
            ['2078801920', '2079064063'], //123.232.0.0-123.235.255.255
            ['-1950089216', '-1948778497'], //139.196.0.0-139.215.255.255
            ['-1425539072', '-1425014785'], //171.8.0.0-171.15.255.255
            ['-1236271104', '-1235419137'], //182.80.0.0-182.92.255.255
            ['-770113536', '-768606209'], //210.25.0.0-210.47.255.255
            ['-569376768', '-564133889'], //222.16.0.0-222.95.255.255
        ];
        
        $key = mt_rand(0, 14);
        
        return long2ip(mt_rand($long[$key][0], $long[$key][1]));
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
    
    /**
     * 随机国家名称
     * @return string
     */
    public static function countryName()
    {
        return Moni::arrVal(self::countryData());
    }
    
    /**
     * 随机国家英文表示
     * @return mixed
     */
    public static function countryId()
    {
        return array_rand(self::countryData());
    }
    
    /**
     * 国家类型数据
     * @return array
     */
    protected static function countryData()
    {
        return [
            'CHN'=> '中国',
            'USA' => '美国',
            'UK' => '英国',
            'FRA'=> '法国',
            'RUS' => '俄罗斯',
            'JPN' => '日本',
            'GER' => '德国',
            'KOR' => '韩国',
            'IND' => '印度',
            'ITA' => '意大利',
            'CAN' => '加拿大',
        ];
    }
    
    /**
     * 随机中国区域
     * @return string
     */
    public static function region()
    {
        return Moni::arrVal(['华东', '华南', '华中', '华北', '西北', '西南', '东北', '港澳台']);
    }
    
    /**
     * 生成随机身份证
     * @return string
     */
    public static function idCard()
    {
        $identity_card = '';
        // 身份证起止年月 eg：1990年12月31日 mktime(0,0,0,12,31,1990)
        $year_start = mktime(0, 0, 0, 1, 1, 1950);
        $year_end = mktime(0, 0, 0, 12, 31, 1992);
        // 全国区域代码 共3131
        $Region= RegionData::$data;
        function calc_suffix_d ($base){
            if (strlen($base) <> 17){
                die('Invalid Length');
            }
            $factor = array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
            $sums = 0;
            for ($i=0;$i< 17;$i++){
                $sums += substr($base,$i,1) * $factor[$i];
            }
            $mods = $sums % 11;//10X98765432
            switch ($mods){
                case 0: return '1';break;
                case 1: return '0';break;
                case 2: return 'x';break;
                case 3: return '9';break;
                case 4: return '8';break;
                case 5: return '7';break;
                case 6: return '6';break;
                case 7: return '5';break;
                case 8: return '4';break;
                case 9: return '3';break;
                case 10: return '2';break;
            }
        }
        $seed  = mt_rand(0,3130); // 区域代码总数
        $birth = mt_rand($year_start,$year_end);
        $birth_format = date('Ymd',$birth);
        $suffix_a = mt_rand(0,9);
        $suffix_b = mt_rand(0,9);
        $suffix_c = mt_rand(0,9);//男女不限
        $base = $Region[$seed].$birth_format.$suffix_a.$suffix_b.$suffix_c;
        $identity_card .= $base.calc_suffix_d($base);
        return $identity_card;
    }
}