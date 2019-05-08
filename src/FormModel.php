<?php
namespace WScore\FormModel;

use WScore\FormModel\Element\ElementType;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Interfaces\FormElementInterface;
use WScore\Validation\ValidatorBuilder;

class FormModel
{
    /**
     * @var ValidatorBuilder
     */
    private $builder;

    /**
     * @param ValidatorBuilder $builder
     */
    public function __construct(ValidatorBuilder $builder)
    {
        $this->builder = $builder;
    }

    public static function create(string $locale = 'en'): self
    {
        $self = new self(new ValidatorBuilder($locale));
        return $self;
    }

    public function form($name): FormElementInterface
    {

    }

    public function element($type, $name): ElementInterface
    {
        return new ElementType($this->builder, $type, $name);
    }

    public function text($name): ElementInterface
    {

    }
}