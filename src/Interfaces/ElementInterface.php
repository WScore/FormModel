<?php
namespace WScore\FormModel\Interfaces;

use WScore\FormModel\Validation\ResultInterface;

interface ElementInterface extends BaseElementInterface
{
    /**
     * @return string
     */
    public function getValue(): string;

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
     * @param array $validation
     * @return $this
     */
    public function setValidations(array $validation): ElementInterface;

    /**
     * @return array
     */
    public function getValidations(): array;

    /**
     * @return bool
     */
    public function isMultiple(): bool;

    /**
     * @param bool $multiple
     * @return $this
     */
    public function setMultiple($multiple = true): ElementInterface;
}