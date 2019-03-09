<?php
namespace WScore\FormModel\Interfaces;

interface FormBuilderInterface
{
    /**
     * @return FormModel
     */
    public function build();

    /**
     * @param string $name
     * @return FormElementInterface
     */
    public function get($name);

    /**
     * @param string $name
     * @param FormElementInterface $element
     * @return FormBuilderInterface
     */
    public function add($name, $element);

    /**
     * @param string $name
     * @return FormElementInterface
     */
    public function addText($name);

    /**
     * @param string $name
     * @return FormElementInterface
     */
    public function addTextArea($name);

    /**
     * @param string $name
     * @return FormElementInterface
     */
    public function addSelect($name);

    /**
     * @param string $name
     * @return FormElementInterface
     */
    public function addCheckBoxes($name);

    /**
     * @param string $name
     * @return FormElementInterface
     */
    public function addRadioButtons($name);
}