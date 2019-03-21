<?php
namespace WScore\FormModel\Element;

use WScore\FormModel\Form\HtmlFormInterface;
use WScore\FormModel\Interfaces\BaseElementInterface;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Validation\ResultInterface;

class ChoiceType extends AbstractElement
{
    /**
     * @param string $name
     * @param string $label
     */
    public function __construct($name, $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    /**
     * @param string $name
     * @param string $label
     * @param array $choices
     * @return ChoiceType
     */
    public static function create($name, $label, $choices)
    {
        $self = new self($name, $label);
        $self->setChoices($choices);
        return $self;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return BaseElementInterface::TYPE_TEXT;
    }

    /**
     * @return bool
     */
    public function isFormType(): bool
    {
        return false;
    }

    /**
     * @param array|string $inputs
     * @return ResultInterface
     */
    public function validate($inputs): ResultInterface
    {
        // TODO: Implement validate() method.
    }

    /**
     * @param array|string $inputs
     * @return HtmlFormInterface
     */
    public function viewHtml($inputs): HtmlFormInterface
    {
        // TODO: Implement viewHtml() method.
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        // TODO: Implement getValue() method.
    }

    /**
     * @return array
     */
    public function getChoices(): array
    {
        // TODO: Implement getChoices() method.
    }

    /**
     * @return bool
     */
    public function hasChoices(): bool
    {
        // TODO: Implement hasChoices() method.
    }

    /**
     * @param array $validation
     * @return $this
     */
    public function setValidations(array $validation): ElementInterface
    {
        // TODO: Implement setValidations() method.
    }

    /**
     * @return array
     */
    public function getValidations(): array
    {
        // TODO: Implement getValidations() method.
    }

    /**
     * @param array $choices
     * @return $this
     */
    public function setChoices(array $choices): ElementInterface
    {
        // TODO: Implement setChoices() method.
    }
}