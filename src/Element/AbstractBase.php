<?php
namespace WScore\FormModel\Element;

use WScore\FormModel\Interfaces\BaseElementInterface;

abstract class AbstractBase implements BaseElementInterface
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
     * @var string
     */
    protected $fullName = '';

    /**
     * @param string $type
     * @param string $name
     * @param string $label
     */
    public function __construct($type, $name, $label)
    {
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
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
        return $this->getType() === BaseElementInterface::TYPE_FORM;
    }

    /**
     * @return bool
     */
    public function isRepeatedForm(): bool
    {
        return $this->getType() === BaseElementInterface::TYPE_REPEATED;
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