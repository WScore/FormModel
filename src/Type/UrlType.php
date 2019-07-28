<?php
declare(strict_types=1);

namespace WScore\FormModel\Type;

use WScore\FormModel\Element\Input;
use WScore\FormModel\FormBuilder;
use WScore\Validation\Interfaces\ValidationInterface;
use WScore\Validation\ValidatorBuilder;

class UrlType extends Input implements TypeInterface
{
    public function __construct(ValidatorBuilder $builder, string $name, string $label = '')
    {
        parent::__construct($builder, 'url', $name, $label);
    }

    public static function forge(FormBuilder $builder, string $name, array $options): TypeInterface
    {
        $type = new self($builder->getValidationBuilder(), $name);
        $builder->apply($type, $options);
        $type->setToString($builder->getToString());

        return $type;
    }

    /**
     * @return ValidationInterface
     */
    public function createValidation(): ValidationInterface
    {
        return $this->createValidationByType('URL');
    }
}