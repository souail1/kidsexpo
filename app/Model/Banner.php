<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Common\Enum\HttpCode;
use Illuminate\Support\Facades\DB;

class Banner extends Model
{
    protected $table = 'banners';
    protected $fillable = ['id','title','file','sort'];

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
}
