<?php


namespace App\Utils;


class ApiException extends \Exception
{
    use ApiResponse;
    public function render(){
        return self::error(ErrorCode::PARAMETER_ERROR,$this->getMessage());
    }
}
