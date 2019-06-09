<?php
declare(strict_types=1);

namespace WScore\FormModel\Element;

use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\Html\HtmlTextArea;

final class TextAreaType extends AbstractElement
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

    /**
     * @param null|array|string $inputs
     * @return HtmlFormInterface
     */
    public function createHtml($inputs = null): HtmlFormInterface
    {
        $html = new HtmlTextArea($this);
        $html->setInputs($inputs);
        return $html;
    }
}