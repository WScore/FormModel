<?php
namespace WScore\FormModel;

use WScore\FormModel\Element\AbstractBase;
use WScore\FormModel\Form\HtmlFormInterface;
use WScore\FormModel\Interfaces\BaseElementInterface;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Interfaces\FormElementInterface;
use WScore\FormModel\Validation\ValidationResultInterface;

class FormType extends AbstractBase implements FormElementInterface
{
    /**
     * @var BaseElementInterface[]
     */
    private $children = [];

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

        return $self;
    }

    /**
     * @param string $name
     * @param ElementInterface $element
     * @return $this
     */
    public function add(string $name, ElementInterface $element): FormElementInterface
    {
        $this->addChild($name, $element);
        return $this;
    }

    /**
     * @param string $name
     * @return BaseElementInterface|ElementInterface|FormElementInterface
     */
    public function get(string $name): ?BaseElementInterface
    {
        return isset($this->children[$name]) ? $this->children[$name] : null;
    }

    private function addChild(string  $name, BaseElementInterface $child)
    {
        $fullName = $this->fullName
            ? $this->fullName . "[{$name}]"
            : $name;
        $child->setFullName($fullName);
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

    /**
     * @param array|string $inputs
     * @return ValidationResultInterface[]
     */
    public function validate($inputs): array
    {
        $results = [];
        foreach($this->getChildren() as $name => $child) {
            $value = $inputs[$name] ?? null;
            $results[] = $child->validate($value);
        }
        return $results;
    }

    /**
     * @param string $name
     * @param FormElementInterface $element
     * @return $this
     */
    public function addForm(string $name, FormElementInterface $element): FormElementInterface
    {
        $this->addChild($name, $element);
        return $this;
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
        return $this->children;
    }

    /**
     * @return \Traversable|BaseElementInterface[]
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->children);
    }

    /**
     * @param string $name
     * @param FormElementInterface $element
     * @param int $repeat
     * @return $this
     */
    public function addRepeatedForm(string $name, $repeat, FormElementInterface $element): FormElementInterface
    {
        $form = FormType::create($name);
        $this->addChild($name, $form);
        for($idx = 0; $idx < $repeat; $idx ++) {
            $form->addForm($idx, $element);
        }
        return $this;
    }

    /**
     * @param array|string $inputs
     * @return HtmlFormInterface
     */
    public function viewHtml($inputs): HtmlFormInterface
    {
        // TODO: Implement getView() method.
    }
}