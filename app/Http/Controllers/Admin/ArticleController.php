<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Model\Article;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function articlesPage()
    {
        return view('admin.article.list');
    }

    public function getArticles(Request $request)
    {
        $page = $request['page'];
        $limit = $request['limit'];
        $sortfield = $request['sortField'] ?? 'id';
        $order = $request['order'] ?? 'asc';
        $offset = ($page - 1) * $limit;
        $where = ['title', 'like'];
        $articles = DB::table('articles')
            ->where($where)
            ->select('id', 'title', 'author', 'cate_id', 'created_at', 'updated_at')
            ->offset($offset)
            ->limit($limit)
            ->orderBy($sortfield, $order)
            ->get();
        $count = count($articles);
        return [
            'count' => $count,
            'data' => $articles
        ];
    }
}
