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
     * @param string $pattern
     * @return $this
     */
    public function setPattern($pattern): self;

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
}