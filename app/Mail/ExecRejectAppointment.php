<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExecRejectAppointment extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Public variable to hold the user name.
     *
     * @var string
     */
    public $userName;
    public $campexe_remarks;
    
    /**
     * Create a new message instance.
     *
     * @param string $userName
     * @param string $campexe_remarks
     */

    public function __construct($userName,$campexe_remarks)
    {
        $this->userName = $userName;
        $this->campexe_remarks = $campexe_remarks;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Appointment Booking Rejected Notification')
                    ->view('emails.campexe.reject_appointment_notification');
    }
}
