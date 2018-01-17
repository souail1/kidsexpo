<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Common\Enum\HttpCode;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    protected $table = 'articles';
    protected $fillable = ['id','title','cate','content','status','author'];

    public function addArticle(array $data) : bool
    {
        $has = Article::where('title', $data['title'])->count();
        if ($has > 0) {
            $this->error = '该标题已存在';
            $this->httpCode = HttpCode::CONFLICT;
            return false;
        }
        DB::beginTransaction();
        $article = Article::create($data);
        if (!$article) {
            $this->error = '添加失败';
            $this->httpCode = HttpCode::BAD_REQUEST;
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;

    }

    public function updateArticle(array $param) : bool
    {
        if ($param) {
            $article = Article::where('title', $param['title'])->first();
            if ($article && ($article['id'] != $param['id'])) {
                $this->error = '该标题已存在';
                $this->httpCode = HttpCode::CONFLICT;
                return false;
            }
        }
        $save = [
            'title' => $param['title'],
            'cate' => $param['cate'],
            //'content' => $param['content'],
            'status' => $param['status'],
        ];
        $res = Article::where('id', $param['id'])->update($save);
        if (!$res) {
            $this->error = '更新失败';
            $this->httpCode = HttpCode::BAD_REQUEST;
            return false;
        }
        return true;

    }

}
