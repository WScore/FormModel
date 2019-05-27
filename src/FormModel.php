<?php
declare(strict_types=1);

namespace WScore\FormModel;

use InvalidArgumentException;
use WScore\FormModel\Element\ElementType;
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

    public function add(string $name, string $type, $options = [])
    {
        if ($type === ElementType::TYPE_FORM) {
            throw new InvalidArgumentException('Please use addForm');
        }
        if (!isset($options['label'])) {
            $options['label'] = $name;
        }
        if ($type === ElementType::TYPE_REPEATED) {
            $form = $this->builder->form($name);
            $this->builder->apply($form, $options);
            $repeat = $options['repeat'] ?? 1;
            $this->form->addRepeatedForm($repeat, $form);
            return $this;
        }
        if ($type === ElementType::TYPE_CHOICE) {
            $form = $this->builder->choices($name);
            $this->builder->apply($form, $options);
            $this->form->add($form);
            return $this;
        }
        $element = $this->builder->$type($name);
        $this->builder->apply($element, $options);
        $this->form->add($element);
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
}