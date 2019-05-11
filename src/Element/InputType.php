<?php
namespace WScore\FormModel\Element;

use WScore\FormModel\Interfaces\ElementInterface;

class InputType extends AbstractElement implements ElementInterface
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
}