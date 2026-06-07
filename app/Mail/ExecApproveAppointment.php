<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExecApproveAppointment extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Public variable to hold the user name.
     *
     * @var string
     */
    public $campexeName;
    public $userName;
    
    /**
     * Create a new message instance.
     *
     * @param string $campexeName
     * @param string $userName
     */

    public function __construct($campexeName,$userName)
    {
        $this->campexeName = $campexeName;
        $this->userName = $userName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Sensor application appointment confirmed')
                    ->view('emails.campexe.approve_appointment_notification');
    }
}
