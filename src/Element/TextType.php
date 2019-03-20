<?php
namespace WScore\FormModel\Element;

use WScore\FormModel\Form\HtmlFormInterface;
use WScore\FormModel\Interfaces\BaseElementInterface;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Validation\ValidationResultInterface;

class TextType extends AbstractElement
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
     * @return TextType
     */
    public static function create($name, $label)
    {
        return new self($name, $label);
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
     * @return ValidationResultInterface
     */
    public function validate($inputs): ValidationResultInterface
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
     * @param string $label
     * @return $this
     */
    public function setLabel($label): ElementInterface
    {
        // TODO: Implement setLabel() method.
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
}