<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use WScore\FormModel\Element\FormType;
use WScore\Html\Form;
use WScore\Html\Tags\Tag;

class HtmlForm extends AbstractHtml
{
    /**
     * HtmlForm constructor.
     * @param FormType $element
     * @param HtmlFormInterface|null $parent
     * @param null $value
     * @param null|string $name
     */
    public function __construct(FormType $element, HtmlFormInterface $parent=null, $value = null, $name = null)
    {
        parent::__construct($element, $parent, $value, $name);
        foreach ($element->getChildren() as $child) {
            $name = $child->getName();
            $this[$name] = Html::create($child, $this, $this->getChildValue($name));
            if ($this->getToString()) {
                $this[$name]->setToString($this->getToString());
            }
        }
    }

    /**
     * @param string $name
     * @return array|object|string|null
     */
    private function getChildValue(string $name)
    {
        $value = $this->value();
        if (is_null($value)) {
            return $value;
        }
        if (is_array($value)) {
            return $value[$name] ?? null;
        }
        if (is_object($value)) {
            $method = 'get' . ucwords($name);
            if (method_exists($value, $method)) {
                return $value->$method();
            }
            $method = $name;
            if (method_exists($value, $method)) {
                return $value->$method();
            }
            if (property_exists ($value, $name)) {
                return $value->$name;
            }
        }
        return $value;
    }

    /**
     * @return Tag
     */
    public function form()
    {
        $form = Form::open('', 'post')
            ->set('name', $this->fullName());
        return $form;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
    }
}