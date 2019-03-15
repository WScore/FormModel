<?php
namespace WScore\FormModel\Form;

use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Interfaces\HtmlFormInterface;

class FormBuilder
{
    /**
     * @param ElementInterface $element
     * @param string $prefix
     * @return HtmlFormInterface
     */
    public static function create(ElementInterface $element, $prefix = ''): HtmlFormInterface
    {
    }

}