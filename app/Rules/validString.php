<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class validString implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $re = '/[\^&=!\\\\\/#$%@<>]+/m';

        return  ! preg_match_all($re, $value, $matches, PREG_SET_ORDER, 0);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute دارای کاراکتر های غیرمجاز هست.';
    }
}
