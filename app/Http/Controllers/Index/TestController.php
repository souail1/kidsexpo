<?php

namespace App\Http\Controllers\Index;

use App\Events\TestEvent;
use App\Http\Controllers\Controller;
use App\Mail\TestMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Model\Test;
use Illuminate\Support\Facades\Mail;
use App\Jobs\TestJob;



class TestController extends Controller
{
    public function test()
    {
        return view('index.test.form');
    }

    public function testPost(Request $request)
    {
        $test = new Test;
        $name = $request->input('name');
        $test->name = $name;
        $test -> save();
        //触发事件
        event(new TestEvent($test));
        if(!$test){
            return('fail');
        }else{
            return('success');
        }

    }

    public function show(Request $request)
    {
        $id = $request->input('id');
        $test = Test::findOrFail($id);
        //发送邮件
        Mail::to('706899061@qq.com')->send(new TestMail($test));
        return view('index.test.show', ['test' => $test]);
    }
    //测试任务队列
    public function testJob(Request $request)
    {
        // 表示一分钟后执行任务
        $id = $request->input('id');
        $test = Test::findOrFail($id);
        /*$job = (new TestJob($test))->delay(60);
        $this->dispatch($job);*/
        $job = (new TestJob($test))->delay(60 * 5);

        $this->dispatch($job);
    }



}
