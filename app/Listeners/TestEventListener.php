<?php

namespace App\Listeners;

use App\Events\TestEvent;
use Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TestEvent  $event
     * @return void
     */
    public function handle(TestEvent $event)
    {
        $test = $event->test;
        $key = 'test_'.$test->id;
        Log::info('测试事件成功',['id'=>$test->id]);
    }
}
