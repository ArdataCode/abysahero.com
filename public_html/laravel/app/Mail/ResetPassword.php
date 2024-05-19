<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Template;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;
    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template = Template::where('id','<>','~')->first();
        $namaserver = $_SERVER['SERVER_NAME'];
        return $this->from($template->email)
        ->view('email/resetpassword')
        ->with(
         [
            'nama' => $this->data['nama'],
            'email' => $this->data['email'],
             'password' => $this->data['password'],
             'namaweb' => $template->nama,
             'emailweb' => $template->email,
             'namaserver' => $namaserver
         ]);
    }
}
