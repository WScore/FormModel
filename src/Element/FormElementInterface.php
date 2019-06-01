<?php
declare(strict_types=1);

namespace WScore\FormModel\Element;

use IteratorAggregate;

interface FormElementInterface extends ElementInterface, IteratorAggregate
{
    /**
     * @param string $name
     * @return FormElementInterface
     */
    public function setName(string $name): FormElementInterface;

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
     * TODO: implement repeated form!
     *
     * @param FormElementInterface $element
     * @param int $repeat
     * @return $this
     */
    public function addRepeatedForm(int $repeat, FormElementInterface $element): FormElementInterface;

    /**
     * @return int
     */
    public function getRepeats(): int;

    /**
     * @param int $num
     */
    public function setRepeats(int $num);

    /**
     * @param string $name
     * @return ElementInterface|FormElementInterface|ElementInterface
     */
    public function get(string $name): ?ElementInterface;

    /**
     * @return bool
     */
    public function hasChildren(): bool;

    /**
     * @return ElementInterface[]|FormElementInterface[]|ElementInterface[]
     */
    public function getChildren(): array;
}