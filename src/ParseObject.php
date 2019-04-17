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
    
    /**
     * 获取对象实例的属性
     * @param object $instance 对象实例
     * @return array 格式分组:
     * 0 - 元素格式
     * 1 - 带属性保护前缀
     * 2 - 无前缀格式
     */
    public static function getobjectVars($instance)
    {
        $clone = (array) $instance;
        if (empty($clone)) {
            return [];
        }
        
        $arr = [];
        $arr['0'] = $clone;
        $parse_type = function (array $param) {
            $name = ['public_','protected_','private_'];
            if (isset($param[2])) {
                $type = $param[1] == '*' ? '1' : '2';
            } else {
                $type = '0';
            }
            return $name[$type];
        };
        
        foreach ($clone as $key => $value) {
            $aux = explode("\0", $key);
            $count = count($aux);
            $newkey = $parse_type($aux) . $aux[$count - 1];
            $arr['1'][$newkey] = &$arr['0'][$key];
            $newkey = $aux[$count - 1];
            $arr['2'][$newkey] = &$arr['0'][$key];
        }
        
        return $arr;
    }
    
    /**
     * 获取对象的数组格式
     * @param object $object 对象实例
     * @return array ['propertys' => [...], 'methods' => [...]]
     */
    public static function getObjectArray($object)
    {
        $result = [];
        
        if (is_object($object)) {
            $result['class'] = get_class($object);
            $params = self::getobjectVars($object);

            if ($params && isset($params[2])) {
                foreach ($params[2] as $name => $value) {
                    if (is_array($value)) {
                        $result['propertys'][$name] = $value;
                    } else {
                        $result['propertys'][$name] = var_export($value, true);
                    }
                }
            } else {
                $resutl['propertys'] = [];
            }
            
            $methods = self::getPublicMethods($object);
            if($methods) {
                foreach ($methods as $method) {
                    $result['methods'][] = $method . '()';
                }
            } else {
                $result['methods'] = [];
            }
        }
        
        return $result;
    }
}