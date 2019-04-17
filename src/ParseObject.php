<?php
namespace qpf\helper;

/**
 * �����������
 */
class ParseObject
{
    /**
     * ��ȡ��ķ��� - �������̳�
     * @param string|object $class ���������ʵ��
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
     * ��ȡ���Ĭ��Public����
     * @param string|object $class ���������ʵ��
     * @return array
     */
    public static function getPublicProperty($class)
    {
        $class = is_object($class) ? get_class($class) : $class;
        
        return get_class_vars($class);
    }
}