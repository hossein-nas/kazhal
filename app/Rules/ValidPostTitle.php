<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidPostTitle implements Rule
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
        $re = '/^[^\$\_\@\$\<\>\{\}\n]+$/m';

        return preg_match_all($re, $value, $matches, PREG_SET_ORDER, 0);
    }

    public function message()
    {
        return ':attribute حاواری کاراکتر های غیرمجاز است.';
    }
}
