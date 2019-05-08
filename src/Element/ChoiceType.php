<?php
namespace WScore\FormModel\Element;

use WScore\Validation\ValidatorBuilder;

class ChoiceType extends InputType
{
    private $expand = false;

    private $choices = [];

    private $replace = false;

    public function __construct(ValidatorBuilder $builder, $name, $label)
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
}