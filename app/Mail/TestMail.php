<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Model\Test;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $test;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Test $test)
    {
        $this -> test = $test;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.form')
            ->with([
                'Name' => $this->test->name,
            ]);
    }
}
