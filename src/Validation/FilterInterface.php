<?php

namespace WScore\FormModel\Validation;

/**
 * Interface FilterInterface
 * @package WScore\FormModel\Interfaces
 */
interface FilterInterface
{
    /**
     * @param string|string[]|array $input
     * @param array $allInputs
     * @return string|string[]|null
     */
    public function __invoke($input, $allInputs);
}
