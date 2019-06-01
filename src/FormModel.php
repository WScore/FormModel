<?php
declare(strict_types=1);

namespace WScore\FormModel;

use ArrayAccess;
use InvalidArgumentException;
use WScore\FormModel\Element\ElementInterface;
use WScore\FormModel\Element\ElementType;
use WScore\FormModel\Element\FormElementInterface;
use WScore\FormModel\ToString\ViewModel;
use WScore\FormModel\Validation\ValidationModel;

class FormModel
{
    /**
     * @var FormBuilder
     */
    private $builder;

    /**
     * @var FormElementInterface
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
        if (in_array($type, [ElementType::TYPE_FORM, ElementType::TYPE_REPEATED], true) ) {
            throw new InvalidArgumentException('Cannot instantiate forms. ');
        }
        if (!isset($options['label'])) {
            $options['label'] = $name;
        }
        if ($type === ElementType::TYPE_CHOICE) {
            return $this->addChoices($name, $options);
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
        if ($repeat) {
            $this->form->addRepeatedForm($repeat, $element);
        }
        $this->form->addForm($element);

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

    /**
     * @param string $name
     * @return ElementInterface|FormElementInterface|null
     */
    public function get(string $name)
    {
        return $this->form->get($name);
    }

    /**
     * @param null|string|array|ArrayAccess $inputs
     * @param null|string|array|ArrayAccess $errors
     * @return Html\HtmlFormInterface
     */
    public function createHtml($inputs = [], $errors = null)
    {
        return $this->form->createHtml($inputs, $errors);
    }

    /**
     * @param array|null $inputs
     * @return ValidationModel
     */
    public function createValidation(array $inputs = null)
    {
        $validation = new ValidationModel($this);
        if (!empty($inputs)) {
            $validation->verify($inputs);
        }
        return $validation;
    }

    /**
     * @param array $inputs
     * @param null $errors
     * @return ViewModel
     */
    public function createView($inputs = [], $errors = null)
    {
        $html = $this->form->createHtml($inputs, $errors);
        return $this->builder->viewModel($html);
    }

    /**
     * @return FormElementInterface
     */
    public function getElement(): FormElementInterface
    {
        return $this->form;
    }
}