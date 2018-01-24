<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Common\Enum\HttpCode;
use Illuminate\Support\Facades\DB;

class Video extends Model
{
    protected $table = 'videos';
    protected $fillable = ['id','title','brief','time','cover','video','sort','status'];

    public function addvideo(array $data) : bool
    {
        $has = Video::where('title', $data['title'])->count();
        if ($has > 0) {
            $this->error = '该标题已存在';
            $this->httpCode = HttpCode::CONFLICT;
            return false;
        }
        DB::beginTransaction();
        $video = Video::create($data);
        if (!$video) {
            $this->error = '添加失败';
            $this->httpCode = HttpCode::BAD_REQUEST;
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;

    }

    public function updateVideo(array $param) : bool
    {
        if ($param) {
            $video = Video::where('title', $param['title'])->first();
            if ($video && ($video['id'] != $param['id'])) {
                $this->error = '该标题已存在';
                $this->httpCode = HttpCode::CONFLICT;
                return false;
            }
        }
        $save = [
            'title' => $param['title'],
            'video' =>$param['file'],
            'sort' => $param['sort'],
        ];
        $res = Video::where('id', $param['id'])->update($save);
        if (!$res) {
            $this->error = '更新失败';
            $this->httpCode = HttpCode::BAD_REQUEST;
            return false;
        }
        return true;

    }
}
