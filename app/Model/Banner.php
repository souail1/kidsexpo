<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Common\Enum\HttpCode;
use Illuminate\Support\Facades\DB;

class Banner extends Model
{
    protected $table = 'banners';
    protected $fillable = ['id','title','img','sort'];

    public function addBanner(array $data) : bool
    {
        $has = Banner::where('title', $data['title'])->count();
        if ($has > 0) {
            $this->error = '该标题已存在';
            $this->httpCode = HttpCode::CONFLICT;
            return false;
        }
        DB::beginTransaction();
        $banner = Banner::create($data);
        if (!$banner) {
            $this->error = '添加失败';
            $this->httpCode = HttpCode::BAD_REQUEST;
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;

    }

    public function updateBanner(array $param) : bool
    {
        if ($param) {
            $banner = Banner::where('title', $param['title'])->first();
            if ($banner && ($banner['id'] != $param['id'])) {
                $this->error = '该标题已存在';
                $this->httpCode = HttpCode::CONFLICT;
                return false;
            }
        }
        $save = [
            'title' => $param['title'],
            'img' =>$param['img'],
            'sort' => $param['sort'],
        ];
        $res = Banner::where('id', $param['id'])->update($save);
        if (!$res) {
            $this->error = '更新失败';
            $this->httpCode = HttpCode::BAD_REQUEST;
            return false;
        }
        return true;

    }
}
