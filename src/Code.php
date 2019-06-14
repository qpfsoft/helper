<?php
namespace qpf\helper;

use Opis\Closure\SerializableClosure;

/**
 * PHP 代码相关
 */
class Code
{
    /**
     * 序列化PHP代码为字符串
     * @param mixed $data
     * @return string
     */
    public static function serialize($data): string
    {
        SerializableClosure::enterContext();
        SerializableClosure::wrapClosures($data);
        $data = \serialize($data);
        SerializableClosure::exitContext();
        return $data;
    }
    
    /**
     * 反序列化字符串为PHP代码
     * @param string $data
     * @return mixed
     */
    public static function unserialize(string $data)
    {
        SerializableClosure::enterContext();
        $data = \unserialize($data);
        SerializableClosure::unwrapClosures($data);
        SerializableClosure::exitContext();
        return $data;
    }
}