<?php

namespace WScore\FormModel\Validation;

/**
 * Interface FilterInterface
 * @package WScore\FormModel\Interfaces
 */
interface ValidatorInterface
{
    /**
     * @param ValidationResultInterface $result
     * @param string $name
     * @return void
     */
    public function __invoke(ValidationResultInterface $result, $name);
}
