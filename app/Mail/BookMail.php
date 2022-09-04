<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookMail extends Mailable
{
    use Queueable, SerializesModels;


    public $trip_name;
    public $email;
    public $date;
    public $size;
    public $Passengers_number;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($trip_name,$email,$date,$size,$Passengers_number)
    {
        $this->trip_name = $trip_name;
        $this->email = $email;
        $this->date = $date;
        $this->size = $size;
        $this->Passengers_number = $Passengers_number;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.book');
    }
}
