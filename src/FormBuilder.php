<?php
declare(strict_types=1);

namespace WScore\FormModel;

use InvalidArgumentException;
use RuntimeException;
use WScore\FormModel\Element\Button;
use WScore\FormModel\Element\Choice;
use WScore\FormModel\Element\ElementInterface;
use WScore\FormModel\Element\FormType;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\ToString\Bootstrap4;
use WScore\FormModel\ToString\ToStringFactoryInterface;
use WScore\FormModel\ToString\ViewModel;
use WScore\FormModel\Type\CheckboxType;
use WScore\FormModel\Type\ChoiceType;
use WScore\FormModel\Type\RadioType;
use WScore\Validator\Interfaces\ResultInterface;
use WScore\Validator\ValidatorBuilder;

/**
 * builds various elements for form models.
 *
 * @method ElementInterface text(string $name, string $label = '')
 * @method ElementInterface date(string $name, string $label = '')
 * @method ElementInterface datetime(string $name, string $label = '')
 * @method ElementInterface email(string $name, string $label = '')
 * @method ElementInterface hidden(string $name, string $label = '')
 * @method ElementInterface month(string $name, string $label = '')
 * @method ElementInterface password(string $name, string $label = '')
 * @method ElementInterface tel(string $name, string $label = '')
 * @method ElementInterface textarea(string $name, string $label = '')
 * @method ElementInterface url(string $name, string $label = '')
 */
class FormBuilder
{
    /**
     * @var ValidatorBuilder
     */
    private $builder;

    /**
     * @var ToStringFactoryInterface
     */
    private $toString;

    /**
     * @param ValidatorBuilder $builder
     */
    public function __construct(ValidatorBuilder $builder)
    {
        $this->builder = $builder;
    }

    public static function create(string $locale = 'en', ToStringFactoryInterface $toString = null): self
    {
        $toString = $toString ?? new Bootstrap4();
        $self = new self(new ValidatorBuilder($locale));
        if ($toString) {
            $self->setToString($toString);
        }

        return $self;
    }

    /**
     * @param ToStringFactoryInterface $toString
     */
    public function setToString(ToStringFactoryInterface $toString): void
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
        return $this->element($type, $name, ['label' => $label]);
    }

    public function formModel(string $name, array $options = []): FormModel
    {
        return new FormModel($this, $name, $options);
    }

    public function viewModel(HtmlFormInterface $html, ResultInterface $result = null): ViewModel
    {
        return new ViewModel($this->toString, $html, $result);
    }

    public function form(string $name, string $label = ''): ElementInterface
    {
        $form = new FormType($this->builder, $name, $label);
        if ($this->toString) {
            $form->setToString($this->toString);
        }
        return $form;
    }

    public function element(string $type, string $name, array $options = [])
    {
        if (!isset($options['label'])) {
            $options['label'] = $name;
        }
        if (!class_exists($type)) {
            $type = '\WScore\FormModel\Type\\' . ucwords($type) . 'Type';
        }
        if (class_exists($type) && method_exists($type, 'forge')) {
            $element = $type::forge($this, $name, $options);
            return $element;
        }
        throw new RuntimeException('class not found for: ' . $type);
    }

    public function choices(string $name, string $label = ''): Choice
    {
        $form = ChoiceType::forge($this, $name, ['label' => $label]);
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

    public function checkBox(string $name): Button
    {
        $form = CheckboxType::forge($this, $name, []);
        if ($this->toString) {
            $form->setToString($this->toString);
        }
        return $form;
    }

    public function radio(string $name): Button
    {
        $form = RadioType::forge($this, $name, []);
        if ($this->toString) {
            $form->setToString($this->toString);
        }
        return $form;
    }

    public function getValidationBuilder(): ValidatorBuilder
    {
        return $this->builder;
    }

    public function getToString(): ToStringFactoryInterface
    {
        return $this->toString;
    }
}