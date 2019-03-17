<?php
namespace WScore\FormModel\Interfaces;

use WScore\FormModel\Form\HtmlFormInterface;
use WScore\FormModel\Validation\FilterInterface;
use WScore\FormModel\Validation\ValidationResultInterface;
use WScore\FormModel\Validation\ValidatorInterface;

interface BaseFormInterface
{
    const TYPE_FORM = 'form-type';

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return bool
     */
    public function isFormType(): bool;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @param callable|FilterInterface $filter
     * @return $this
     */
    public function setInputFilter(callable $filter);

    /**
     * @param callable|ValidatorInterface $validator
     * @return $this
     */
    public function setValidator(callable $validator);

    /**
     * @param array|string $inputs
     * @return ValidationResultInterface
     */
    public function validate($inputs): ValidationResultInterface;

    /**
     * @param array|string $inputs
     * @return HtmlFormInterface
     */
    public function viewHtml($inputs): HtmlFormInterface;
}