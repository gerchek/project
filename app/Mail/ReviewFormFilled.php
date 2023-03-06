<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\FormReview;

class ReviewFormFilled extends Mailable
{
	use Queueable, SerializesModels;

	public $form;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(FormReview $form)
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

		$this->subject('Заполнена форма «Оставить отзыв»');
		$this->from($from, env('MAIL_FROM_NAME', config('mail.from.name')));
		$this->view('mails.review_form_filled');

		return $this;
	}
}
