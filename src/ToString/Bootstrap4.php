<?php
declare(strict_types=1);

namespace WScore\FormModel\ToString;

use WScore\FormModel\Element\ChoiceType;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\Interfaces\ElementInterface;
use WScore\FormModel\Interfaces\ToStringInterface;
use WScore\Html\Tags\Choices;
use WScore\Html\Tags\Input;
use WScore\Html\Tags\Tag;

class Bootstrap4 implements ToStringInterface
{
    /**
     * @var HtmlFormInterface
     */
    private $html;

    /**
     * @var ElementInterface
     */
    private $element;
    /**
     * @var Choices|Input|Tag
     */
    private $form;

    public function __construct()
    {
    }

    /**
     * @param HtmlFormInterface $html
     * @param ElementInterface $element
     * @return Bootstrap4|ToStringInterface
     */
    public function create(HtmlFormInterface $html, ElementInterface $element): ToStringInterface
    {
        $self = clone($this);
        $self->html = $html;
        $self->element = $element;
        $self->form = $html->form();

        return $self;
    }

    public function show(): string
    {
        if (!$this->element->isFormType()) {
            return $this->row();
        }
        foreach ($this->html as $item) {
        }

    }

    public function row(): string
    {
        if ($this->element->isFormType()) {
            return '';
        }
        $div = Tag::create('div');
        if ($this->isExpanded()) {
            $div->class('form-group')
                ->setContents(
                    $this->label(),
                    $this->widget());
        } else {
            $div->class('form-group')
                ->setContents(
                $this->label(),
                $this->widget()
            );
        }

        return $div->toString();
    }

    public function label(): string
    {
        if ($this->element->isFormType()) {
            return '';
        }
        $label = Tag::create('label')
            ->setContents($this->html->label())
            ->class('form-label');
        if ($this->element->isRequired()) {
            $label->class('required');
        }
        if (!$this->isExpanded()) {
            $label->set('for', $this->form->get('id'));
        }

        return $label->toString();
    }

    private function isExpanded(): bool
    {
        if (!$this->element instanceof ChoiceType) {
            return false;
        }
        if ($this->element->isExpand()) {
            return true;
        }
        return false;
    }

    public function widget(): string
    {
        if ($this->element->isFormType()) {
            return '';
        }
        if ($this->isExpanded()) {
            return $this->widgetExpanded();
        }
        $this->form->class('form-control');

        return $this->form->toString();
    }

    public function error(): string
    {
        // TODO: Implement error() method.
    }

    private function widgetExpanded(): string
    {
        $html = '';
        foreach ($this->form->getChoices() as $choice) {
            $choice->class('form-check-input');
            $label = Tag::create('label')
                ->setContents($choice->getLabel())
                ->class('form-check-label')
                ->set('for', $choice->get('id'));
            $div = Tag::create('div')
                ->class('form-check')
                ->setContents($choice, $label);
            $html .= $div->toString();
        }

        return $html;
    }
}