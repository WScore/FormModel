<?php
namespace WScore\FormModel;

use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Interfaces\FormElementInterface;

class FormBuilder
{
    public static function create(string $locale = 'en'): self
    {
    }

    public function form($name): FormElementInterface
    {

    }

    public function element($type, $name): ElementInterface
    {

    }

    public function text($name): ElementInterface
    {

    }
}