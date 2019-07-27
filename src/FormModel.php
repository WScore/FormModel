<?php
declare(strict_types=1);

namespace WScore\FormModel;

use ArrayAccess;
use InvalidArgumentException;
use WScore\FormModel\Element\ElementInterface;
use WScore\FormModel\Element\ElementType;
use WScore\FormModel\Element\FormType;
use WScore\FormModel\ToString\ViewModel;
use WScore\FormModel\Type\TypeInterface;
use WScore\FormModel\Validation\ValidationModel;
use WScore\Validation\Interfaces\ResultInterface;

class FormModel
{
    /**
     * @var FormBuilder
     */
    private $builder;

    /**
     * @var ElementInterface|FormType
     */
    private $form;

    public function __construct(FormBuilder $builder, string $name, array $options = [])
    {
        $this->builder = $builder;
        $this->form = $builder->form($name);
        $builder->apply($this->form, $options);
    }

    /**
     * @param string $name
     * @param string|ElementInterface|FormModel $type
     * @param array $options
     * @return $this
     */
    public function add(string $name, string $type, $options = []): FormModel
    {
        if (class_exists($type) && method_exists($type, 'forge')) {
            $element = $type::forge($this->builder, $name, $options);
            $this->form->add($element);
            return $this;
        }
        if (in_array($type, [ElementType::FORM_TYPE, ElementType::REPEATED_FORM], true) ) {
            throw new InvalidArgumentException('Cannot instantiate forms. ');
        }
        if (!isset($options['label'])) {
            $options['label'] = $name;
        }
        if ($type === ElementType::CHOICE_TYPE) {
            return $this->addChoices($name, $options);
        }
        if ($type === ElementType::CHECKBOX) {
            return $this->addButtons($type, $name, $options);
        }
        if ($type === ElementType::RADIO) {
            return $this->addButtons($type, $name, $options);
        }
        $element = $this->builder->$type($name);
        $this->builder->apply($element, $options);
        $this->form->add($element);
        return $this;
    }

    public function addForm(string $name, FormModel $form, array $options = []): FormModel
    {
        $element = $form->form;
        $element->setName($name);
        $repeat = (int) ($options['repeat'] ?? 0);
        unset($options['repeat']);
        if ($repeat) {
            $repeated = $this->builder->form($name);
            $this->builder->apply($repeated, $options);
            $repeated->add($element);
            $repeated->setRepeats($repeat);
            $this->form->add($repeated);
        } else {
            $this->builder->apply($element, $options);
            $this->form->add($element);
        }
        return $this;
    }

    /**
     * @param string $name
     * @param array $options
     * @return $this
     */
    private function addChoices(string $name, array $options): FormModel
    {
        $form = $this->builder->choices($name);
        $this->builder->apply($form, $options);
        $this->form->add($form);
        return $this;
    }

    private function addButtons(string $type, string $name, array $options)
    {
        $form = $this->builder->checkBox($type, $name);
        $this->builder->apply($form, $options);
        $this->form->add($form);
        return $this;
    }

    /**
     * @param string $name
     * @return ElementInterface|null
     */
    public function get(string $name)
    {
        return $this->form->get($name);
    }

    /**
     * @param null|string|array|ArrayAccess $inputs
     * @return Html\HtmlFormInterface
     */
    public function createHtml($inputs = [])
    {
        return $this->form->createHtml($inputs);
    }

    /**
     * @param array|null $inputs
     * @return ValidationModel
     */
    public function createValidation(array $inputs = null)
    {
        $validation = new ValidationModel($this);
        if (!is_null($inputs)) {
            $validation->verify($inputs);
        }
        return $validation;
    }

    /**
     * @param array $inputs
     * @param null|ResultInterface $errors
     * @return ViewModel
     */
    public function createView($inputs = [], $errors = null)
    {
        $html = $this->form->createHtml($inputs);
        return $this->builder->viewModel($html, $errors);
    }

    /**
     * @return ElementInterface
     */
    public function getElement(): ElementInterface
    {
        return $this->form;
    }
}