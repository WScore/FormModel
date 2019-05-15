<?php
namespace WScore\FormModel\Validation;

use InvalidArgumentException;
use WScore\FormModel\Element\ChoiceType;
use WScore\FormModel\Element\ElementType;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Interfaces\FormElementInterface;
use WScore\Validation\Filters\InArray;
use WScore\Validation\Filters\Required;
use WScore\Validation\Interfaces\ResultInterface;
use WScore\Validation\Interfaces\ValidationInterface;
use WScore\Validation\ValidatorBuilder;

class Validator
{
    /**
     * @var ValidatorBuilder
     */
    private $builder;

    /**
     * @var ValidationInterface
     */
    private $validation;

    public function __construct(ValidatorBuilder $builder)
    {
        $this->builder = $builder;
    }

    public static function create(ValidatorBuilder $builder, ElementInterface $element): Validator
    {
        $self = new self($builder);
        $self->validation = $self->build($element);

        return $self;
    }

    private function build(ElementInterface $element): ValidationInterface
    {
        if ($element->isFormType() && $element instanceof FormElementInterface) {
            return $this->buildForm($element);
        }
        if ($element->getType() === ElementType::TYPE_CHOICE && $element instanceof ChoiceType) {
            return $this->buildChoices($element);
        }
        if ($element instanceof ElementInterface) {
            return $this->buildInput($element);
        }
        throw new InvalidArgumentException('cannot build validator');
    }

    private function buildInput(ElementInterface $element): ValidationInterface
    {
        $filters = $element->getFilters();
        $filters['type'] = $element->getType();
        if ($element->isRequired()) {
            $filters[Required::class] = [];
        }
        $validation = $this->builder->chain($filters);
        return $validation;
    }

    private function buildForm(FormElementInterface $element): ValidationInterface
    {
        $validation = $this->builder->form();
        foreach ($element->getChildren() as $child) {
            if ($child->isRepeatedForm()) {
                $validation->addRepeatedForm($child->getName(), $this->build($child));
            } else {
                $validation->add($child->getName(), $this->build($child));
            }
        }
        return $validation;
    }

    public function verify($inputs): ResultInterface
    {
        return $this->validation->verify($inputs);
    }

    public function getValidation(): ValidationInterface
    {
        return $this->validation;
    }

    private function buildChoices(ChoiceType $element)
    {
        $filters = $element->getFilters();
        $filters['type'] = 'text';
        $filters['multiple'] = $element->isMultiple();
        if ($element->isRequired()) {
            $filters[Required::class] = [];
        }
        $choices = array_keys($element->getChoices());
        $filters[InArray::class] = $element->isReplace()
            ? [InArray::REPLACE => $choices]
            : [InArray::CHOICES => $choices];
        $validation = $this->builder->chain($filters);
        return $validation;

    }
}