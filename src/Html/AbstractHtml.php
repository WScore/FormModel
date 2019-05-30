<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use ArrayAccess;
use ArrayIterator;
use InvalidArgumentException;
use Traversable;
use WScore\FormModel\Element\ChoiceType;
use WScore\FormModel\Element\FormType;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Interfaces\ToStringInterface;
use WScore\Html\Tags\Input;

abstract class AbstractHtml implements HtmlFormInterface
{
    /**
     * @var ChoiceType|FormType|ElementInterface
     */
    protected $element;

    /**
     * @var HtmlFormInterface|null
     */
    private $parent;

    /**
     * @var array|object|string|ArrayAccess
     */
    private $value;

    /**
     * @var array|object|string|ArrayAccess
     */
    private $errors;

    /**
     * @var string
     */
    private $name;

    /**
     * @var ToStringInterface
     */
    private $toString;

    /**
     * AbstractHtml constructor.
     * @param ToStringInterface $toString
     * @param ElementInterface $element
     * @param HtmlFormInterface|null $parent
     * @param null|string $name
     */
    public function __construct(ToStringInterface $toString, ElementInterface $element, HtmlFormInterface $parent = null, $name = null)
    {
        $this->toString = $toString;
        $this->element = $element;
        $this->parent = $parent;
        $this->name = $name ?? $element->getName();
    }

    /**
     * @param null|string|array|ArrayAccess $inputs
     * @param null|string|array|ArrayAccess $errors
     */
    public function setInputs($inputs, $errors = null)
    {
        $this->value = $inputs;
        $this->errors = $errors;
    }

    /**
     * @var HtmlFormInterface[]
     */
    private $children = [];

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function fullName()
    {
        if ($this->parent) {
            $parentName = $this->parent->fullName();
            return $parentName . "[{$this->name()}]";
        }
        return $this->name();
    }

    /**
     * @return string
     */
    public function label()
    {
        return $this->element->getLabel();
    }

    /**
     * @return string
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @return Input[]
     */
    public function choices()
    {
        return [];
    }

    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        return !empty($this->children);
    }

    /**
     * @return HtmlFormInterface[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->children);
    }

    /**
     * @param string $offset
     * @return HtmlFormInterface
     */
    public function offsetGet($offset)
    {
        return $this->children[$offset] ?? null;
    }

    /**
     * @param string $offset
     * @param HtmlFormInterface $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if ($value instanceof HtmlFormInterface) {
            $this->children[$offset] = $value;
            return;
        }
        throw new InvalidArgumentException();
    }

    /**
     * @param string
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->children[$offset]);
    }

    /**
     * @return Traversable|HtmlFormInterface[]
     */
    public function getIterator()
    {
        return new ArrayIterator($this->children);
    }

    /**
     * @return ToStringInterface|null
     */
    protected function getToString(): ?ToStringInterface
    {
        return $this->toString;
    }

    public function toString(): ?ToStringInterface
    {
        if ($this->toString) {
            return $this->toString->create($this, $this->element);
        }
        return null;
    }
}
