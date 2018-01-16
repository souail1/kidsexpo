<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller {

    public function upload(Request $request) {

        if ($request->isMethod('post')) {
            $file = $request->file('file');
            // �ļ��Ƿ��ϴ��ɹ�
            if ($file) {
                // ��ȡ�ļ������Ϣ
                $originalName = $file->getClientOriginalName(); // �ļ�ԭ��
                $ext = $file->getClientOriginalExtension();     // ��չ��
                $realPath = $file->getRealPath();   //��ʱ�ļ��ľ���·��
                $type = $file->getClientMimeType();     // image/jpeg
                // �ϴ��ļ�
                $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                // ʹ�������½���uploads���ش洢�ռ䣨Ŀ¼��
                Storage::disk('uploads')->put($filename, file_get_contents($realPath));
                return $filename;
            }
        }
    }

}
