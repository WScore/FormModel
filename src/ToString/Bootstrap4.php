<?php
declare(strict_types=1);

namespace WScore\FormModel\ToString;

use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\ToString\Bootstrap4\ToButtons;
use WScore\FormModel\ToString\Bootstrap4\ToChoices;
use WScore\FormModel\ToString\Bootstrap4\ToForm;
use WScore\FormModel\ToString\Bootstrap4\ToInput;
use WScore\FormModel\Type\CheckboxType;
use WScore\FormModel\Type\ChoiceType;
use WScore\FormModel\Type\RadioType;
use WScore\Validator\Interfaces\ResultInterface;

final class Bootstrap4 implements ToStringFactoryInterface
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
        $type = get_class($element);
        if ($type === CheckboxType::class) {
            return new ToButtons($html, $result);
        }
        if ($type === RadioType::class) {
            return new ToButtons($html, $result);
        }
        if ($type === ChoiceType::class) {
            return new ToChoices($html, $result);
        }
        return new ToInput($html, $result);
    }
}