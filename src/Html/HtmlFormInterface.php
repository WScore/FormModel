<?php

namespace WScore\FormModel\Html;

use ArrayAccess;
use IteratorAggregate;
use WScore\Html\Tags\Choices;
use WScore\Html\Tags\Input;
use WScore\Html\Tags\Tag;

interface HtmlFormInterface extends ArrayAccess, IteratorAggregate
{
    /**
     * @return string
     */
    public function name();

    /**
     * @return string
     */
    public function label();

    /**
     * @return string
     */
    public function value();

    /**
     * @return Input|Tag|Choices
     */
    public function form();

    /**
     * @return Input[]
     */
    public function choices();

    /**
     * @return string
     */
    public function __toString();

    /**
     * @return bool
     */
    public function hasChildren(): bool;

    /**
     * @return HtmlFormInterface[]
     */
    public function getChildren(): array;
}