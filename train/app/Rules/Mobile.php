<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/4/8
 * Time: 16:06
 */

namespace App\Rules;


use Illuminate\Contracts\Validation\Rule;

class Mobile implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // TODO: Implement passes() method.
        $money_reg= '/^[1][0-9][0-9]{9}$/';
        return preg_match($money_reg, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        // TODO: Implement message() method.
        return ':attribute 必须是手机号。';
    }
}
