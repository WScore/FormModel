<?php
declare(strict_types=1);

namespace WScore\FormModel\ToString;

use WScore\FormModel\Html\HtmlFormInterface;
use WScore\Validator\Interfaces\ResultInterface;

interface ToStringFactoryInterface
{

    /**
     * @param HtmlFormInterface $html
     * @param ResultInterface|null $result
     * @return ToStringInterface
     */
    public function create(HtmlFormInterface $html, ResultInterface $result = null): ToStringInterface;
}