<?php


namespace App\Admin\Controllers;

use App\Models\Course;
use Dcat\Admin\Traits\HasUploadedFile;
use Illuminate\Http\Request;

class FileController
{
    use HasUploadedFile;

    public function registerFiles(Request $request)
    {
        $disk = $this->disk('admin');

        // 判断是否是删除文件请求
        if ($this->isDeleteRequest()) {
            // 删除文件并响应
            return $this->deleteFileAndResponse($disk);
        }

        // 获取上传的文件
        $file = $this->file();

        $phone=$request->input('phone');

        // 获取上传的字段名称
        $column = $this->uploader()->upload_column;
      if($column=='business_picture'){
          $file_name=$phone.'_business_picture';
      }
        if($column=='bank_permit_picture'){
            $file_name=$phone.'_bank_permit_picture';
        }

        $dir = 'register/';
        $newName = $file_name.'.'.$file->getClientOriginalExtension();


        $result = $disk->putFileAs($dir, $file, $newName);

        $path = "{$dir}/$newName";

        return $result
            ? $this->responseUploaded($path, $disk->url($path))
            : $this->responseErrorMessage('文件上传失败');
    }


}

