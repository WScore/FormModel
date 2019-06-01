<?php
declare(strict_types=1);

namespace WScore\FormModel\ToString;

use WScore\FormModel\Html\HtmlFormInterface;
use WScore\Validation\Interfaces\ResultInterface;

interface ToStringInterface
{

    /**
     * @param HtmlFormInterface $html
     * @param ResultInterface|null $result
     * @return ToStringInterface
     */
    public function create(HtmlFormInterface $html, ResultInterface $result = null): ToStringInterface;

    public function row(): string;

    public function label(): string;

    public function widget(): string;

    public function error(): string;
}