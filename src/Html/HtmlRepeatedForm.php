<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use ArrayAccess;
use InvalidArgumentException;
use WScore\FormModel\Element\FormType;
use WScore\Html\Form;
use WScore\Html\Tags\Tag;

final class HtmlRepeatedForm extends AbstractHtml
{
    /**
     * @param null|string|array|ArrayAccess $inputs
     */
    public function setInputs($inputs)
    {
        parent::setInputs($inputs);
        $index = 0;
        $repeated = $this->element->get($this->name());
        if (!$repeated instanceof FormType) {
            throw new InvalidArgumentException('repeated form must contain FormType');
        }
        if (is_array($inputs)) {
            foreach ($inputs as $index => $val) {
                $this[$index] = new HtmlForm($repeated, $index);
                $this[$index]->setParent($this);
                $this[$index]->setInputs($val);
            }
        }
        for ($extra = 0; $extra < $this->element->getRepeats(); $extra++) {
            $index += 1;
            $this[$index] = new HtmlForm($repeated, $index);
            $this[$index]->setParent($this);
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