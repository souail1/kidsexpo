<?php

namespace App\Http\Controllers\Admin;

use App\Common\Enum\HttpCode;
use App\Model\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;



class BannerController extends Controller {



    public function bannersPage()
    {
        return view('admin.banner.banners');
    }
    //获取文章数据
    public function getBanners(Request $request)
    {
        $page =  $request->input('page');
        $limit =  $request->input('limit');
        $where = $request->input('cond') ?? [];
        $offset = ($page - 1) * $limit;
        if ($where) $where = [['title', 'like', $where.'%']];
        $articles = DB::table('banners')
            ->select('id', 'title', 'file', 'sort', 'created_at', 'updated_at')
            ->where($where)
            ->offset($offset)
            ->limit($limit)
            ->get()->toArray();
        $count = DB::table('banners')->count();
        $res= [
            'count' => $count,
            'data' => $articles
        ];
        return ajaxSuccess($res['data'], $res['count']);
    }

    public function addBanner(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'title' => 'required',
            ]);
            $Banner = new Banner();

            $re = $Banner->addBanner($request->all());
            if (!$re) return ajaxError($Banner->getError(), $Banner->getHttpCode());
            return ajaxSuccess([], '', 'success', HttpCode::CREATED);
        } else {
            return view('admin.banner.addBanner');
        }
    }

    public function editArticle(Request $request)
    {
        if ($request->isMethod('put')) {
            $this->validate($request, [
                'title' => 'required'
            ]);
            $article = new Article;
            $article->title = $request->input('title');
            $article->content = $request->input('content');
            $article->cate = $request->input('cate');
            $article->status = $request->input('status');
            $article->update();
            if (!$article) return ajaxError('编辑失败');
            return ajaxSuccess();
        } else {
            $articles = Article::select()->find($request->id)->toArray();
            return view('admin.article.editArticle', ['articles' => $articles]);
        }
    }


    public function delArticle(Request $request)
    {
        $article = Article::find($request->id);
        if (!$article) {
            $this->error = '用户不存在';
            $this->httpCode = HttpCode::GONE;
            return false;
        }
        $article->delete();
        if (!$article) return ajaxError(getError('删除失败'));
        return ajaxSuccess();
    }


}