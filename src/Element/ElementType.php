<?php
declare(strict_types=1);

namespace WScore\FormModel\Element;

interface ElementType
{
    const FORM_TYPE = 'form-type';
    const REPEATED_FORM = 'form-repeated';
    const CHOICE_TYPE = 'type-choice';
    const TEXT = 'text';
    const DATE = 'date';
    const TEXTAREA = 'textarea';
    const CHECKBOX = 'checkbox';
    const RADIO = 'radio';
    const EMAIL = 'email';
    const URL = 'url';
    const MONTH = 'month';
}