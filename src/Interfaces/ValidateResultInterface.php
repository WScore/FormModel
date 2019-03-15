<?php
namespace WScore\FormModel\Interfaces;

interface ValidateResultInterface extends \IteratorAggregate
{
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
     * @return ValidateResultInterface
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
     * @return \self[]
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