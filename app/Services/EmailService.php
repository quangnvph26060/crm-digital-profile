<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function verifyEmail($email, $token)
    {
        try {
            Mail::send('emails.verify', ['token' => $token], function($message) use ($email) {
                $message->to($email)
                        ->subject('Xác thực Email');
            });

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function forgetPassword($email, $token, $title)
    {
        try {
            Mail::send('emails.forget_password', ['token' => $token], function($message) use ($email, $title) {
                $message->to($email)
                        ->subject($title);
            });

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}