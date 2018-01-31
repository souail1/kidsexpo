<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\Model\Test;
use Illuminate\Contracts\Mail\Mailer;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $test;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Test $test)
    {
        $this->test = $test;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $test = $this->test;
        $mailer->send('mail.form',['test'=>$test],function($message) use ($test){
            $message->to($test->email)->subject('邮件测试');
        });
    }
}
