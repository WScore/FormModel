<?php
namespace WScore\FormModel\Interfaces;

interface ElementInterface extends BaseElementInterface
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
}