<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $notifiable;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($notifiable)
    {
        $this->notifiable = $notifiable;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $generalSettings = getGeneralSettings();
        $subject = trans('auth.email_confirmation');

        $confirm = [
            'title' => $subject.' '.trans('auth.in').' '.$generalSettings['site_name'],
            'message' => trans('auth.email_confirmation_template_body',
                ['email' => $this->notifiable['email'], 'site' => $generalSettings['site_name']]),
            'code' => $this->notifiable['code']
        ];


        return $this->subject($subject)->view('verify-email');
//            ->from(!empty($generalSettings['site_email']) ? $generalSettings['site_email'] : env('MAIL_FROM_ADDRESS'),
//                env('MAIL_FROM_NAME'))
//            ->view('web.default.emails.confirmCode', [
//                'confirm' => $confirm,
//                'generalSettings' => $generalSettings
//            ]);
    }
}