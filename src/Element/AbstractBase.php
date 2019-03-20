<?php
namespace WScore\FormModel\Element;

use WScore\FormModel\Interfaces\BaseElementInterface;
use WScore\FormModel\Validation\FilterInterface;
use WScore\FormModel\Validation\ValidatorInterface;

abstract class AbstractBase implements BaseElementInterface
{
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
     * @var string
     */
    protected $fullName = '';

    /**
     * @var FilterInterface[]
     */
    protected $input_filters = [];

    /**
     * @var ValidatorInterface[]
     */
    protected $validators = [];

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
    public function setAttributes(array $attributes): BaseElementInterface
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @param string $fullName
     * @return $this
     */
    public function setFullName(string $fullName): BaseElementInterface
    {
        $this->fullName = $fullName;
        return $this;
    }

    /**
     * @param callable[]|FilterInterface[] $filters
     * @return $this
     */
    public function setInputFilter(callable ...$filters): BaseElementInterface
    {
        $this->input_filters = $filters;
        return $this;
    }

    /**
     * @param callable[]|ValidatorInterface[] $validators
     * @return $this
     */
    public function setValidator(callable ...$validators): BaseElementInterface
    {
        $this->validators = $validators;
        return $this;
    }
}