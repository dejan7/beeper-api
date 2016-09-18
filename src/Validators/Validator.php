<?php

namespace BeeperApi\Validators;

use BeeperApi\Exceptions\ApiException;
use Http\Request;

abstract class Validator
{
    protected $validator;

    public function __construct(Request $request)
    {
        $this->validator = new \Valitron\Validator(array_merge($request->getParameters(), $_FILES));
        $this->rules();
    }

    public function validate()
    {
        if (!$this->validator->validate()) {
            $errors = [];
            //loop through nested array and get values
            foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($this->validator->errors()),
                         \RecursiveIteratorIterator::CATCH_GET_CHILD) as $value)
            {
                $errors[] = $value;
            }
            throw new ApiException(422, $errors);
        }
    }

    abstract protected function rules();

}