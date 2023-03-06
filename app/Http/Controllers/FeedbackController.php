<?php

namespace App\Http\Controllers;

use App\Models\FormFeedback;
use App\Mail\FeedbackFormFilled;
//use App\Http\Controllers\Traits\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{
//    use Recaptcha;

    public function post(Request $request)
    {
        $result = ['status' => 'ok', 'message' => ''];

//        $result = $this->recaptcha($result, $request->input('recaptcha_response'));

        if ($result['status'] == 'ok') {
            $form = new FormFeedback();
            $form->name = $request->input('name') ?? null;
            $form->phone = $request->input('phone');
            $form->text = $request->input('msg') ?? null;
            $form->page = $request->input('page') ?? null;
            $form->save();

            $mailTo = env('FORM_FEEDBACK_EMAIL_TO', config('mail.to.address'));
            $mailTo = explode(',', $mailTo);
            Mail::to($mailTo)->send(new FeedbackFormFilled($form));
        }

        return $result;
    }
}
