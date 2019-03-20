<?php
namespace WScore\FormModel\Validation;

use WScore\FormModel\Interfaces\BaseElementInterface;
use WScore\FormModel\Interfaces\FormElementInterface;

class Result
{
    /**
     * @param BaseElementInterface $element
     * @param mixed $value
     * @return ValidationResultInterface
     */
    public static function success(BaseElementInterface $element, $value): ValidationResultInterface
    {
        return ElementResult::success($element, $value);
    }

    /**
     * @param BaseElementInterface $element
     * @param mixed $value
     * @param string $message
     * @return ValidationResultInterface
     */
    public static function fail(?BaseElementInterface $element, $value, $message): ValidationResultInterface
    {
        return ElementResult::fail($element, $value, $message);
    }

    /**
     * @param FormElementInterface $form
     * @param Result[] $results
     * @return ValidationResultInterface
     */
    public static function aggregate(FormElementInterface $form, array $results): ValidationResultInterface
    {
        return FormResult::aggregate($form, $results);
    }
}