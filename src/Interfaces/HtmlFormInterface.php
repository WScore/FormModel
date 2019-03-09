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
     * @param string $class
     * @return $this
     */
    public function setClass($class);

    /**
     * @return string
     */
    public function toHtmlForm();

    /**
     * @return string
     */
    public function toAttribute();

    /**
     * @return string
     */
    public function __toString();

    /**
     * @return self[]
     */
    public function getOptions();
}