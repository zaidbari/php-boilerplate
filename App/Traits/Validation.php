<?php

namespace App\Traits;

use Rakit\Validation\Validator;

trait Validation
{

    use Request;

    protected array $validation_errors = [];

    protected function validate( array $rules = [] ) : bool
    {
        $validator = new Validator;

        $validation = $validator->validate($this->requestBody() + $_FILES, $rules);

        if ($validation->fails() ) {
            $this->validation_errors = $validation->errors()->firstOfAll();
            return false;
        }

        return true;
    }

}
