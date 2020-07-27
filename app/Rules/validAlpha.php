<?php

namespace App\Rules;

use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Validation\Rule;

class validAlpha implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
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
        $re = '/^[A-Z0-9a-zپچجحخهعغفقثصضشسیبلاتنمکگوئدذرزطظژؤإأءًٌٍَُِّ _۰-۹\.]+$/m';

        return preg_match_all($re, $value, $matches, PREG_SET_ORDER, 0);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "برای :attribute فقط مجاز هستید از حروف فارسی و انگلیسی و اعداد و \"_\" استفاده کنید.";
    }
}
