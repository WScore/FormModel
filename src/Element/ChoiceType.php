<?php
declare(strict_types=1);

namespace WScore\FormModel\Element;

use WScore\FormModel\Html\HtmlChoices;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\Validation\ValidatorBuilder;

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

    public function __construct(ValidatorBuilder $builder, $name, $label = '')
    {
        $type = ElementType::CHOICE_TYPE;
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
}