<?php
declare(strict_types=1);

namespace WScore\FormModel\Type;

use WScore\FormModel\Element\Choice;
use WScore\FormModel\FormBuilder;

class ChoiceType extends Choice implements TypeInterface
{
    public function __construct(FormBuilder $builder, string $name, string $label = '')
    {
        parent::__construct($builder, $name, $label);
    }

    /**
     * @param FormBuilder $builder
     * @param string $name
     * @param array $options
     * @return TypeInterface|ChoiceType
     */
    public static function forge(FormBuilder $builder, string $name, array $options): TypeInterface
    {
        $type = new self($builder, $name);
        $builder->apply($type, $options);
        $type->setToString($builder->getToString());

        return $type;
    }
}