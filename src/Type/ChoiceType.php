<?php
declare(strict_types=1);

namespace WScore\FormModel\Type;

use WScore\FormModel\Element\Input;
use WScore\FormModel\FormBuilder;
use WScore\Validation\ValidatorBuilder;

class ChoiceType extends \WScore\FormModel\Element\Choice implements TypeInterface
{
    public function __construct(FormBuilder $builder, string $name, string $label = '')
    {
        parent::__construct($builder, $name, $label);
    }

    public static function forge(FormBuilder $builder, string $name, array $options): TypeInterface
    {
        $type = new self($builder, $name);
        $builder->apply($type, $options);
        $type->setToString($builder->getToString());

        return $type;
    }
}