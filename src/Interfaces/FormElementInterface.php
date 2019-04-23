<?php
namespace WScore\FormModel\Interfaces;

use IteratorAggregate;
use WScore\FormModel\Element\FormType;

interface FormElementInterface extends BaseElementInterface, IteratorAggregate
{
    /**
     * @param ElementInterface $element
     * @return $this
     */
    public function add(ElementInterface $element): FormElementInterface;

    /**
     * @param FormElementInterface $element
     * @return $this
     */
    public function addForm(FormElementInterface $element): FormElementInterface;

    /**
     * @param FormType $element
     * @param int $repeat
     * @return $this
     */
    public function addRepeatedForm($repeat, FormType $element): FormElementInterface;

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
}