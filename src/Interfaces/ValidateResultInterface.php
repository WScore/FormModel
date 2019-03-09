<?php
namespace WScore\FormModel\Interfaces;

interface ValidateResultInterface
{
    public function isValid();

    public function getValue();

    public function getErrorMessage();
}