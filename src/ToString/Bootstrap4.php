<?php
declare(strict_types=1);

namespace WScore\FormModel\ToString;

use WScore\FormModel\Element\ChoiceType;
use WScore\FormModel\Element\ElementInterface;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\Html\Tags\Choices;
use WScore\Html\Tags\Input;
use WScore\Html\Tags\Tag;
use WScore\Validation\Interfaces\ResultInterface;

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

    /**
     * @var null|ResultInterface
     */
    private $result;

    public function __construct()
    {
    }

    /**
     * @param HtmlFormInterface $html
     * @param ResultInterface|null $result
     * @return Bootstrap4|ToStringInterface
     */
    public function create(HtmlFormInterface $html, ResultInterface $result = null): ToStringInterface
    {
        $self = clone($this);
        $self->html = $html;
        $self->element = $html->getElement();
        $self->form = $html->form();
        $self->result = $result;

        return $self;
    }

    public function row(): string
    {
        if ($this->element->isFormType()) {
            return '';
        }
        $div = Tag::div();
        $div->class('form-group')
            ->setContents(
                $this->label(),
                $this->widget(),
                $this->error()
            );

        return $div->toString();
    }

    public function label(): string
    {
        if ($this->element->isFormType()) {
            return Tag::create('h2')
                ->setContents($this->html->label())
                ->toString();
        }
        $strLabel = $this->html->label();
        if (!$strLabel) return '';

        $label = Tag::label()
            ->setContents($strLabel)
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
        if ($error = $this->getError()) {
            $this->form->class('is-invalid');
        }

        return $this->form->toString();
    }

    private function getError(): string
    {
        if (!$this->result) return '';
        if ($this->result->isValid()) {
            return '';
        }
        return implode("\n", $this->result->getErrorMessage());
    }

    public function error(): string
    {
        $error = $this->getError();
        if (!$error) return '';
        $error = "<div class='invalid-feedback d-block'>{$error}</div>";
        return $error;
    }

    private function widgetExpanded(): string
    {
        $html = '';
        foreach ($this->form->getChoices() as $choice) {
            $choice->class('form-check-input');
            $label = Tag::label()
                ->setContents($choice->getLabel())
                ->class('form-check-label')
                ->set('for', $choice->get('id'));
            $div = Tag::div()
                ->class('form-check')
                ->setContents($choice, $label);
            $html .= $div->toString();
        }

        return $html;
    }
}