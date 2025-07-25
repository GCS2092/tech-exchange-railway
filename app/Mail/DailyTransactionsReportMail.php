<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DailyTransactionsReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transactions;
    public $orders;
    public $date;

    public function __construct($transactions, $orders, $date)
    {
        $this->transactions = $transactions;
        $this->orders = $orders;
        $this->date = $date;
    }

    public function build()
    {
        return $this->subject('Rapport quotidien des transactions et commandes - ' . $this->date)
            ->view('emails.daily-transactions-report');
    }
} 