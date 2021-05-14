<?php
/**
 * Created by PhpStorm.
 * User: 35304
 * Date: 2021/5/6
 * Time: 21:57
 */

namespace App\Http\Resources;


use App\Models\AppName;
use App\Models\Version;
use Illuminate\Http\Resources\Json\JsonResource;

class UpdatePlanResource extends JsonResource
{
    public function toArray($request)
    {
        $versionList=Version::getVersionData($this->versionName->name??'');
        $appNameList=AppName::getAppNameData();
        return [
            'id' => $this->id,
            'name' => $appNameList[$this->versionName->name]??'',
            'md5' => $this->md5,
            'download_link' =>getImageUrl($this->download_link),
            'description' =>  $this->description,
            'after_version' => $this->afterVersionApi->version_code??'',
            'before_version' => getMultipleStringItems($versionList,explode(',',$this->before_version)),
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
