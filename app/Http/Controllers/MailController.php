<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Mail;

class MailController extends Controller
{
    public function send()
    {
        $name = 'ѧԺ��';
        $flag = Mail::send('mail.form',['name'=>$name],function($message){
            $to = '706899061@qq.com';
            $message ->to($to)->subject('�����ʼ�');
        });
        if($flag){
            echo '�����ʼ��ɹ�������գ�';
        }else{
            echo '�����ʼ�ʧ�ܣ������ԣ�';
        }
    }
}
