<?php

namespace App\Http\Controllers\Index;

use App\Events\TestEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Test;


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
        //´¥·¢ÊÂ¼ş
        event(new TestEvent($test));
        if(!$test){
            return('fail');
        }else{
            return('success');
        }

    }

}
