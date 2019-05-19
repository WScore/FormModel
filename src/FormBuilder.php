<?php
declare(strict_types=1);

namespace WScore\FormModel;

use WScore\FormModel\Element\ChoiceType;
use WScore\FormModel\Element\FormType;
use WScore\FormModel\Element\InputType;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Interfaces\FormElementInterface;
use WScore\Validation\ValidatorBuilder;

/**
 * builds various elements for form models.
 *
 * @method ElementInterface text(string $name)
 */
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

    /**
     * @param string $name
     * @param array $arguments
     * @return ElementInterface
     */
    public function __call(string $name, array $arguments)
    {
        $type = $name;
        $name = $arguments[0] ?? '';
        return $this->element($type, $name);
    }

    public function form(string $name): FormElementInterface
    {
        $form = new FormType($this->builder, $name);
        return $form;
    }

    public function element(string $type, string $name): ElementInterface
    {
        return new InputType($this->builder, $type, $name);
    }

    public function choices(string $name): ChoiceType
    {
        return new ChoiceType($this->builder, $name);
    }
}