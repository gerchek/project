<?php

namespace App\Http\Controllers\Traits;

trait Recaptcha
{
    public function recaptcha(&$result, $recaptchaResponse)
    {
        $recaptchaSecret = env('RECAPTCHA_SECRET_KEY');
        $recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$recaptchaSecret.'&response='.$recaptchaResponse);
        $recaptcha = json_decode($recaptcha);

        if (!$recaptcha->success || $recaptcha->score < 0.5) {
            $result['status'] = 'error';
            $result['message'] = 'Ошибка проверки Recaptcha';
            if (env('APP_DEBUG')) {
                $result['answer'] = $recaptcha;
            }
        }

        return $result;
    }
}
