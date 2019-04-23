<?php
namespace WScore\FormModel\Element;

use WScore\FormModel\Form\HtmlFormInterface;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\Validation\Interfaces\ValidationInterface;

class ElementType extends AbstractBase implements ElementInterface
{
    /**
     * @var bool
     */
    private $isRequired = true;

    /**
     * @var bool
     */
    private $isMultiple = false;

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
    public function setRequired($required = true): ElementInterface
    {
        $this->isRequired = $required;
        return $this;
    }

    /**
     * @return bool
     */
    public function isMultiple(): bool
    {
        return $this->isMultiple;
    }

    /**
     * @param bool $multiple
     * @return $this
     */
    public function setMultiple($multiple = true): ElementInterface
    {
        $this->isMultiple = $multiple;
        return $this;
    }

    /**
     * @return ValidationInterface
     */
    public function createValidation(): ValidationInterface
    {
        // TODO: Implement createValidation() method.
    }

    /**
     * @param array|string $inputs
     * @return HtmlFormInterface
     */
    public function createHtml($inputs): HtmlFormInterface
    {
        // TODO: Implement createHtml() method.
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