<?php
namespace WScore\FormModel\Interfaces;

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
     * @return bool
     */
    public function isMultiple(): bool;

    /**
     * @param bool $multiple
     * @return $this
     */
    public function setMultiple($multiple = true): ElementInterface;

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
     * @return ElementInterface
     */
    public function setFilters(array $filters): ElementInterface;
}