<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use ArrayAccess;
use WScore\FormModel\Element\FormType;
use WScore\Html\Form;
use WScore\Html\Tags\Tag;

class HtmlForm extends AbstractHtml
{
    /**
     * HtmlForm constructor.
     * @param FormType $element
     * @param HtmlFormInterface|null $parent
     * @param null|string $name
     */
    public function __construct(FormType $element, HtmlFormInterface $parent=null, $name = null)
    {
        parent::__construct($element, $parent, $name);
        foreach ($element->getChildren() as $child) {
            $name = $child->getName();
            $this[$name] = Html::create($child, $this);
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
            $this[$name]->setInputs(ValueAccess::get($inputs, $name), ValueAccess::get($errors, $name));
        }
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
}