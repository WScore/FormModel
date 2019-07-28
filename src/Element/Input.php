<?php
declare(strict_types=1);

namespace WScore\FormModel\Element;

use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\Html\HtmlInput;
use WScore\Validation\Filters\Required;
use WScore\Validation\Interfaces\ValidationInterface;

class Input extends AbstractElement
{
    /**
     * @param null|array|string $inputs
     * @return HtmlFormInterface
     */
    public function createHtml($inputs = null): HtmlFormInterface
    {
        $html = new HtmlInput($this);
        $html->setInputs($inputs);
        return $html;
    }

    /**
     * @return ValidationInterface
     */
    public function createValidation(): ValidationInterface
    {
        return $this->createValidationByType($this->getType());
    }
}