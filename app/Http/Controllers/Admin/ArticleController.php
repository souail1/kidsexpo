<?php

namespace App\Http\Controllers\Admin;

use App\Model\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /*public function __construct()
    {

    }*/

    public function index()
    {
        return view('admin.article.list');
    }
    //获取文章数据
    public function getArticle(Request $request)
    {
        $page =  $request->input('page');
        $limit =  $request->input('limit');
        $where = $request->input('cond') ?? [];
        $offset = ($page - 1) * $limit;
        if ($where) $where = [['title', 'like', $where.'%']];
        $articles = DB::table('articles')
            ->select('id', 'title', 'author', 'cate', 'status')
            ->where($where)
            ->offset($offset)
            ->limit($limit)
            ->get()->toArray();
        $count = count($articles);
        $res= [
            'count' => $count,
            'data' => $articles
        ];
        return ajaxSuccess($res['data'], $res['count']);
    }

    /**
     * 创建新文章表单页面
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.article.add');
    }

    /**
     * 将新创建的文章存储到存储器
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
        ]);
        $article = new Article;
        $article->title = $request->input('title');
        $article->content = $request->input('content');
        $article->cate = $request->input('cate');
        $article->status = $request->input('status');
        $article->save();
        return ajaxSuccess();
    }

    /**
     * 显示指定文章
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 显示编辑指定文章的表单页面
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $article = DB::table('articles')
            ->select('id', 'title', 'author', 'cate', 'status')
            ->where('id', $id)
            ->get();
        return view('admin.article.edit', ['article' => $article]);

    }

    /**
     * 在存储器中更新指定文章
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $data = $request->input();
        $article = new Article();
        $article->save();
        return ajaxSuccess();

    }

    /**
     * 从存储器中移除指定文章
     *
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $article = DB::table('users')->where('id', '=', $id)->delete();
        return ajaxSuccess();
    }
}
