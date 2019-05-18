<?php
namespace WScore\FormModel\Html;

use ArrayIterator;
use InvalidArgumentException;
use Traversable;
use WScore\FormModel\Element\ChoiceType;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\Html\Tags\Input;

abstract class AbstractHtml implements HtmlFormInterface
{
    /**
     * @var ChoiceType
     */
    protected $element;

    private $info = [];
    /**
     * @var HtmlFormInterface|null
     */
    private $parent;

    /**
     * AbstractHtml constructor.
     * @param ElementInterface $element
     * @param HtmlFormInterface|null $parent
     */
    public function __construct(ElementInterface $element, HtmlFormInterface $parent = null)
    {
        $this->element = $element;
        $this->parent = $parent;
    }

    /**
     * @var HtmlFormInterface[]
     */
    private $children = [];

    /**
     * @param string $key
     * @param string|mixed $default
     * @return string|array|mixed
     */
    public function get($key, $default = '')
    {
        return $this->info[$key] ?? $default;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->element->getName();
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
        return $this->get('value');
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
}
