<?php
declare(strict_types=1);

namespace WScore\FormModel;

use InvalidArgumentException;
use WScore\FormModel\Element\ChoiceType;
use WScore\FormModel\Element\FormType;
use WScore\FormModel\Element\InputType;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Interfaces\FormElementInterface;
use WScore\FormModel\Interfaces\ToStringInterface;
use WScore\FormModel\ToString\Bootstrap4;
use WScore\FormModel\ToString\ViewModel;
use WScore\Validation\ValidatorBuilder;

/**
 * builds various elements for form models.
 *
 * @method ElementInterface text(string $name, string $label = '')
 */
class FormBuilder
{
    /**
     * @var ValidatorBuilder
     */
    private $builder;

    /**
     * @var ToStringInterface
     */
    private $toString;

    /**
     * @param ValidatorBuilder $builder
     */
    public function __construct(ValidatorBuilder $builder)
    {
        $this->builder = $builder;
    }

    public static function create(string $locale = 'en', ToStringInterface $toString = null): self
    {
        $toString = $toString ?? new Bootstrap4();
        $self = new self(new ValidatorBuilder($locale));
        if ($toString) {
            $self->setToString($toString);
        }

        return $self;
    }

    /**
     * @param ToStringInterface $toString
     */
    public function setToString(ToStringInterface $toString): void
    {
        $this->toString = $toString;
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
        $label = $arguments[1] ?? '';
        return $this->element($type, $name, $label);
    }

    public function formModel(string $name, array $options = []): FormModel
    {
        return new FormModel($this, $name, $options);
    }

    public function viewModel(HtmlFormInterface $html): ViewModel
    {
        return new ViewModel($this->toString, $html, $html->getElement());
    }

    public function form(string $name, string $label = ''): FormElementInterface
    {
        $form = new FormType($this->builder, $name, $label);
        if ($this->toString) {
            $form->setToString($this->toString);
}
        return $form;
    }

    public function element(string $type, string $name, string $label = ''): ElementInterface
    {
        $form = new InputType($this->builder, $type, $name, $label);
        if ($this->toString) {
            $form->setToString($this->toString);
        }
        return $form;
    }

    public function choices(string $name, string $label = ''): ChoiceType
    {
        $form = new ChoiceType($this->builder, $name, $label);
        if ($this->toString) {
            $form->setToString($this->toString);
        }
        return $form;
    }

    public function apply(ElementInterface $element, array $options): ElementInterface
    {
        foreach ($options as $key => $value) {
            $method = 'set'.ucwords($key);
            if(method_exists($element, $method)) {
                $element->$method($value);
            } elseif (method_exists($element, $key)) {
                $element->$key($value);
            } else {
                throw new InvalidArgumentException('Cannot handle key: ' . $key);
            }
        }
        return $element;
    }
}