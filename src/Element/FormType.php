<?php
declare(strict_types=1);

namespace WScore\FormModel\Element;

use BadMethodCallException;
use WScore\FormModel\Html\HtmlForm;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\Html\HtmlRepeatedForm;
use WScore\Validator\Interfaces\ValidationInterface;
use WScore\Validator\ValidatorBuilder;
use WScore\Validator\Validators\ValidationList;

final class FormType extends AbstractElement
{
    /**
     * FormType constructor.
     * @param ValidatorBuilder $builder
     * @param string $name
     * @param string $label
     */
    public function __construct(ValidatorBuilder $builder, string $name, string $label = '')
    {
        parent::__construct($builder, 'form-type', $name, $label);
    }

    /**
     * @return bool
     */
    public function isFormType(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        throw new BadMethodCallException();
    }

    /**
     * @param bool $required
     * @return $this
     */
    public function setRequired(bool $required = true): ElementInterface
    {
        throw new BadMethodCallException();
    }

    /**
     * @param null|array|string $inputs
     * @return HtmlFormInterface
     */
    public function createHtml($inputs = null): HtmlFormInterface
    {
        $html = $this->isRepeatedForm()
            ? new HtmlRepeatedForm($this)
            : new HtmlForm($this);
        $inputs = $inputs[$this->name] ?? null;
        $html->setInputs($inputs);
        return $html;
    }

    /**
     * @return ValidationInterface
     */
    public function createValidation(): ValidationInterface
    {
        if ($this->isRepeatedForm()) {
            $repeated = $this->get($this->getName());
            return $this->createValidationForm($repeated);
        }
        return $this->createValidationForm($this);
    }

    /**
     * @param ElementInterface|FormType $formType
     * @return ValidationInterface|ValidationList
     */
    private function createValidationForm($formType)
    {
        $filters = $formType->getFilters();
        $validation = $this->validationBuilder->form($filters);
        foreach ($formType->getChildren() as $child) {
            if ($child->isRepeatedForm()) {
                $validation->addRepeatedForm($child->getName(), $child->createValidation(), $child->getFilters());
            } else {
                $validation->add($child->getName(), $child->createValidation());
            }
        }
        return $validation;
    }
}