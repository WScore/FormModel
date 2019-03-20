<?php
namespace WScore\FormModel\Interfaces;

use WScore\FormModel\Validation\ValidationResultInterface;

interface FormElementInterface extends BaseElementInterface, \IteratorAggregate
{
    /**
     * @param string $name
     * @param ElementInterface $element
     * @return $this
     */
    public function add(string $name, ElementInterface $element): FormElementInterface;

    /**
     * @param string $name
     * @param FormElementInterface $element
     * @return $this
     */
    public function addForm(string $name, FormElementInterface $element): FormElementInterface;

    /**
     * @param string $name
     * @param FormElementInterface $element
     * @param int $repeat
     * @return $this
     */
    public function addRepeatedForm(string $name, $repeat, FormElementInterface $element): FormElementInterface;

    /**
     * @param string $name
     * @return BaseElementInterface|FormElementInterface|ElementInterface
     */
    public function get(string $name): ?BaseElementInterface;

    /**
     * @return bool
     */
    public function hasChildren(): bool;

    /**
     * @return BaseElementInterface[]|FormElementInterface[]|ElementInterface[]
     */
    public function getChildren(): array;

    /**
     * @return \Traversable|BaseElementInterface[]
     */
    public function getIterator();

    /**
     * @param array|string $inputs
     * @return ValidationResultInterface[]
     */
    public function validate($inputs): array ;
}