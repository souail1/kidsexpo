<?php

namespace App\Http\Controllers\Index;

use App\Events\TestEvent;
use App\Http\Controllers\Controller;
use App\Mail\TestMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Model\Test;
use Illuminate\Support\Facades\Mail;
use App\Jobs\InsertJob;



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
        //�����¼�
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
        //�����ʼ�
        Mail::to('706899061@qq.com')->send(new TestMail($test));
        return view('index.test.show', ['test' => $test]);
    }
    //�����������
    public function testJob(Request $request)
    {
        // ��ʾһ���Ӻ�ִ������
        $id = $request->input('id');
        $test = Test::findOrFail($id);
        $job = (new InsertJob($test))->delay(600);
        $this->dispatch($job);
    }

}
