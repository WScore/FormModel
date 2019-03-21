<?php
namespace WScore\FormModel\Element;

use WScore\FormModel\Interfaces\BaseElementInterface;
use WScore\FormModel\Validation\ValidationChain;
use WScore\FormModel\Validation\ValidationInterface;

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
    public function getFullName(): string
    {
        return $this->fullName;
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
}