<?php
declare(strict_types=1);

namespace WScore\FormModel\Element;

class InputType extends AbstractElement implements ElementInterface
{
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
}