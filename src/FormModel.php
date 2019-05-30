<?php
declare(strict_types=1);

namespace WScore\FormModel;

use InvalidArgumentException;
use WScore\FormModel\Element\ElementType;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Interfaces\FormElementInterface;

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

    public function __construct(FormBuilder $builder, string $name)
    {
        $this->builder = $builder;
        $this->form = $builder->form($name);
    }

    /**
     * @param string $name
     * @param string|ElementInterface|FormModel $type
     * @param array $options
     * @return $this
     */
    public function add(string $name, string $type, $options = [])
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
     * @return Interfaces\ElementInterface|FormElementInterface|null
     */
    public function get(string $name)
    {
        return $this->form->get($name);
    }

    /**
     * @param array $inputs
     * @return Html\HtmlFormInterface
     */
    public function createHtml($inputs = [])
    {
        return $this->form->createHtml($inputs);
    }

    /**
     * @return Validation\Validator
     */
    public function createValidation()
    {
        return $this->form->createValidation();
    }
}