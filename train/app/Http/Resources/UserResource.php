<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/4/17
 * Time: 14:19
 */

namespace App\Http\Resources;


use App\Utils\Constants;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'user_id' => $this->user_id,
            'name' => $this->name,
            'nick_name' => $this->nick_name,
            'phone' => $this->phone,
            'sex' => Constants::getSexType($this->sex),
            'attribute' =>  $this->attribute,
            'avatar' => getImageUrl($this->avatar),
            'mechanism' => $this->mechanism->name??'',
            'industry' => $this->industry->name??'',
            'occupation' => $this->occupation->name??'',
            'api_token' => $this->api_token,
            'status' => $this->status,
        ];
    }
}