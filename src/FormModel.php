<?php
declare(strict_types=1);

namespace WScore\FormModel;

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

    public function add(string $name, string $type, array $options = [])
    {
        if (!isset($options['label'])) {
            $options['label'] = $name;
        }
        if ($type === ElementType::TYPE_FORM) {
            $form = $this->builder->form($name);
            $this->builder->apply($form, $options);
            $this->form->addForm($form);
            return $this;
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
}