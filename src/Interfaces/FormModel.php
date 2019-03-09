<?php
namespace WScore\FormModel\Interfaces;

interface FormModel
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return bool
     */
    public function hasChildren();

    /**
     * @return FormModel[]
     */
    public function getChildren();

    /**
     * @return HtmlFormInterface
     */
    public function getHtmlForm();

    /**
     * @param array $inputs
     * @return $this
     */
    public function validate($inputs);

    /**
     * @return bool
     */
    public function isValid();

    /**
     * @return ValidateResultInterface
     */
    public function getResult();

}