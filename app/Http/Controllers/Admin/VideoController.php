<?php

namespace App\Http\Controllers\Admin;

use App\Common\Enum\HttpCode;
use App\Model\video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;



class VideoController extends Controller {



    public function videosPage()
    {
        return view('admin.video.videos');
    }
    //获取文章数据
    public function getVideos(Request $request)
    {
        $page =  $request->input('page');
        $limit =  $request->input('limit');
        $where = $request->input('cond') ?? [];
        $offset = ($page - 1) * $limit;
        if ($where) $where = [['title', 'like', $where.'%']];
        $articles = DB::table('videos')
            ->select('id', 'title', 'brief', 'time', 'sort')
            ->where($where)
            ->offset($offset)
            ->limit($limit)
            ->get()->toArray();
        $count = DB::table('videos')->count();
        $res= [
            'count' => $count,
            'data' => $articles
        ];
        return ajaxSuccess($res['data'], $res['count']);
    }

    public function addVideo(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'title' => 'required',
            ]);
            $video = new Video();

            $re = $video->addVideo($request->all());
            if (!$re) return ajaxError($video->getError(), $video->getHttpCode());
            return ajaxSuccess([], '', 'success', HttpCode::CREATED);
        } else {
            return view('admin.video.addvideo');
        }
    }

    public function editVideo(Request $request)
    {
        if ($request->isMethod('put')) {
            $id = $request->input('id');
            $video = new Video();
            $re = $video->updateVideo($request->all(), $id);
            if (!$re) return ajaxError($video->getError(), $video->getHttpCode());
            return ajaxSuccess();
        } else {
            $videos = video::select()->find($request->id);
            return view('admin.video.editvideo', ['videos' => $videos]);
        }
    }


    public function delVideo(Request $request)
    {
        $video = video::find($request->id);
        if (!$video) {
            $this->error = '不存在';
            $this->httpCode = HttpCode::GONE;
            return false;
        }
        $video->delete();
        if (!$video) return ajaxError(getError('删除失败'));
        return ajaxSuccess();
    }


}