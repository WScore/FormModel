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
        $html = '';
        foreach ($this->html as $item) {
            $html .= $item->toString()->show();
        }
        return $html;
    }

    public function row(): string
    {
        if ($this->element->isFormType()) {
            return '';
        }
        $div = Tag::create('div');
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
        if ($error = $this->getError()) {
            $this->form->class('is-invalid');
        }

        return $this->form->toString();
    }

    private function getError(): string
    {
        $error = $this->html->error();
        if (!$error) return '';
        if ($error instanceof ResultInterface) {
            if ($error->isValid()) {
                return '';
            }
            $error = $error->getErrorMessage();
        }
        if (is_array($error)) {
            $error = implode("\n", $error);
        }
        return $error;
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