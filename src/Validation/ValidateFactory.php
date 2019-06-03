<?php
declare(strict_types=1);

namespace WScore\FormModel\Validation;

use InvalidArgumentException;
use WScore\FormModel\Element\ChoiceType;
use WScore\FormModel\Element\ElementInterface;
use WScore\FormModel\Element\ElementType;
use WScore\FormModel\Element\FormElementInterface;
use WScore\Validation\Filters\InArray;
use WScore\Validation\Filters\Required;
use WScore\Validation\Interfaces\ValidationInterface;
use WScore\Validation\ValidatorBuilder;

class ValidateFactory
{
    /**
     * @var ValidatorBuilder
     */
    private $builder;

    private $elementType2ValidationType = [
        ElementType::TEXTAREA => 'text',
    ];

    public function __construct(ValidatorBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function build(ElementInterface $element): ValidationInterface
    {
        if ($element->isFormType() && $element instanceof FormElementInterface) {
            return $this->buildForm($element);
        }
        if ($element->getType() === ElementType::CHOICE_TYPE && $element instanceof ChoiceType) {
            return $this->buildChoices($element);
        }
        if ($element instanceof ElementInterface) {
            return $this->buildInput($element);
        }
        throw new InvalidArgumentException('cannot build validator');
    }

    private function getValidationType($elementType)
    {
        return array_key_exists($elementType, $this->elementType2ValidationType)
            ? $this->elementType2ValidationType[$elementType]
            : $elementType;
    }

    private function buildInput(ElementInterface $element): ValidationInterface
    {
        $filters = $element->getFilters();
        $filters['type'] = $this->getValidationType($element->getType());
        if ($element->isRequired()) {
            $filters[Required::class] = [];
        }
        $validation = $this->builder->chain($filters);

        return $validation;
    }

    private function buildForm(FormElementInterface $element): ValidationInterface
    {
        $filters = $element->getFilters();
        $validation = $this->builder->form($filters);
        foreach ($element->getChildren() as $child) {
            if ($child->isRepeatedForm()) {
                $validation->addRepeatedForm($child->getName(), $this->build($child), $child->getFilters());
            } else {
                $validation->add($child->getName(), $this->build($child));
            }
        }
        return $validation;
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