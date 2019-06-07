<?php
declare(strict_types=1);

namespace WScore\FormModel\ToString;

use WScore\FormModel\Element\ElementType;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\ToString\Bootstrap4\ToCheckBox;
use WScore\FormModel\ToString\Bootstrap4\ToChoices;
use WScore\FormModel\ToString\Bootstrap4\ToForm;
use WScore\FormModel\ToString\Bootstrap4\ToInput;
use WScore\Validation\Interfaces\ResultInterface;

class Bootstrap4 implements ToStringFactoryInterface
{
    /**
     * @param HtmlFormInterface $html
     * @param ResultInterface|null $result
     * @return ToInput|ToStringFactoryInterface
     */
    public function create(HtmlFormInterface $html, ResultInterface $result = null): ToStringInterface
    {
        $element = $html->getElement();
        if ($element->isFormType()) {
            return new ToForm($html, $result);
        }
        if ($element->getType() === ElementType::CHECKBOX) {
            return new ToCheckBox($html, $result);
        }
        if ($element->getType() === ElementType::CHOICE_TYPE) {
            return new ToChoices($html, $result);
        }
        return new ToInput($html, $result);
    }
}