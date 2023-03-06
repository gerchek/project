<?php

namespace App\Http\Controllers;

use App\Models\FormReview;
use App\Mail\ReviewFormFilled;
//use App\Http\Controllers\Traits\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReviewController extends Controller
{
//    use Recaptcha;

    public function post(Request $request)
    {
        $result = ['status' => 'ok', 'message' => ''];

//        $result = $this->recaptcha($result, $request->input('recaptcha_response'));

        if ($result['status'] == 'ok') {
            $form = new FormReview();
            $form->name = $request->input('name');
            $form->phone = $request->input('phone');
            $form->text = $request->input('msg');
            $form->save();

            $mailTo = env('FORM_REVIEW_EMAIL_TO', config('mail.to.address'));
            $mailTo = explode(',', $mailTo);
            Mail::to($mailTo)->send(new ReviewFormFilled($form));
        }

        return $result;
    }
}