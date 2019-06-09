<?php
declare(strict_types=1);

namespace WScore\FormModel\ToString\Bootstrap4;

use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\ToString\ToStringInterface;
use WScore\Html\Tags\Choices;
use WScore\Html\Tags\Input;
use WScore\Html\Tags\Tag;
use WScore\Validation\Interfaces\ResultInterface;

final class ToInput implements ToStringInterface
{
    /**
     * @var HtmlFormInterface
     */
    private $html;

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

        return $label->toString();
    }

    public function widget(): string
    {
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
}