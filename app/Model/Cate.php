<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use App\Common\Enum\HttpCode;
use Illuminate\Support\Facades\DB;

class Cate extends Model
{
    protected $fillable = ['id','title','pid','sort','status','level'];

    public function article()
    {
        return $this->hasMany('App\Model\Article', 'cate', 'id');
    }

    /**
     * 获取栏目数据
     * @return array
     */
    public function getCatesSelector()
    {
        $rules = $this
            ->orderBy('sort', 'asc')
            ->select('id', 'title', 'pid', 'level')
            ->get()->toArray();
        return $this->tree($rules);
    }

    /**
     * 获取所有栏目
     * @param string $field
     * @return array
     */
    public function getCates()
    {
        $cates = $this
            ->orderBy('sort', 'asc')
            ->get()->toArray();
        return $this->tree($cates);
    }


    public function tree($data , $lefthtml = '|— ' , $pid=0 , $lvl=0)
    {
        $arr = [];
        foreach ($data as $k => $v) {
            if ($v['pid'] == $pid) {
                $v['ltitle'] = str_repeat($lefthtml, $lvl) . $v['title'];
                $arr[] = $v;
                unset($data[$k]);
                $arr = array_merge($arr, $this->tree($data, $lefthtml, $v['id'], $lvl + 1));
            }
        }

        return $arr;
    }

    public function addCate(array $data) : bool
    {
        $has = Article::where('title', $data['title'])->count();
        if ($has > 0) {
            $this->error = '该栏目已存在';
            $this->httpCode = HttpCode::CONFLICT;
            return false;
        }
        DB::beginTransaction();
        $cate = Cate::create($data);
        if (!$cate) {
            $this->error = '添加失败';
            $this->httpCode = HttpCode::BAD_REQUEST;
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;

    }

    public function updateCate(array $param) : bool
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
            'pid' => $param['pid'],
            //'content' => $param['content'],
            //'status' => $param['status'],
        ];
        $res = Cate::where('id', $param['id'])->update($save);
        if (!$res) {
            $this->error = '更新失败';
            $this->httpCode = HttpCode::BAD_REQUEST;
            return false;
        }
        return true;

    }


}
