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
 * 对象解析助手
 */
class ParseObject
{
    /**
     * 获取类的公共方法  - 不含继承方法
     * @param string|object $class 类名或对象实例
     * @return array
     */
    public static function getPublicMethods($class)
    {
        $methods = get_class_methods($class);
        
        if ($methods === null) {
            return [];
        }
        
        $parent_class = get_parent_class($class);
        
        if ($parent_class) {
            return array_diff($methods, get_class_methods($parent_class));
        }
        
        return $methods;
    }
    
    /**
     * 获取类的公共属性
     * 
     * 包含父类的public属性, 属性值为类文件内填写的值.
     * @param string|object $class 类名或对象实例
     * @return array
     */
    public static function getPublicProperty($class)
    {
        $class = is_object($class) ? get_class($class) : $class;
        
        return get_class_vars($class);
    }
}