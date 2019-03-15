<?php

namespace WScore\FormModel\Interfaces;

/**
 * Interface FilterInterface
 * @package WScore\FormModel\Interfaces
 */
interface FilterInterface
{
    public function __invoke($input, $allInputs);
}
