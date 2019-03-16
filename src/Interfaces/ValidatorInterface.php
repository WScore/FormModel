<?php

namespace WScore\FormModel\Interfaces;

/**
 * Interface FilterInterface
 * @package WScore\FormModel\Interfaces
 */
interface ValidatorInterface
{
    /**
     * @param ValidateResultInterface $result
     * @param string $name
     * @return void
     */
    public function __invoke(ValidateResultInterface $result, $name);
}
