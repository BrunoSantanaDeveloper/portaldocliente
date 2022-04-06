<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailOrders extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build($nota)
    {
        $data['nf'] = $nota;
        $data['name'] = 'cliente teste';

        //return $this->view('mails.orders');
        Mail::send('mails.orders', $data, function ($message) {
            $message->from('noreply@portaldocliente.las.app.br', 'LOGÍSTICA - LAS');
            $message->sender('noreply@portaldocliente.las.app.br', 'LOGÍSTICA - LAS');
            $message->to('bsantana.it@gmail.com', 'Bruno Santana');
            $message->subject('Pedido Aprovado');
            $message->priority(1);
        });
    }
}
