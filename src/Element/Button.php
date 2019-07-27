<?php
declare(strict_types=1);

namespace WScore\FormModel\Element;

use WScore\FormModel\Html\HtmlButtons;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\Validation\Filters\Required;
use WScore\Validation\Interfaces\ValidationInterface;

class Button extends AbstractElement
{
    /**
     * @var bool|string
     */
    private $value = true;

    /**
     * @var null|string
     */
    private $default = null;

    /**
     * @param bool|string $value
     * @return Button
     */
    public function setValue($value): Button
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string|null $default
     * @return Button
     */
    public function setDefault(?string $default): Button
    {
        $this->default = $default;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDefault(): ?string
    {
        return $this->default;
    }

    /**
     * @param null|array|string $inputs
     * @return HtmlFormInterface
     */
    public function createHtml($inputs = null): HtmlFormInterface
    {
        $html = new HtmlButtons($this);
        $html->setInputs($inputs);
        return $html;
    }

    /**
     * @return ValidationInterface
     */
    public function createValidation(): ValidationInterface
    {
        $filters = $this->prepareFilters('text');
        if ($this->isRequired()) {
            $filters[Required::class] = [];
        }
        $validation = $this->validationBuilder->chain($filters);
        return $validation;
    }
}