<?php
declare(strict_types=1);

namespace WScore\FormModel\ToString\Bootstrap4;

use WScore\FormModel\Element\Choice;
use WScore\FormModel\Element\ElementInterface;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\ToString\ToStringInterface;
use WScore\Html\Tags\Choices;
use WScore\Html\Tags\Input;
use WScore\Html\Tags\Tag;
use WScore\Validation\Interfaces\ResultInterface;

final class ToChoices implements ToStringInterface
{
    /**
     * @var HtmlFormInterface
     */
    private $html;

    /**
     * @var ElementInterface|Choice
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

    public function __construct(HtmlFormInterface $html, ResultInterface $result = null)
    {
        $this->html = $html;
        $this->element = $html->getElement();
        $this->form = $html->form();
        $this->result = $result;
    }

    public function row(): string
    {
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
        $strLabel = $this->html->label();
        if (!$strLabel) return '';

        $label = Tag::label()
            ->setContents($strLabel)
            ->class('form-label');
        if ($this->html->isRequired()) {
            $label->class('required');
        }
        if (!$this->isExpanded()) {
            $label->set('for', $this->form->get('id'));
        }

        return $label->toString();
    }

    private function isExpanded(): bool
    {
        if ($this->element->isExpand()) {
            return true;
        }
        return false;
    }

    public function widget(): string
    {
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
        foreach ($this->html->getChildren() as $name => $button) {
            $form = $button->form()->class('form-check-input');
            $label = Tag::label($button->label())
                ->class('form-check-label')
                ->set('for', $form->get('id'));
            $div = Tag::div($form, $label)
                ->class('form-check');
            $html .= $div->toString();
        }

        return $html;
    }
}