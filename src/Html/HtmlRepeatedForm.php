<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use WScore\FormModel\Element\FormType;
use WScore\Html\Form;
use WScore\Html\Tags\Tag;

class HtmlRepeatedForm extends AbstractHtml
{
    /**
     * HtmlForm constructor.
     * @param FormType $element
     * @param HtmlFormInterface|null $parent
     * @param null $value
     */
    public function __construct(FormType $element, HtmlFormInterface $parent=null, $value = null)
    {
        parent::__construct($element, $parent, $value);
        $index = 0;
        foreach ($value as $index => $val) {
            $this[$index] = new HtmlForm($element, $this, $val, $index);
        }
        for ($extra = 0; $extra < $element->getRepeats(); $extra++) {
            $index += 1;
            $this[$index] = new HtmlForm($element, $this, [], $index);
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

    /**
     * @return string
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
    }
}