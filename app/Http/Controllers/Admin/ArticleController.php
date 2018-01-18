<?php

namespace App\Http\Controllers\Admin;

use App\Common\Enum\HttpCode;
use App\Model\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;



class ArticleController extends Controller
{
    /*public function __construct()
    {

    }*/

    public function articlesPage()
    {
        return view('admin.article.articles');
    }
    //获取文章数据
    public function getArticles(Request $request)
    {
        $page =  $request->input('page');
        $limit =  $request->input('limit');
        $where = $request->input('cond') ?? [];
        $offset = ($page - 1) * $limit;
        if ($where) $where = [['title', 'like', $where.'%']];
        $articles = DB::table('articles')
            ->select('id', 'title', 'content', 'cate', 'created_at', 'updated_at','status')
            ->where($where)
            ->offset($offset)
            ->limit($limit)
            ->get()->toArray();
        $count = DB::table('articles')->count();
        $res= [
            'count' => $count,
            'data' => $articles
        ];
        return ajaxSuccess($res['data'], $res['count']);
    }

    public function addArticle(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'title' => 'required',
            ]);
            $Article = new Article();
            $re = $Article->addArticle($request->all());
            if (!$re) return ajaxError($Article->getError(), $Article->getHttpCode());
            return ajaxSuccess([], '', 'success', HttpCode::CREATED);
        } else {
            return view('admin.article.addArticle');
        }
    }

    public function editArticle(Request $request)
    {
        if ($request->isMethod('put')) {
            $id = $request->input('id');
            $article = new article();
            $re = $article->updateArticle($request->all(), $id);
            if (!$re) return ajaxError($article->getError(), $article->getHttpCode());
            return ajaxSuccess();
        } else {
            $articles = Article::select()->find($request->id);
            return view('admin.article.editArticle', ['articles' => $articles]);
        }
    }


    public function activeArticle(Request $request)
    {
        $re = Article::where('id', $request->id)->update(['status' => $request->status]);
        if (!$re) return ajaxError('发布失败', HttpCode::BAD_REQUEST);
        return ajaxSuccess();
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
