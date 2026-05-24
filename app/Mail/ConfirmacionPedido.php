<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class ConfirmacionPedido extends Mailable
{
    use Queueable, SerializesModels;


    //el contructor que recibe al orden y mailable serializa
    public function __construct(public Order $order){}


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: " ¡Tu pedido #{$this->order->id} está confirmado! — AlvGluten",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.confirmacion-pedido',
            // Las variables que pasen al template automáticamente
            with: [
                'order'    => $this->order->load('items', 'user'),
                'userName' => $this->order->user->name,
        ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
