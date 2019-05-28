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
    public function add(string $name, $type, $options = [])
    {
        if ($type instanceof ElementInterface) {
            return $this->addElement($name, $type, $options);
        }
        if ($type instanceof FormModel) {
            $element = $type->form;
            return $this->addElement($name, $element, $options);
        }
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
        return $this->addElement($name, $element, $options);
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
     * @param FormElementInterface|FormModel $form
     * @return $this
     */
    public function addForm($form): FormModel
    {
        if ($form instanceof FormElementInterface) {
            $element = $form;
        } elseif ($form instanceof FormModel) {
            $element = $form->form;
        } else {
            throw new InvalidArgumentException('specify a FormModel or FormElement');
        }
        $this->form->addForm($element);
        return $this;
    }

    /**
     * @param FormElementInterface|FormModel $form
     * @param int $repeat
     * @return $this
     */
    public function addRepeatedForm($form, $repeat = 1): FormModel
    {
        if ($form instanceof FormElementInterface) {
            $element = $form;
        } elseif ($form instanceof FormModel) {
            $element = $form->form;
        } else {
            throw new InvalidArgumentException('specify a FormModel or FormElement');
        }
        $this->form->addRepeatedForm($repeat, $element);
        return $this;
    }

    /**
     * @param string $name
     * @param ElementInterface $element
     * @param array $options
     * @return $this|FormModel
     */
    public function addElement(string $name, ElementInterface $element, array $options): FormModel
    {
        if ($name !== $element->getName()) {
            throw new InvalidArgumentException('name must be the same');
        }
        if ($element instanceof FormElementInterface) {
            $repeat = (int) ($options['repeat'] ?? 0);
            if ($repeat) {
                return $this->addRepeatedForm($element, $repeat);
            }
            return $this->addForm($element);
        }
        $this->builder->apply($element, $options);
        $this->form->add($element);
        return $this;
    }

    /**
     * @param string $name
     * @param array $options
     * @return $this
     */
    protected function addChoices(string $name, array $options): FormModel
    {
        $form = $this->builder->choices($name);
        $this->builder->apply($form, $options);
        $this->form->add($form);
        return $this;
    }
}