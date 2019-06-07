<?php
declare(strict_types=1);

namespace WScore\FormModel\ToString;

use WScore\FormModel\Element\ElementType;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\ToString\Bootstrap4\Bootstrap4Check;
use WScore\FormModel\ToString\Bootstrap4\Bootstrap4Form;
use WScore\FormModel\ToString\Bootstrap4\Bootstrap4Input;
use WScore\Validation\Interfaces\ResultInterface;

class Bootstrap4 implements ToStringFactoryInterface
{
    /**
     * @param HtmlFormInterface $html
     * @param ResultInterface|null $result
     * @return Bootstrap4Input|ToStringFactoryInterface
     */
    public function create(HtmlFormInterface $html, ResultInterface $result = null): ToStringInterface
    {
        $element = $html->getElement();
        if ($element->isFormType()) {
            return new Bootstrap4Form($html, $result);
        }
        if ($element->getType() === ElementType::CHECKBOX) {
            return new Bootstrap4Check($html, $result);
        }
        return new Bootstrap4Input($html, $result);
    }
}