<?php
namespace WScore\FormModel\Validation;

interface ValidationResultInterface extends \IteratorAggregate
{
    /**
     * @return string|string[]|mixed
     */
    public function value();

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
     * @return string|string[]|mixed
     */
    public function getErrorMessage();

    /**
     * @param string $name
     * @return bool
     */
    public function hasChild(string $name): bool;

    /**
     * @param string $name
     * @return ValidationResultInterface
     */
    public function getChild(string $name): ?ValidationResultInterface;

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