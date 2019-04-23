<?php
namespace WScore\FormModel\Validation;

use WScore\FormModel\Interfaces\BaseElementInterface;
use WScore\Validation\Interfaces\ResultInterface;
use WScore\Validation\Interfaces\ValidationInterface;

class Validator
{
    public static function create(BaseElementInterface $element): Validator
    {

    }

    public function verify($inputs): ResultInterface
    {

    }

    public function getValidation(): ValidationInterface
    {

    }
}