<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use ArrayAccess;
use WScore\FormModel\Element\FormType;
use WScore\FormModel\Interfaces\ToStringInterface;
use WScore\Html\Form;
use WScore\Html\Tags\Tag;

class HtmlForm extends AbstractHtml
{
    /**
     * HtmlForm constructor.
     * @param ToStringInterface $toString
     * @param FormType $element
     * @param HtmlFormInterface|null $parent
     * @param null|string $name
     */
    public function __construct(ToStringInterface $toString, FormType $element, HtmlFormInterface $parent=null, $name = null)
    {
        parent::__construct($toString, $element, $parent, $name);
        foreach ($element->getChildren() as $child) {
            $name = $child->getName();
            $this[$name] = Html::create($toString, $child, $this);
        }
    }

    /**
     * @param null|string|array|ArrayAccess $inputs
     * @param null|string|array|ArrayAccess $errors
     */
    public function setInputs($inputs, $errors = null)
    {
        parent::setInputs($inputs, $errors);
        foreach ($this->element->getChildren() as $child) {
            $name = $child->getName();
            $this[$name]->setInputs($this->getChildValue($name), $errors[$name]??null);
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