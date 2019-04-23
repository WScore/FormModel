<?php
namespace WScore\FormModel\Html;

use Traversable;
use WScore\FormModel\Interfaces\BaseElementInterface;

class Html implements HtmlFormInterface
{
    public static function create(BaseElementInterface $element): HtmlFormInterface
    {

    }

    /**
     * @return string
     */
    public function name()
    {
        // TODO: Implement name() method.
    }

    /**
     * @return string
     */
    public function label()
    {
        // TODO: Implement label() method.
    }

    /**
     * @return string
     */
    public function value()
    {
        // TODO: Implement value() method.
    }

    /**
     * @return string
     */
    public function form()
    {
        // TODO: Implement form() method.
    }

    /**
     * @return self[]
     */
    public function choices()
    {
        // TODO: Implement choices() method.
    }

    /**
     * @return string
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
    }

    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        // TODO: Implement hasChildren() method.
    }

    /**
     * @return HtmlFormInterface[]
     */
    public function getChildren(): array
    {
        // TODO: Implement getChildren() method.
    }

    /**
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    /**
     * @param string $offset
     * @return HtmlFormInterface
     */
    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    /**
     * @param string $offset
     * @param HtmlFormInterface $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    /**
     * @param string
     * @return void
     */
    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

    /**
     * @return Traversable|HtmlFormInterface[]
     */
    public function getIterator()
    {
        // TODO: Implement getIterator() method.
    }
}