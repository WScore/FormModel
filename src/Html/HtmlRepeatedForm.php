<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use ArrayAccess;
use WScore\FormModel\Element\FormType;
use WScore\FormModel\Interfaces\ToStringInterface;
use WScore\Html\Form;
use WScore\Html\Tags\Tag;

class HtmlRepeatedForm extends AbstractHtml
{
    /**
     * HtmlForm constructor.
     * @param ToStringInterface $toString
     * @param FormType $element
     * @param HtmlFormInterface|null $parent
     */
    public function __construct(ToStringInterface $toString, FormType $element, HtmlFormInterface $parent=null)
    {
        parent::__construct($toString, $element, $parent);
    }

    /**
     * @param null|string|array|ArrayAccess $inputs
     * @param null|string|array|ArrayAccess $errors
     */
    public function setInputs($inputs, $errors = null)
    {
        parent::setInputs($inputs, $errors);
        $index = 0;
        if (is_array($inputs)) {
            foreach ($inputs as $index => $val) {
                $this[$index] = new HtmlForm($this->toString(), $this->element, $this, $index);
                $this[$index]->setInputs($val, $errors[$index]??null);
            }
        }
        for ($extra = 0; $extra < $this->element->getRepeats(); $extra++) {
            $index += 1;
            $this[$index] = new HtmlForm($this->toString(), $this->element, $this, $index);
            $this[$index]->setInputs([], $errors[$index]??null);
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