<?php
declare(strict_types=1);

namespace WScore\FormModel\Type;

use WScore\FormModel\Element\ElementInterface;
use WScore\FormModel\FormBuilder;

interface TypeInterface extends ElementInterface
{
    public static function forge(FormBuilder $builder, string $name, array $options): TypeInterface;
}