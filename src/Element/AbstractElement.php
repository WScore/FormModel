<?php
namespace WScore\FormModel\Element;

use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Validation\ValidationChain;
use WScore\FormModel\Validation\ValidationInterface;

abstract class AbstractElement extends AbstractBase implements ElementInterface
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
     * @var ValidationInterface
     */
    private $validation;

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

    public function getValidation()
    {
        return $this->validation ?: $this->validation = new ValidationChain();
    }
}