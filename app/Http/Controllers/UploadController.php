<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller {

    public function image(Request $request) {

        if ($request->isMethod('post')) {
            $file = $request->file('file');
            if ($file) {
                $originalName = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();
                $realPath = $file->getRealPath();
                $type = $file->getClientMimeType();
                $filename = date('Y-m-d-H-i') . '-' . uniqid() . '.' . $ext;
                Storage::disk('image')->put($filename, file_get_contents($realPath));
                $name = 'uploads/image/'. $filename;
                $res = [
                    'file' => $name
                ];
                $res = json_encode($res);
                return $res;
            }
        }
    }
    public function file(Request $request) {

        if ($request->isMethod('post')) {
            $file = $request->file('file');
            if ($file) {
                $originalName = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();
                $realPath = $file->getRealPath();
                $type = $file->getClientMimeType();
                $filename = date('Y-m-d-H-i') . '-' . uniqid() . '.' . $ext;
                Storage::disk('video')->put($filename, file_get_contents($realPath));
                $name = 'uploads/videos/'. $filename;
                $res = [
                    'file' => $name
                ];
                $res = json_encode($res);
                return $res;
            }
        }
    }

}
