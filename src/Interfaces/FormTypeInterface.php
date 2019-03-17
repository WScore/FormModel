<?php
namespace WScore\FormModel\Interfaces;

interface FormTypeInterface extends BaseFormInterface, \IteratorAggregate
{
    /**
     * @param string $name
     * @param ElementInterface $element
     * @return $this
     */
    public function add(string $name, ElementInterface $element): FormTypeInterface;

    /**
     * @param string $name
     * @param FormTypeInterface $element
     * @param int $repeat
     * @return $this
     */
    public function addForm(string $name, FormTypeInterface $element, $repeat = 0): FormTypeInterface;

    /**
     * @param string $name
     * @return BaseFormInterface|FormTypeInterface|ElementInterface
     */
    public function get(string $name): ?BaseFormInterface;

    /**
     * @return bool
     */
    public function hasChildren(): bool;

    /**
     * @return BaseFormInterface[]|FormTypeInterface[]|ElementInterface[]
     */
    public function getChildren(): array;

    /**
     * @return \Traversable|BaseFormInterface[]
     */
    public function getIterator();

    /**
     * @param string $prefix
     * @return FormTypeInterface
     */
    public function setPrefixName(string $prefix): FormTypeInterface;
}