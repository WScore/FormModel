<?php
declare(strict_types=1);

namespace WScore\FormModel\Element;

use ArrayIterator;
use BadMethodCallException;
use InvalidArgumentException;
use Traversable;
use WScore\FormModel\Html\HtmlForm;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\Html\HtmlRepeatedForm;
use WScore\Validation\ValidatorBuilder;

class FormType extends AbstractElement implements FormElementInterface
{
    /**
     * @var ElementInterface[]
     */
    private $children = [];

    /**
     * @var int    set integer for repeated form, set null for normal form.
     */
    private $numRepeats = null;

    /**
     * FormType constructor.
     * @param ValidatorBuilder $builder
     * @param string $name
     * @param string $label
     */
    public function __construct(ValidatorBuilder $builder, string $name, string $label = '')
    {
        parent::__construct($builder, ElementType::FORM_TYPE, $name, $label);
    }

    /**
     * @param string $name
     * @return FormElementInterface
     */
    public function setName(string $name): FormElementInterface
    {
        $this->name = $name;
        return $this;
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
     * @param FormElementInterface $element
     * @param int $repeat
     * @return $this
     */
    public function addRepeatedForm(int $repeat, FormElementInterface $element): FormElementInterface
    {
        $element->setRepeats($repeat);
        $this->addChild($element);
        return $this;
    }

    /**
     * @param string $name
     * @return ElementInterface|ElementInterface|FormElementInterface
     */
    public function get(string $name): ?ElementInterface
    {
        if (!isset($this->children[$name])) {
            throw new InvalidArgumentException('No such name found: '.$name);
        }
        $child = $this->children[$name];

        return $child;
    }

    private function addChild(ElementInterface $child, $name = null)
    {
        $name = $name ?? $child->getName();
        $this->children[$name] = $child;
    }

    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        return !empty($this->children);
    }

    /**
     * @return ElementInterface[]
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
     * @return Traversable|ElementInterface[]
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getChildren());
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        throw new BadMethodCallException();
    }

    /**
     * @param bool $required
     * @return $this
     */
    public function setRequired(bool $required = true): ElementInterface
    {
        throw new BadMethodCallException();
    }

    /**
     * @return bool
     */
    public function isRepeatedForm(): bool
    {
        return is_int($this->numRepeats);
    }

    /**
     * @return int
     */
    public function getRepeats(): int
    {
        return $this->numRepeats;
    }

    /**
     * @param int $num
     */
    public function setRepeats(int $num)
    {
        $this->numRepeats = $num;
    }

    /**
     * @param null|array|string $inputs
     * @return HtmlFormInterface
     */
    public function createHtml($inputs = null): HtmlFormInterface
    {
        $html = $this->isRepeatedForm()
            ? new HtmlRepeatedForm($this, null)
            : new HtmlForm($this, null);
        $inputs = $inputs[$this->name] ?? null;
        $html->setInputs($inputs);
        return $html;
    }
}