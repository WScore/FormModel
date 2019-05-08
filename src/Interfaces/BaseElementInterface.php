<?php
namespace WScore\FormModel\Interfaces;

use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\Validation\Validator;

interface BaseElementInterface
{
    const TYPE_FORM = 'form-type';
    const TYPE_REPEATED = 'form-repeated';
    const TYPE_CHOICE = 'type-choice';
    const TYPE_TEXT = 'type-text';

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
     * @return Validator
     */
    public function createValidation(): Validator;

    /**
     * @param array|string $inputs
     * @return HtmlFormInterface
     */
    public function createHtml($inputs): HtmlFormInterface;

    /**
     * @return array
     */
    public function getAttributes(): array;

    /**
     * @param array $attributes
     * @return ElementInterface
     */
    public function setAttributes(array $attributes): BaseElementInterface;

    /**
     * @return array
     */
    public function getFilters(): array;

    /**
     * @param array $filters
     * @return $this
     */
    public function setFilters(array $filters): BaseElementInterface;
}