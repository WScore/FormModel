<?php
namespace WScore\FormModel\Validation;

class ValidatorChain
{
    /**
     * @var Result
     */
    private $result;

    /**
     * @var FilterInterface[]
     */
    private $filters = [];

    /**
     * @var ValidatorInterface[]
     */
    private $validators = [];

    /**
     * @return Result|ResultInterface
     */
    public function initializeResult()
    {
        return new Result();
    }

    /**
     * @param mixed $value
     * @param array $allInputs
     * @return Result|null
     */
    public function validate($value, $allInputs = [])
    {
        $this->result = new Result();
        foreach ($this->filters as $filter) {
            $value = $filter->__invoke($value, $allInputs);
        }
        $this->result->setValue($value);
        foreach ($this->validators as $name => $validator) {
            if ($result = $validator->__invoke($this->result, $allInputs)) {
                return $result;
            }
        }
        return $this->result;
    }
}