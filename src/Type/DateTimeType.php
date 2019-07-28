<?php
declare(strict_types=1);

namespace WScore\FormModel\Type;

use WScore\FormModel\Element\Input;
use WScore\FormModel\FormBuilder;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\Html\HtmlInput;
use WScore\Validation\ValidatorBuilder;

class DateTimeType extends Input implements TypeInterface
{
    public function __construct(ValidatorBuilder $builder, string $name, string $label = '')
    {
        parent::__construct($builder, 'datetime', $name, $label);
    }

    public static function forge(FormBuilder $builder, string $name, array $options): TypeInterface
    {
        $type = new self($builder->getValidationBuilder(), $name);
        $builder->apply($type, $options);
        $type->setToString($builder->getToString());

        return $type;
    }

    /**
     * @param null|array|string $inputs
     * @return HtmlFormInterface
     */
    public function createHtml($inputs = null): HtmlFormInterface
    {
        $html = new HtmlInput($this, null, 'datetime-local');
        $html->setInputs($inputs);
        return $html;
    }
}