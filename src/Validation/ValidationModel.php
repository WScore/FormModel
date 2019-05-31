<?php
declare(strict_types=1);

namespace WScore\FormModel\Validation;

use BadMethodCallException;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\Interfaces\FormElementInterface;
use WScore\Validation\Interfaces\ResultInterface;

class ValidationModel
{
    /**
     * @var FormElementInterface
     */
    private $form;

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
     * @param FormElementInterface $form
     */
    public function __construct(FormElementInterface $form)
    {
        $this->form = $form;
    }

    /**
     * @param array $inputs
     * @return $this
     */
    public function verify(array $inputs): self
    {
        $this->inputs = $this->cleanUp($inputs);
        $validation = $this->form->createValidation();
        $inputs = $this->inputs[$this->form->getName()] ?? [];
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
     * @return HtmlFormInterface|HtmlFormInterface
     */
    public function createHtml(): HtmlFormInterface
    {
        return $this->form->createHtml($this->inputs, $this->results);
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