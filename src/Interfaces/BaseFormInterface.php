<?php
namespace WScore\FormModel\Interfaces;

interface BaseFormInterface
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return bool
     */
    public function isFormType(): bool;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @param callable|FilterInterface $filter
     * @return $this
     */
    public function setInputFilter(callable $filter): self;

    /**
     * @param callable $validator
     * @return $this
     */
    public function setValidator(callable $validator): self;

    /**
     * @param array|string $input
     * @return ValidateResultInterface
     */
    public function validate($input): ValidateResultInterface;

}