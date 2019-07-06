<?php
declare(strict_types=1);

namespace WScore\FormModel\Element;

use ArrayIterator;
use InvalidArgumentException;
use Traversable;
use WScore\FormModel\ToString\ToStringFactoryInterface;
use WScore\FormModel\ToString\ToStringInterface;
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
     * @var ElementInterface[]
     */
    private $children = [];

    /**
     * @var int    set integer for repeated form, set null for normal form.
     */
    private $numRepeats = null;

    /**
     * @var string
     */
    private $message;

    /**
     * @var bool
     */
    private $isRequired = true;

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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ElementInterface
     */
    public function setName(string $name): ElementInterface
    {
        $this->name = $name;
        return $this;
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
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->isRequired;
    }

    /**
     * @param bool $required
     * @return $this
     */
    public function setRequired(bool $required = true): ElementInterface
    {
        $this->isRequired = $required;
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

    /**
     * @param ElementInterface $element
     * @return $this
     */
    public function add(ElementInterface $element): ElementInterface
    {
        $this->addChild($element);
        return $this;
    }

    /**
     * @param string $name
     * @return ElementInterface
     */
    public function get(string $name): ?ElementInterface
    {
        if (!isset($this->children[$name])) {
            throw new InvalidArgumentException('No such name found: ' . $name);
        }
        $child = $this->children[$name];

        return $child;
    }

    /**
     * @param ElementInterface $element
     * @param int $repeat
     * @return $this
     */
    public function addRepeatedForm(int $repeat, ElementInterface $element): ElementInterface
    {
        $element->setRepeats($repeat);
        $this->addChild($element);
        return $this;
    }

    protected function addChild(ElementInterface $child, $name = null)
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
     * @param string $message
     * @return ElementInterface
     */
    public function setMessage(string $message): ElementInterface
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $type
     * @return array
     */
    protected function prepareFilters($type = 'text'): array
    {
        $filters = $this->getFilters();
        $filters['type'] = $type;
        if ($message = $this->getMessage()) {
            $filters['message'] = $message;
        }
        return $filters;
    }
}