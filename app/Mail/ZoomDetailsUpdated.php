<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ZoomDetailsUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $registrationItem;


    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Registration  $registrationItem
     * @return void
     */
    public function __construct($registrationItem)
    {
        $this->registrationItem = $registrationItem;

    }

   /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
             
        return $this->subject('Aravind EyeCare Zoom Meet Details for Doctor Interaction')
            ->view('emails.zoom_details_updated')
            ->with([
                'appointment_date' => $this->registrationItem->appointment_date,
                'appointment_time' => $this->registrationItem->appointment_time,
                'zoom_details' => $this->registrationItem->zoom_details,
            ]);
    }
}