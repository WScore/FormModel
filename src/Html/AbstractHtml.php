<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use ArrayIterator;
use InvalidArgumentException;
use Traversable;
use WScore\FormModel\Element\ChoiceType;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Interfaces\ToStringInterface;
use WScore\Html\Tags\Input;

abstract class AbstractHtml implements HtmlFormInterface
{
    /**
     * @var ChoiceType|ElementInterface
     */
    protected $element;

    /**
     * @var HtmlFormInterface|null
     */
    private $parent;

    /**
     * @var array|object|string
     */
    private $value;

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
     * @param ElementInterface $element
     * @param HtmlFormInterface|null $parent
     * @param null $value
     * @param null|string $name
     */
    public function __construct(ElementInterface $element, HtmlFormInterface $parent = null, $value = null, $name = null)
    {
        $this->element = $element;
        $this->parent = $parent;
        $this->value = $value;
        $this->name = $name ?? $element->getName();
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
     * @param ToStringInterface $toString
     */
    public function setToString(ToStringInterface $toString): void
    {
        $this->toString = $toString;
    }

    /**
     * @return ToStringInterface|null
     */
    protected function getToString(): ?ToStringInterface
    {
        return $this->toString;
    }
}
