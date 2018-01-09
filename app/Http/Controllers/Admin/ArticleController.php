<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $articles = DB::table('articles')->get();
        return view('admin.article.list', ['articles' => $articles]);
    }
}
