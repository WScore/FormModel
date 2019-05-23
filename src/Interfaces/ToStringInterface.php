<?php
declare(strict_types=1);

namespace WScore\FormModel\Interfaces;

use WScore\FormModel\Html\HtmlFormInterface;

interface ToStringInterface
{

    /**
     * @param HtmlFormInterface $html
     * @param ElementInterface $element
     * @return ToStringInterface
     */
    public function create(HtmlFormInterface $html, ElementInterface $element): ToStringInterface;

    public function show(): string;

    public function row(): string;

    public function label(): string;

    public function widget(): string;

    public function error(): string;
}