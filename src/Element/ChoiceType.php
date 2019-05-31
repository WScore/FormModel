<?php
declare(strict_types=1);

namespace WScore\FormModel\Element;

use WScore\Validation\ValidatorBuilder;

class ChoiceType extends InputType
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

    public function __construct(ValidatorBuilder $builder, $name, $label = '')
    {
        $type = ElementType::TYPE_CHOICE;
        parent::__construct($builder, $type, $name, $label);
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
}