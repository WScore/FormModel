<?php
namespace WScore\FormModel;

use WScore\FormModel\Element\ChoiceType;
use WScore\FormModel\Element\ElementType;
use WScore\FormModel\Element\FormType;
use WScore\FormModel\Element\InputType;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Interfaces\FormElementInterface;
use WScore\Validation\ValidatorBuilder;

class FormBuilder
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
        $form = new FormType($this->builder, $name);
        return $form;
    }

    public function element($type, $name): ElementInterface
    {
        return new InputType($this->builder, $type, $name);
    }

    public function text($name): ElementInterface
    {
        return $this->element(ElementType::TYPE_TEXT, $name);
    }

    public function choices($name): ChoiceType
    {
        return new ChoiceType($this->builder, $name);
    }
}