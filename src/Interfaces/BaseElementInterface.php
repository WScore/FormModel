<?php
namespace WScore\FormModel\Interfaces;

use WScore\FormModel\Form\HtmlFormInterface;
use WScore\Validation\Interfaces\ValidationInterface;

interface BaseElementInterface
{
    const TYPE_FORM = 'form-type';
    const TYPE_REPEATED = 'form-repeated';

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return bool
     */
    public function isFormType(): bool;

    /**
     * @return bool
     */
    public function isRepeatedForm(): bool;

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
     * @param string $fullName
     * @return $this
     */
    public function setFullName(string $fullName): BaseElementInterface;

    /**
     * @return ValidationInterface
     */
    public function createValidation(): ValidationInterface;

    /**
     * @param array|string $inputs
     * @return HtmlFormInterface
     */
    public function createHtml($inputs): HtmlFormInterface;
}