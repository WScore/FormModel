<?php
declare(strict_types=1);

namespace WScore\FormModel\ToString;

use ArrayAccess;
use ArrayIterator;
use BadMethodCallException;
use IteratorAggregate;
use Traversable;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Interfaces\ToStringInterface;

class ViewModel implements ArrayAccess, IteratorAggregate
{
    /**
     * @var ToStringInterface
     */
    private $toString;

    /**
     * @var HtmlFormInterface
     */
    private $html;

    /**
     * @var ElementInterface
     */
    private $element;

    public function __construct(ToStringInterface $toString, HtmlFormInterface $html, ElementInterface $element)
    {
        $this->toString = $toString->create($html, $element);
        $this->html = $html;
        $this->element = $element;
    }

    public function show(): string
    {
        return $this->toString->show();
    }

    public function row(): string
    {
        return $this->toString->row();
    }

    public function label(): string
    {
        return $this->toString->label();
    }

    public function widget(): string
    {
        return $this->toString->widget();
    }

    public function error(): string
    {
        return $this->toString->error();
    }

    /**
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->html->has($offset);
    }

    /**
     * @param string $offset
     * @return ViewModel
     */
    public function offsetGet($offset)
    {
        $html = $this->html->get($offset);
        return $html
            ? new self($this->toString, $html, $html->getElement())
            : null;
    }

    /**
     * @param string $offset
     * @param ViewModel $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        throw new BadMethodCallException('cannot set new html.');
    }

    /**
     * @param string
     * @return void
     */
    public function offsetUnset($offset)
    {
        throw new BadMethodCallException('cannot unset html.');
    }

    /**
     * @return Traversable|ViewModel[]
     */
    public function getIterator()
    {
        $list = [];
        foreach ($this->html->getChildren() as $child) {
            $list[] = new ViewModel($this->toString, $child, $child->getElement());
        };
        return new ArrayIterator($list);
    }

    public function __toString()
    {
        return $this->row();
    }
}