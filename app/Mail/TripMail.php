<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TripMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $flight_number;
    public $date;
    public $size;
    public $name_on_board;
    public $Passengers_number;
    public $too;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,$flight_number,$date,$size,$name_on_board,$Passengers_number,$too)
    {
        $this->email = $email;
        $this->flight_number = $flight_number;
        $this->date = $date;
        $this->size = $size;
        $this->name_on_board = $name_on_board;
        $this->Passengers_number = $Passengers_number;
        $this->too = $too;
        // $this->from2 = $from2;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.trip');
    }
}
