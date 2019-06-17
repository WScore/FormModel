<?php
declare(strict_types=1);

namespace WScore\FormModel\Element;

use WScore\FormModel\Html\HtmlFormInterface;
use WScore\Validation\Interfaces\ValidationInterface;

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
    public function setRequired(bool $required = true): ElementInterface;

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
     * @param string $name
     * @return ElementInterface
     */
    public function setName(string $name): ElementInterface;

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @param string $label
     * @return ElementInterface
     */
    public function setLabel(string $label): ElementInterface;

    /**
     * @return ValidationInterface
     */
    public function createValidation(): ValidationInterface;

    /**
     * @param null|array|string $inputs
     * @return HtmlFormInterface
     */
    public function createHtml($inputs = null): HtmlFormInterface;

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

    /**
     * @param ElementInterface $element
     * @return $this
     */
    public function add(ElementInterface $element): ElementInterface;
    
    /**
     * @param ElementInterface $element
     * @param int $repeat
     * @return $this
     */
    public function addRepeatedForm(int $repeat, ElementInterface $element): ElementInterface;

    /**
     * @param string $name
     * @return ElementInterface
     */
    public function get(string $name): ?ElementInterface;

    /**
     * @return bool
     */
    public function hasChildren(): bool;

    /**
     * @return ElementInterface[]
     */
    public function getChildren(): array;

    /**
     * @return int
     */
    public function getRepeats(): int;

    /**
     * @param int $num
     */
    public function setRepeats(int $num);
}