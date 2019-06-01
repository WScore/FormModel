<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use ArrayAccess;
use WScore\FormModel\Element\FormType;
use WScore\Html\Form;
use WScore\Html\Tags\Tag;

class HtmlRepeatedForm extends AbstractHtml
{
    /**
     * HtmlForm constructor.
     * @param FormType $element
     * @param HtmlFormInterface|null $parent
     */
    public function __construct(FormType $element, HtmlFormInterface $parent=null)
    {
        parent::__construct($element, $parent);
    }

    /**
     * @param null|string|array|ArrayAccess $inputs
     */
    public function setInputs($inputs)
    {
        parent::setInputs($inputs);
        $index = 0;
        if (is_array($inputs)) {
            foreach ($inputs as $index => $val) {
                $this[$index] = new HtmlForm($this->element, $this, $index);
                $this[$index]->setInputs($val);
            }
        }
        for ($extra = 0; $extra < $this->element->getRepeats(); $extra++) {
            $index += 1;
            $this[$index] = new HtmlForm($this->element, $this, $index);
            $this[$index]->setInputs([]);
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