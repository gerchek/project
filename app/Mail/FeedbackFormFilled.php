<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\FormFeedback;

class FeedbackFormFilled extends Mailable
{
	use Queueable, SerializesModels;

	public $form;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(FormFeedback $form)
	{
        $this->form = $form;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$from = env('MAIL_FROM_ADDRESS', config('mail.from.address'));

		$this->subject('Заполнена форма «Связаться с нами»');
		$this->from($from, env('MAIL_FROM_NAME', config('mail.from.name')));
		$this->view('mails.feedback_form_filled');

		return $this;
	}
}
