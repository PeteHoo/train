<?php
/**
 * Created by PhpStorm.
 * User: 35304
 * Date: 2021/5/6
 * Time: 21:57
 */

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class UpdatePlanResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->versionName->name??'',
            'md5' => $this->md5,
            'download_link' =>$this->download_link,
            'description' =>  $this->description,
            'after_version' => $this->afterVersion->version_code??'',
            'before_version' => $this->beforeVersion->version_code??'',
            'status' => $this->sort,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}