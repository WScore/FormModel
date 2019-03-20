<?php
namespace WScore\FormModel\Validation;

use WScore\FormModel\Interfaces\FormElementInterface;

class FormResult implements ValidationResultInterface
{
    /**
     * @var null|array
     */
    private $value = [];

    /**
     * @var bool
     */
    private $isValid;

    /**
     * @var array
     */
    private $message = [];

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var string
     */
    private $label = '';

    /**
     * @var Result[]
     */
    private $children = [];

    /**
     * @param FormElementInterface $form
     * @param ValidationResultInterface[] $results
     * @return ValidationResultInterface
     */
    public static function aggregate(FormElementInterface $form, array $results): ValidationResultInterface
    {
        if (empty($results)) {
            throw new \InvalidArgumentException('empty results');
        }
        $self = new self();
        $self->fillResult($form);
        $isValid = true;
        foreach ($results as $name => $result) {
            if (!$result->isValid()) {
                $isValid = false;
            }
            $self->value[$name] = $result->value();
            $self->message[$name] = $result->getErrorMessage();
            $self->children[$name] = $result;
        }
        $self->isValid = $isValid;

        return $self;
    }

    private function fillResult(FormElementInterface $element)
    {
        $this->name = $element->getName();
        $this->label = $element->getLabel();
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string|string[]|mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function label(): string
    {
        return $this->label;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasChild(string $name): bool
    {
        return isset($this->children[$name]);
    }

    /**
     * @param string $name
     * @return ValidationResultInterface
     */
    public function getChild(string $name): ?ValidationResultInterface
    {
        return $this->children[$name] ?? null;
    }

    /**
     * @return string|string[]|mixed
     */
    public function getErrorMessage()
    {
        return $this->message;
    }

    /**
     * @return self[]|\iterable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->getChildren());
    }

    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        return count($this->children);
    }

    /**
     * @return ValidationResultInterface[]
     */
    public function getChildren()
    {
        return $this->children;
    }
}