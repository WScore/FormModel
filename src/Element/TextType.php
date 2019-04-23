<?php
namespace WScore\FormModel\Element;

use WScore\FormModel\Form\HtmlFormInterface;
use WScore\FormModel\Interfaces\BaseElementInterface;
use WScore\FormModel\Interfaces\ElementInterface;

class TextType extends AbstractElement
{
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
    public function createHtml($inputs): HtmlFormInterface
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

    /**
     * @return bool
     */
    public function isRepeatedForm(): bool
    {
        // TODO: Implement isRepeatedForm() method.
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        // TODO: Implement getFilters() method.
    }

    /**
     * @param array $filters
     * @return ElementInterface
     */
    public function setFilters(array $filters): ElementInterface
    {
        // TODO: Implement setFilters() method.
    }
}