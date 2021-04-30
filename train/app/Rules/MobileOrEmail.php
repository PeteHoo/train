<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/4/30
 * Time: 14:50
 */

namespace App\Rules;


use Illuminate\Contracts\Validation\Rule;

class MobileOrEmail implements Rule
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
        $email_reg= '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/';
        return preg_match($money_reg, $value)||preg_match($email_reg, $value)||(!isset($value));
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        // TODO: Implement message() method.
        return ':attribute 必须是手机号或者邮箱。';
    }
}