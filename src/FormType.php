<?php
namespace WScore\FormModel;

use WScore\FormModel\Form\HtmlFormInterface;
use WScore\FormModel\Interfaces\BaseFormInterface;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Interfaces\FormTypeInterface;
use WScore\FormModel\Validation\FilterInterface;
use WScore\FormModel\Validation\ValidationResultInterface;
use WScore\FormModel\Validation\ValidatorInterface;

class FormType implements FormTypeInterface
{
    /**
     * @var array
     */
    private $elements = [];

    private $name;

    private $label;

    /**
     * @param string $name
     * @param string $label
     * @return $this
     */
    public static function create(string $name, string $label = null)
    {
        $self = new static();
        $self->name = $name;
        $self->label = $label;

        return $self;
    }

    /**
     * @param string $name
     * @param ElementInterface $element
     * @return $this
     */
    public function add(string $name, ElementInterface $element): FormTypeInterface
    {
        $this->elements[$name] = $element;
        return $this;
    }

    /**
     * @param string $name
     * @return BaseFormInterface
     */
    public function get(string $name): ?BaseFormInterface
    {
        return isset($this->elements[$name]) ? $this->elements[$name] : null;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return BaseFormInterface::TYPE_FORM;
    }

    /**
     * @return bool
     */
    public function isFormType(): bool
    {
        return true;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        // TODO: Implement getName() method.
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        // TODO: Implement getLabel() method.
    }

    /**
     * @param callable|FilterInterface $filter
     * @return $this
     */
    public function setInputFilter(callable $filter): FormTypeInterface
    {
        // TODO: Implement setInputFilter() method.
    }

    /**
     * @param callable|ValidatorInterface $validator
     * @return $this
     */
    public function setValidator(callable $validator): FormTypeInterface
    {
        // TODO: Implement setValidator() method.
    }

    /**
     * @param array|string $inputs
     * @return ValidationResultInterface
     */
    public function validate($inputs): ValidationResultInterface
    {
        // TODO: Implement validate() method.
    }

    /**
     * @param string $name
     * @param FormTypeInterface $element
     * @param int $repeat
     * @return $this
     */
    public function addForm(string $name, FormTypeInterface $element, $repeat = 0): FormTypeInterface
    {
        // TODO: Implement addForm() method.
    }

    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        // TODO: Implement hasChildren() method.
    }

    /**
     * @return BaseFormInterface[]
     */
    public function getChildren(): array
    {
        // TODO: Implement getChildren() method.
    }

    /**
     * @return \Traversable|BaseFormInterface[]
     */
    public function getIterator()
    {
        // TODO: Implement getIterator() method.
    }

    /**
     * @param string $prefix
     * @return $this
     */
    public function setPrefixName(string $prefix): FormTypeInterface
    {
        // TODO: Implement setPrefixName() method.
    }

    /**
     * @param array|string $inputs
     * @return HtmlFormInterface
     */
    public function viewHtml($inputs): HtmlFormInterface
    {
        // TODO: Implement getView() method.
    }
}