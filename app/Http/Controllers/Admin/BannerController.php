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
            ->select('id', 'title', 'img', 'sort', 'created_at', 'updated_at')
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

    public function editBanner(Request $request)
    {
        if ($request->isMethod('put')) {
            $id = $request->input('id');
            $banner = new banner();
            $re = $banner->updateBanner($request->all(), $id);
            if (!$re) return ajaxError($banner->getError(), $banner->getHttpCode());
            return ajaxSuccess();
        } else {
            $banners = Banner::select()->find($request->id);
            return view('admin.banner.editbanner', ['banners' => $banners]);
        }
    }


    public function delBanner(Request $request)
    {
        $banner = Banner::find($request->id);
        if (!$banner) {
            $this->error = '不存在';
            $this->httpCode = HttpCode::GONE;
            return false;
        }
        $banner->delete();
        if (!$banner) return ajaxError(getError('删除失败'));
        return ajaxSuccess();
    }


}