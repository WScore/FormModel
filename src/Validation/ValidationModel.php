<?php
declare(strict_types=1);

namespace WScore\FormModel\Validation;

use BadMethodCallException;
use WScore\FormModel\FormModel;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\Interfaces\FormElementInterface;
use WScore\FormModel\ToString\ViewModel;
use WScore\Validation\Interfaces\ResultInterface;

class ValidationModel
{
    /**
     * @var FormElementInterface
     */
    private $form;

    /**
     * @var FormElementInterface
     */
    private $element;

    /**
     * @var array
     */
    private $inputs;

    /**
     * @var ResultInterface
     */
    private $results;

    /**
     * ValidationModel constructor.
     * @param FormModel $form
     */
    public function __construct(FormModel $form)
    {
        $this->form = $form;
        $this->element = $form->getElement();
    }

    /**
     * @param array $inputs
     * @return $this
     */
    public function verify(array $inputs): self
    {
        $this->inputs = $this->cleanUp($inputs);
        $validation = $this->element->createValidation();
        $inputs = $this->inputs[$this->element->getName()] ?? [];
        $this->results = $validation->verify($inputs);

        return $this;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        if (!$this->results) {
            throw new BadMethodCallException('no results from validation, yet');
        }
        return $this->results->isValid();
    }

    /**
     * @return bool
     */
    public function fails(): bool
    {
        return !$this->isValid();
    }

    /**
     * @return HtmlFormInterface
     */
    public function createHtml(): HtmlFormInterface
    {
        return $this->element->createHtml($this->inputs, $this->results);
    }

    /**
     * @return ViewModel
     */
    public function createView(): ViewModel
    {
        return $this->form->createView($this->inputs, $this->results);
    }

    private function cleanUp(array $values)
    {
        foreach ($values as $key => $value) {
            if (is_array($value)) {
                $value = $this->cleanUp($value);
            }
            if (is_null($value) || empty($value) || $value === '') {
                unset($values[$key]);
            } else {
                $values[$key] = $value;
            }
        }
        return $values;
    }
}