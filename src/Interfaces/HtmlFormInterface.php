<?php
namespace WScore\FormModel\Interfaces;

interface HtmlFormInterface
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
    public function form();

    /**
     * @return self[]
     */
    public function choices();

    /**
     * @return string
     */
    public function __toString();
}