<?php
/**
 * Created by PhpStorm.
 * User: ToxicBoiz
 * Date: 12/19/2018
 * Time: 11:34 PM
 */

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $resetPassword;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$resetPassword)
    {
        $this->user = $user;
        $this->resetPassword = $resetPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.reminder');
    }

}