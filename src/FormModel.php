<?php
namespace WScore\FormModel;

use WScore\FormModel\Element\ElementType;
use WScore\FormModel\Element\InputType;
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
        // todo: implement this method.
    }

    public function element($type, $name): ElementInterface
    {
        return new InputType($this->builder, $type, $name);
    }

    public function text($name): ElementInterface
    {
        return $this->element(ElementType::TYPE_TEXT, $name);
    }
}