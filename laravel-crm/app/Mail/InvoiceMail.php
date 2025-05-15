<?php
  namespace App\Mail;

  use App\Models\Invoice;
  use Illuminate\Bus\Queueable;
  use Illuminate\Mail\Mailable;
  use Illuminate\Mail\Mailables\Content;
  use Illuminate\Mail\Mailables\Envelope;
  use Illuminate\Queue\SerializesModels;

  class InvoiceMail extends Mailable
  {
      use Queueable, SerializesModels;

      public $invoice;

      public function __construct(Invoice $invoice)
      {
          $this->invoice = $invoice;
      }

      public function envelope(): Envelope
      {
          return new Envelope(
              subject: 'Invoice #' . $this->invoice->invoice_number,
          );
      }

      public function content(): Content
      {
          return new Content(
              view: 'emails.invoice',
          );
      }

      public function attachments(): array
      {
          return [];
      }
  }