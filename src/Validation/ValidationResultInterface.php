<?php
namespace WScore\FormModel\Validation;

interface ValidationResultInterface extends \IteratorAggregate
{
    /**
     * @return string
     */
    public function name(): string ;

    /**
     * @return string
     */
    public function label(): string ;

    /**
     * @return bool
     */
    public function isValid(): bool;

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * @param string $name
     * @return ValidationResultInterface
     */
    public function get(string $name): self;

    /**
     * @return string|string[]|mixed
     */
    public function getValue();

    /**
     * @return string|string[]|mixed
     */
    public function getErrorMessage();

    /**
     * @return self[]
     */
    public function getIterator();

    /**
     * @return bool
     */
    public function hasChildren(): bool;

    /**
     * @return self[]
     */
    public function getChildren();
}