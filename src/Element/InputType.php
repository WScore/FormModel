<?php
declare(strict_types=1);

namespace WScore\FormModel\Element;

use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\Html\HtmlInput;
use WScore\Validation\Filters\Required;
use WScore\Validation\Interfaces\ValidationInterface;

final class InputType extends AbstractElement
{
    private $type2validation = [
        ElementType::URL => 'URL',
        ElementType::HIDDEN => 'text',
        ElementType::TEL => 'digits',
    ];

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
        $html = new HtmlInput($this);
        $html->setInputs($inputs);
        return $html;
    }

    /**
     * @return ValidationInterface
     */
    public function createValidation(): ValidationInterface
    {
        $type = $this->getType();
        $type = $this->type2validation[$type] ?? $type;
        $filters = $this->prepareFilters($type);
        if ($this->isRequired()) {
            $filters[Required::class] = [];
        }
        $validation = $this->validationBuilder->chain($filters);
        return $validation;
    }
}