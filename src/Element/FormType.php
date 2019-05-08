<?php
namespace WScore\FormModel\Element;

use ArrayIterator;
use BadMethodCallException;
use InvalidArgumentException;
use Traversable;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Interfaces\FormElementInterface;
use WScore\Validation\ValidatorBuilder;

class FormType extends AbstractElement implements FormElementInterface
{
    /**
     * @var ElementInterface[]
     */
    private $children = [];

    /**
     * @var bool
     */
    private $isMultiple = false;

    public function __construct(ValidatorBuilder $builder, $name, $label = '')
    {
        parent::__construct($builder, ElementInterface::TYPE_FORM, $name, $label);
    }

    /**
     * @param ElementInterface $element
     * @return $this
     */
    public function add(ElementInterface $element): FormElementInterface
    {
        $this->addChild($element);
        return $this;
    }

    /**
     * @param FormElementInterface $element
     * @return $this
     */
    public function addForm(FormElementInterface $element): FormElementInterface
    {
        $this->addChild($element);
        return $this;
    }

    /**
     * @param FormElementInterface $element
     * @param int $repeat
     * @return $this
     */
    public function addRepeatedForm($repeat, FormElementInterface $element): FormElementInterface
    {
        $element->setMultiple();
        $this->addChild($element);
        return $this;
    }

    /**
     * @param string $name
     * @return ElementInterface|ElementInterface|FormElementInterface
     */
    public function get(string $name): ?ElementInterface
    {
        if (!isset($this->children[$name])) {
            throw new InvalidArgumentException('name not found: '.$name);
        }
        $child = $this->children[$name];
        $fullName = $this->fullName
            ? $this->fullName . "[{$name}]"
            : $name;
        $child->setFullName($fullName);

        return $child;
    }

    private function addChild(ElementInterface $child, $name = null)
    {
        $name = $name ?? $child->getName();
        $this->children[$name] = $child;
    }

    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        return !empty($this->children);
    }

    /**
     * @return ElementInterface[]
     */
    public function getChildren(): array
    {
        $children = [];
        foreach ($this->children as $name => $child) {
            $children[$name] = $this->get($name);
        }
        return $children;
    }

    /**
     * @return Traversable|ElementInterface[]
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getChildren());
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        throw new BadMethodCallException();
    }

    /**
     * @param bool $required
     * @return $this
     */
    public function setRequired($required = true): ElementInterface
    {
        throw new BadMethodCallException();
    }

    /**
     * @return bool
     */
    public function isMultiple(): bool
    {
        return $this->isMultiple;
    }

    /**
     * @param bool $multiple
     * @return $this
     */
    public function setMultiple($multiple = true): ElementInterface
    {
        $this->isMultiple = $multiple;
        return $this;
    }
}