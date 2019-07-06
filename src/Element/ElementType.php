<?php
declare(strict_types=1);

namespace WScore\FormModel\Element;

class ElementType
{
    const FORM_TYPE = 'form-type';
    const REPEATED_FORM = 'form-repeated';
    const CHOICE_TYPE = 'type-choice';
    const TEXT = 'text';
    const DATE = 'date';
    const DATETIME = 'datetime';
    const TEXTAREA = 'textarea';
    const CHECKBOX = 'checkbox';
    const RADIO = 'radio';
    const EMAIL = 'email';
    const URL = 'url';
    const MONTH = 'month';
    const HIDDEN = 'hidden';
    const TEL = 'tel';
    const PASSWORD = 'password';

    static private $type2validation = [
        self::URL => 'URL',
        self::HIDDEN => 'text',
        self::TEL => 'digits',
        self::PASSWORD => 'text',
    ];

    static private $type2html = [
        self::DATETIME => 'datetime-local',
    ];

    public static function toValidationType($type): string
    {
        return self::$type2validation[$type] ?? $type;
    }

    public static function toHtmlType($type): string
    {
        return self::$type2html[$type] ?? $type;
    }
}