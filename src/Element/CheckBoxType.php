<?php
declare(strict_types=1);

namespace WScore\FormModel\Element;

use WScore\FormModel\Html\HtmlCheckBox;
use WScore\FormModel\Html\HtmlFormInterface;

final class CheckBoxType extends AbstractElement
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
     * @return CheckBoxType
     */
    public function setValue($value): CheckBoxType
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return bool|string
     */
    public function isValue()
    {
        return $this->value;
    }

    /**
     * @param string|null $default
     * @return CheckBoxType
     */
    public function setDefault(?string $default): CheckBoxType
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
        $html = new HtmlCheckBox($this);
        $html->setInputs($inputs);
        return $html;
    }
}