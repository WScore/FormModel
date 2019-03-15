<?php
namespace WScore\FormModel\Interfaces;

interface FormTypeInterface extends BaseFormInterface, \IteratorAggregate
{
    /**
     * @param string $name
     * @param string $label
     * @return $this
     */
    public static function create(string $name, string $label): self;

    /**
     * @param string $name
     * @param ElementInterface $element
     * @return $this
     */
    public function add(string $name, ElementInterface $element): self;

    /**
     * @param string $name
     * @param FormTypeInterface $element
     * @param int $repeat
     * @return $this
     */
    public function addForm(string $name, FormTypeInterface $element, $repeat = 0): self;

    /**
     * @param string $name
     * @return BaseFormInterface
     */
    public function get(string  $name);

    /**
     * @return bool
     */
    public function hasChildren(): bool;

    /**
     * @return BaseFormInterface[]
     */
    public function getChildren();

    /**
     * @return \Traversable|BaseFormInterface[]
     */
    public function getIterator();

    /**
     * @param string $prefix
     * @return FormTypeInterface
     */
    public function setPrefixName(string $prefix): self;
}