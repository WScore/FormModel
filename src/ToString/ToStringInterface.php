<?php
declare(strict_types=1);

namespace WScore\FormModel\ToString;

use WScore\FormModel\Element\ElementInterface;
use WScore\FormModel\Html\HtmlFormInterface;

interface ToStringInterface
{

    /**
     * @param HtmlFormInterface $html
     * @return ToStringInterface
     */
    public function create(HtmlFormInterface $html): ToStringInterface;

    public function row(): string;

    public function label(): string;

    public function widget(): string;

    public function error(): string;
}