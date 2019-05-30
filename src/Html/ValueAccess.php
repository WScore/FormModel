<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use ArrayAccess;

class ValueAccess
{
    /**
     * @param mixed $value
     * @param string|int $name
     * @return array|object|string|null
     */
    public static function get($value, $name)
    {
        if (is_null($value)) {
            return $value;
        }
        if (is_array($value) || $value instanceof ArrayAccess) {
            return $value[$name] ?? null;
        }
        if (is_object($value)) {
            $name = (string) $name;
            $method = 'get' . ucwords($name);
            if (method_exists($value, $method)) {
                return $value->$method();
            }
            $method = $name;
            if (method_exists($value, $method)) {
                return $value->$method();
            }
            if (property_exists ($value, $name)) {
                return $value->$name;
            }
        }
        return $value;
    }

}