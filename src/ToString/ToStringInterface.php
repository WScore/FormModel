<?php
declare(strict_types=1);

namespace WScore\FormModel\ToString;

interface ToStringInterface
{
    public function row(): string;

    public function label(): string;

    public function widget(): string;

    public function error(): string;
}