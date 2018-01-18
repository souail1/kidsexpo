<?php

namespace App\Http\Controllers\Admin;

use App\Common\Enum\HttpCode;
use App\Http\Controllers\Controller;
use App\Model\Cate;
use Illuminate\Http\Request;

class CateController extends Controller
{
    /**
     * 权限列表页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cates()
    {
        $cateModel = new Cate();
        $cates = $cateModel->getCates();
        return view('admin.cate.cates', ['cates' => $cates]);

    }

    /**
     * 添加权限
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addCate(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'title' => 'required',
            ]);
            $cate = new Cate();
            $re = $cate->addcate($request->all());
            if (!$re) return ajaxError($cate->getError(), $cate->getHttpCode());
            return ajaxSuccess([], '', 'success', HttpCode::CREATED);

        } else {
            $cateModel = new cate();
            $cates = $cateModel->getcatesSelector();
            return view('admin.cate.addcate', ['cates' => $cates]);
        }
    }

    /**
     * 编辑权限
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editCate(Request $request)
    {
        if ($request->isMethod('put')) {
            $this->validate($request, [
                'title' => 'required',
            ]);
            $cateService = new Cate();
            $re = $cateService->updateCate($request->all());
            if (!$re) return ajaxError($cateService->getError(), $cateService->getHttpCode());
            return ajaxSuccess();
        } else {
            $cate = cate::find($request->id);
            $cates = (new cate())->getCatesSelector();
            return view('admin.cate.editcate', ['cate' => $cate, 'cates' => $cates]);
            /*return (['cate' => $cate, 'cates' => $cates]);*/
        }
    }

    public function editCateStatus(Request $request)
    {
        $re = Cate::where('id', $request->id)->update([$request->key => $request->val]);
        if (!$re) return ajaxError('修改失败', HttpCode::BAD_REQUEST);
        return ajaxSuccess();
    }

    /**
     * 删除权限
     * @param Request $request
     * @return array
     */
    public function deletecate(Request $request, cateService $cateService)
    {
        $re = $cateService->deletecate($request->id);
        if (!$re) return ajaxError($cateService->getError(), $cateService->getHttpCode());
        return ajaxSuccess();
    }

}
