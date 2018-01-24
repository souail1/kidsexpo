<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Common\Enum\HttpCode;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    protected $table = 'articles';
    protected $fillable = ['id','title','cate', 'type','content','status','author'];

    public function cate()
    {
        return $this->belongsTo('App\Model\Cate', 'cate', 'id');
    }


    public function addArticle(array $data) : bool
    {
        $has = Article::where('title', $data['title'])->count();
        if ($has > 0) {
            $this->error = '该标题已存在';
            $this->httpCode = HttpCode::CONFLICT;
            return false;
        }
        $language = session('applocale');
        if ($language == 'en'){
            $data['language'] = 2;
        }else{
            $data['language'] = 1;
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
            'content' => $param['content'],
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

    //单页管理
    public function getSinglePage()
    {
        $articles = Article::where('type', 2)
            ->select('id', 'title')
            ->get();
        $res = array();
        foreach($articles as $v)
        {
            $res[$v['id']]=$v['title'];
        }
        return $res;
    }


}
