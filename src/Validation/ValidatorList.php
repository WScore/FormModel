<?php
namespace WScore\FormModel\Validation;

class ValidatorList
{
    /**
     * @var ValidatorChain[]|ValidatorList[]
     */
    private $validators = [];

    /**
     * @var ResultList
     */
    private $results;

    /**
     * @return ResultList|ResultInterface
     */
    public function initializeResult()
    {
        $results = new ResultList();
        foreach ($this->validators as $validator) {
            $results->addResult($validator->initializeResult());
        }
        return $results;
    }

    /**
     * @param mixed $input
     * @param array $allInput
     * @return ResultList
     */
    public function validate($input, $allInput = [])
    {
        $this->results = $this->initializeResult();
        foreach ($this->validators as $name => $validator) {
            $result = $validator->validate($input, $allInput);
            $this->results->addResult($result);
        }
        return $this->results;
    }
}