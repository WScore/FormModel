<?php
declare(strict_types=1);

namespace WScore\FormModel\Element;

use WScore\FormModel\Html\HtmlButtons;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\Validation\Filters\Required;
use WScore\Validation\Interfaces\ValidationInterface;

final class ButtonType extends AbstractElement
{
    /**
     * @var bool
     */
    private $isRequired = true;

    /**
     * @var bool|string
     */
    private $value = true;

    /**
     * @var null|string
     */
    private $default = null;

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

    /**
     * @param bool|string $value
     * @return ButtonType
     */
    public function setValue($value): ButtonType
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
     * @return ButtonType
     */
    public function setDefault(?string $default): ButtonType
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
        $filters = $this->getFilters();
        $filters['type'] = 'text';
        if ($this->isRequired()) {
            $filters[Required::class] = [];
        }
        $validation = $this->validationBuilder->chain($filters);
        return $validation;
    }
}