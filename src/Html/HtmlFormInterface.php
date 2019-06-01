<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use ArrayAccess;
use IteratorAggregate;
use WScore\FormModel\Element\ElementInterface;
use WScore\Html\Tags\Choices;
use WScore\Html\Tags\Input;
use WScore\Html\Tags\Tag;

interface HtmlFormInterface extends ArrayAccess, IteratorAggregate
{
    /**
     * @param null|string|array|ArrayAccess $inputs
     * @param null|string|array|ArrayAccess $errors
     */
    public function setInputs($inputs, $errors = null);

    /**
     * @return string
     */
    public function name();

    /**
     * @return string
     */
    public function fullName();

    /**
     * @return string
     */
    public function label();

    /**
     * @return string|array|mixed
     */
    public function value();

    /**
     * @return string|array|mixed
     */
    public function error();

    /**
     * @return Input|Tag|Choices
     */
    public function form();

    /**
     * @return Input[]
     */
    public function choices();

    /**
     * @param $name
     * @return bool
     */
    public function has($name): bool;

    /**
     * @param $name
     * @return HtmlFormInterface
     */
    public function get($name): ?HtmlFormInterface;

    /**
     * @return bool
     */
    public function hasChildren(): bool;

    /**
     * @return HtmlFormInterface[]
     */
    public function getChildren(): array;

    /**
     * @return ElementInterface
     */
    public function getElement(): ElementInterface;

    /**
     * @param mixed $offset
     * @return $this|HtmlFormInterface
     */
    public function offsetGet($offset);
}