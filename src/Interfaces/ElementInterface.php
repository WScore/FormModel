<?php
namespace WScore\FormModel\Interfaces;

use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\Validation\Validator;

interface ElementInterface
{
    /**
     * @return bool
     */
    public function isRequired(): bool;

    /**
     * @param bool $required
     * @return $this
     */
    public function setRequired($required = true): ElementInterface;

    /**
     * @return bool
     */
    public function isMultiple(): bool;

    /**
     * @param bool $multiple
     * @return $this
     */
    public function setMultiple($multiple = true): ElementInterface;

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
    public function setFullName(string $fullName): ElementInterface;

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
    public function setAttributes(array $attributes): ElementInterface;

    /**
     * @return array
     */
    public function getFilters(): array;

    /**
     * @param array $filters
     * @return $this
     */
    public function setFilters(array $filters): ElementInterface;
}