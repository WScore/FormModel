<?php
declare(strict_types=1);

namespace WScore\FormModel\Element;

use WScore\FormModel\FormBuilder;
use WScore\FormModel\Html\HtmlChoices;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\Validation\Filters\InArray;
use WScore\Validation\Filters\Required;
use WScore\Validation\Interfaces\ValidationInterface;

final class ChoiceType extends AbstractElement
{
    /**
     * @var bool
     */
    private $expand = false;

    /**
     * @var array
     */
    private $choices = [];

    /**
     * @var bool
     */
    private $replace = false;

    /**
     * @var bool
     */
    private $isMultiple = false;

    /**
     * @var string
     */
    private $placeholder;

    /**
     * @var bool
     */
    private $isRequired = true;

    /**
     * @var FormBuilder
     */
    private $builder;

    /**
     * ChoiceType constructor.
     * @param FormBuilder $builder
     * @param string $name
     * @param string $label
     */
    public function __construct(FormBuilder $builder, string $name, $label = '')
    {
        $type = ElementType::CHOICE_TYPE;
        parent::__construct($builder->getValidationBuilder(), $type, $name, $label);
        $this->builder = $builder;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->isRequired;
    }

    /**
     * @param bool $required
     * @return $this
     */
    public function setRequired(bool $required = true): ElementInterface
    {
        $this->isRequired = $required;
        return $this;
    }

    /**
     * @param bool $expand
     * @return ChoiceType
     */
    public function setExpand(bool $expand): ChoiceType
    {
        $this->expand = $expand;
        return $this;
    }

    /**
     * @return bool
     */
    public function isExpand(): bool
    {
        return $this->expand;
    }

    /**
     * @param array $choices
     * @return ChoiceType
     */
    public function setChoices(array $choices): ChoiceType
    {
        $this->choices = $choices;
        return $this;
    }

    /**
     * @return array
     */
    public function getChoices(): array
    {
        return $this->choices;
    }

    /**
     * @param bool $replace
     * @return ChoiceType
     */
    public function setReplace(bool $replace): ChoiceType
    {
        $this->replace = $replace;
        return $this;
    }

    /**
     * @return bool
     */
    public function isReplace(): bool
    {
        return $this->replace;
    }

    /**
     * @return bool|array
     */
    public function isMultiple()
    {
        return $this->isMultiple;
    }

    /**
     * @param bool|array $multiple
     * @return $this
     */
    public function setMultiple($multiple = true): ChoiceType
    {
        $this->isMultiple = $multiple;
        return $this;
    }

    /**
     * @param string $holder
     * @return ChoiceType
     */
    public function setPlaceholder($holder): ChoiceType
    {
        $this->placeholder = $holder;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlaceholder(): ?string
    {
        return $this->placeholder;
    }

    /**
     * @param null|array|string $inputs
     * @return HtmlFormInterface
     */
    public function createHtml($inputs = null): HtmlFormInterface
    {
        $html = new HtmlChoices($this);
        $html->setInputs($inputs);
        return $html;
    }

    /**
     * @param string $name
     * @return ButtonType|null
     */
    public function get($name)
    {
        if (!$this->expand) {
            return null;
        }
        if (!array_key_exists($name, $this->choices)) {
            return null;
        }
        $options = [
            'value' => $name,
            'label' => $this->choices[$name],
        ];
        if ($this->isMultiple()) {
            $element = $this->builder->checkBox(ElementType::CHECKBOX, $name);
        } else {
            $element = $this->builder->radio(ElementType::RADIO, '');
            $options['required'] = $this->isRequired();
        }
        $this->builder->apply($element, $options);

        return $element;
    }

    /**
     * @return array|ButtonType[];
     */
    public function getChildren()
    {
        $children = [];
        if (!$this->expand) {
            return $children;
        }
        foreach ($this->choices as $name => $choice) {
            $children[$name] = $this->get($name);
        }

        return $children;
    }

    /**
     * @return ValidationInterface
     */
    public function createValidation(): ValidationInterface
    {
        $filters = $this->getFilters();
        $filters['type'] = 'text';
        $filters['multiple'] = $this->isMultiple();
        if ($this->isRequired()) {
            $filters[Required::class] = [];
        }
        $choices = $this->getChoices();
        $filters[InArray::class] = $this->isReplace()
            ? [InArray::REPLACE => $choices]
            : [InArray::CHOICES => array_keys($choices)];
        $validation = $this->validationBuilder->chain($filters);

        return $validation;
    }
}