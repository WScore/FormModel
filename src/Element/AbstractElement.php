<?php
namespace WScore\FormModel\Element;

use WScore\FormModel\Html\Html;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Validation\Validator;
use WScore\Validation\ValidatorBuilder;

abstract class AbstractElement implements ElementInterface
{
    /**
     * @var string
     */
    protected $type = '';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var ValidatorBuilder
     */
    protected $validationBuilder;

    /**
     * @var array
     */
    private $filters = [];

    /**
     * @param ValidatorBuilder $builder
     * @param string $type
     * @param string $name
     * @param string $label
     */
    public function __construct(ValidatorBuilder $builder, $type, $name, $label = '')
    {
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
        $this->validationBuilder = $builder;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isFormType(): bool
    {
        return $this->getType() === ElementType::TYPE_FORM;
    }

    /**
     * @return bool
     */
    public function isRepeatedForm(): bool
    {
        return $this->getType() === ElementType::TYPE_REPEATED;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    protected function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes): ElementInterface
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @return Validator
     */
    public function createValidation(): Validator
    {
        return Validator::create($this->validationBuilder, $this);
    }

    /**
     * @param null|array|string $inputs
     * @return HtmlFormInterface
     */
    public function createHtml($inputs = null): HtmlFormInterface
    {
        return Html::create($this);
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @param array $filters
     * @return $this
     */
    public function setFilters(array $filters): ElementInterface
    {
        $this->filters = $filters;
        return $this;
    }
}