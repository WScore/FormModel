<?php
declare(strict_types=1);

namespace WScore\FormModel\Element;

use WScore\FormModel\ToString\ToStringFactoryInterface;
use WScore\FormModel\ToString\ToStringInterface;
use WScore\FormModel\Validation\ValidateFactory;
use WScore\Validation\Interfaces\ValidationInterface;
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
     * @var ToStringInterface
     */
    private $toString;

    /**
     * @param ValidatorBuilder $builder
     * @param string $type
     * @param string $name
     * @param string $label
     */
    public function __construct(ValidatorBuilder $builder, string $type, string $name, string $label = '')
    {
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
        $this->validationBuilder = $builder;
    }

    public function setToString(ToStringFactoryInterface $toString): void
    {
        $this->toString = $toString;
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
        return $this->getType() === ElementType::FORM_TYPE;
    }

    /**
     * @return bool
     */
    public function isRepeatedForm(): bool
    {
        return false;
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
     * @param string $label
     * @return ElementInterface|$this
     */
    public function setLabel(string $label): ElementInterface
    {
        $this->label = $label;
        return $this;
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
     * @return ValidationInterface
     */
    public function createValidation(): ValidationInterface
    {
        return $this->validationFactory->build($this);
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