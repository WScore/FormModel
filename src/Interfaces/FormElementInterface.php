<?php
namespace WScore\FormModel\Interfaces;

interface FormElementInterface
{
    /**
     * @return $this
     */
    public function setRequired();

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel($label);

    /**
     * @param string $pattern
     * @return $this
     */
    public function setPattern($pattern);

    /**
     * @param string $value
     * @param string $label
     * @return $this
     */
    public function addOption($value, $label = null);

    /**
     * @param string|string[] $value
     * @return ValidateResultInterface
     */
    public function validate($value);
}