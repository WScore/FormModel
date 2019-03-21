<?php
namespace WScore\FormModel\Interfaces;

use WScore\FormModel\Form\HtmlFormInterface;
use WScore\FormModel\Validation\FilterInterface;
use WScore\FormModel\Validation\ResultInterface;
use WScore\FormModel\Validation\ValidationInterface;
use WScore\FormModel\Validation\ValidatorInterface;

interface BaseElementInterface
{
    const TYPE_FORM = 'form-type';
    const TYPE_TEXT = 'text-element';
    const TYPE_CHOICE = 'choice-element';

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
    public function getFullName(): string;

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @return array
     */
    public function getAttributes(): array;

    /**
     * @param string $fullName
     * @return $this
     */
    public function setFullName(string $fullName): BaseElementInterface;

    /**
     * @param array $attributes
     * @return ElementInterface
     */
    public function setAttributes(array $attributes): BaseElementInterface;

    /**
     * @return ValidationInterface
     */
    public function getValidation();

    /**
     * @param array|string $inputs
     * @return HtmlFormInterface
     */
    public function viewHtml($inputs): HtmlFormInterface;
}