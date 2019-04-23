<?php
namespace WScore\FormModel\Element;

use ArrayIterator;
use InvalidArgumentException;
use Traversable;
use WScore\FormModel\Form\HtmlFormInterface;
use WScore\FormModel\Interfaces\BaseElementInterface;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Interfaces\FormElementInterface;
use WScore\Validation\Interfaces\ValidationInterface;
use WScore\Validation\ValidatorBuilder;

class FormType extends AbstractBase implements FormElementInterface
{
    /**
     * @var BaseElementInterface[]
     */
    private $children = [];

    /**
     * @var ValidatorBuilder
     */
    private $validationBuilder;

    /**
     * @param string $name
     * @param string $label
     * @return $this
     */
    public static function create(string $name, string $label = null)
    {
        $self = new static();
        $self->name = $name;
        $self->label = $label;
        $self->fullName = $name;

        return $self;
    }

    /**
     * @param ElementInterface $element
     * @return $this
     */
    public function add(ElementInterface $element): FormElementInterface
    {
        $this->addChild($element);
        return $this;
    }

    /**
     * @param FormElementInterface $element
     * @return $this
     */
    public function addForm(FormElementInterface $element): FormElementInterface
    {
        $this->addChild($element);
        return $this;
    }

    /**
     * @param FormType $element
     * @param int $repeat
     * @return $this
     */
    public function addRepeatedForm($repeat, FormType $element): FormElementInterface
    {
        $name = $element->getName();
        $form = FormType::create($name);
        $this->addChild($form);
        for($idx = 0; $idx < $repeat; $idx ++) {
            $cloned = clone $element;
            $cloned->setName("{$name}[{$idx}]");
            $form->addChild($cloned, $idx);
        }
        return $this;
    }

    /**
     * @param string $name
     * @return BaseElementInterface|ElementInterface|FormElementInterface
     */
    public function get(string $name): ?BaseElementInterface
    {
        if (!isset($this->children[$name])) {
            throw new InvalidArgumentException('name not found: '.$name);
        }
        $child = $this->children[$name];
        $fullName = $this->fullName
            ? $this->fullName . "[{$name}]"
            : $name;
        $child->setFullName($fullName);

        return $child;
    }

    private function addChild(BaseElementInterface $child, $name = null)
    {
        $name = $name ?? $child->getName();
        $this->children[$name] = $child;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return BaseElementInterface::TYPE_FORM;
    }

    /**
     * @return bool
     */
    public function isFormType(): bool
    {
        return true;
    }

    public function isRepeatedForm(): bool
    {
        return false;
    }

    public function createValidation(): ValidationInterface
    {
        $form = $this->validationBuilder->form();
        foreach ($this->children as $child) {
            if ($child->isRepeatedForm()) {
                $form->addRepeatedForm($child->getName(), $child->createValidation());
            } else {
                $form->add($child->getName(), $child->createValidation());
            }
        }
        return $form;
    }

    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        return !empty($this->children);
    }

    /**
     * @return BaseElementInterface[]
     */
    public function getChildren(): array
    {
        $children = [];
        foreach ($this->children as $name => $child) {
            $children[$name] = $this->get($name);
        }
        return $children;
    }

    /**
     * @return Traversable|BaseElementInterface[]
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getChildren());
    }

    /**
     * @param array|string $inputs
     * @return HtmlFormInterface
     */
    public function createHtml($inputs): HtmlFormInterface
    {
        // TODO: Implement getView() method.
    }
}