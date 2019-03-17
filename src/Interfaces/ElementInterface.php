<?php
namespace WScore\FormModel\Interfaces;

interface ElementInterface extends BaseFormInterface
{
    /**
     * @return string
     */
    public function getValue(): string;

    /**
     * @return array
     */
    public function getChoices(): array;

    /**
     * @return bool
     */
    public function isRequired(): bool;

    /**
     * @return bool
     */
    public function isMultiple(): bool;

    /**
     * @return bool
     */
    public function hasChoices(): bool;

    /**
     * @return $this
     */
    public function setRequired(): self;

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel($label): self;

    /**
     * @param array $validation
     * @return $this
     */
    public function setValidations(array $validation): self;

    /**
     * @return array
     */
    public function getValidations(): array;

    /**
     * @param array $choices
     * @return $this
     */
    public function setChoices(array $choices): self;

    /**
     * @param bool $multiple
     * @return $this
     */
    public function setMultiple($multiple = true): self;

    /**
     * @param array $attributes
     * @return ElementInterface
     */
    public function setAttributes(array $attributes): self;

    /**
     * @return array
     */
    public function getAttributes(): array;
}