<?php
namespace qpf\helper;

/**
 * 对象解析助手
 */
class ParseObject
{
    /**
     * 获取类的方法 - 不包含继承
     * @param string|object $class 类名或对象实例
     * @return array
     */
    public static function getMethods($class)
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
     * 获取类的默认Public属性
     * @param string|object $class 类名或对象实例
     * @return array
     */
    public static function getPublicProperty($class)
    {
        $class = is_object($class) ? get_class($class) : $class;
        
        return get_class_vars($class);
    }
}