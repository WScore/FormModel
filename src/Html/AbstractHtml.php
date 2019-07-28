<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use ArrayAccess;
use ArrayIterator;
use InvalidArgumentException;
use Traversable;
use WScore\FormModel\Element\Choice;
use WScore\FormModel\Element\ElementInterface;
use WScore\FormModel\Element\FormType;
use WScore\Html\Tags\Input;

abstract class AbstractHtml implements HtmlFormInterface
{
    /**
     * @var Choice|FormType|ElementInterface
     */
    protected $element;

    /**
     * @var HtmlFormInterface|null
     */
    private $parent;

    /**
     * @var array|object|string|ArrayAccess
     */
    private $inputs;

    /**
     * @var string
     */
    private $name;

    /**
     * @var HtmlFormInterface[]
     */
    private $children = [];

    /**
     * AbstractHtml constructor.
     * @param ElementInterface $element
     * @param null|string $name
     */
    public function __construct(ElementInterface $element, $name = null)
    {
        $this->element = $element;
        $this->name = $name ?? $element->getName();
    }

    /**
     * @param null|string|array|ArrayAccess $inputs
     */
    public function setInputs($inputs)
    {
        $this->inputs = $inputs;
    }

    public function setParent(HtmlFormInterface $parent): void
    {
        $this->parent = $parent;
    }

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
            if ($this->name() === '') {
                return $parentName;
            }
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
    public function inputs()
    {
        return $this->inputs;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->element->isRequired();
    }

    /**
     * @return Input[]
     */
    public function choices()
    {
        return [];
    }

    /**
     * @param $name
     * @return bool
     */
    public function has($name): bool
    {
        return array_key_exists($name, $this->children);
    }

    /**
     * @param $name
     * @return HtmlFormInterface
     */
    public function get($name): ?HtmlFormInterface
    {
        return $this->children[$name] ?? null;
    }

    /**
     * @return ElementInterface
     */
    public function getElement(): ElementInterface
    {
        return $this->element;
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
}
