<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExecNewBookingAppointment extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Public variable to hold the user name.
     *
     * @var string
     */
    public $campexeName;
    public $userName;
    public $scheduledate;
    public $scheduleday;
    public $scheduletiming;
    
    /**
     * Create a new message instance.
     *
     * @param string $campexeName
     * @param string $userName
     * @param string $scheduledate
     * @param string $scheduleday
     * @param string $scheduletiming
     */

    public function __construct($campexeName,$userName, $scheduledate, $scheduleday, $scheduletiming)
    {
        $this->campexeName = $campexeName;
        $this->userName = $userName;
        $this->scheduledate = $scheduledate;
        $this->scheduleday = $scheduleday;
        $this->scheduletiming = $scheduletiming;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Appointment Booking Notification')
                    ->view('emails.campexe.new_appointment_notification');
    }
}
