<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaction;
use App\Models\Order;
use App\Mail\DailyTransactionsReportMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class SendDailyTransactionsReport extends Command
{
    protected $signature = 'report:transactions-daily';
    protected $description = 'Envoie le rapport quotidien des transactions et commandes par email à l\'admin';

    public function handle()
    {
        $date = now()->format('d/m/Y');
        $start = now()->startOfDay();
        $end = now()->endOfDay();

        $transactions = Transaction::with('user')->whereBetween('created_at', [$start, $end])->get();
        $orders = Order::with('user')->whereBetween('created_at', [$start, $end])->get();

        $to = Config::get('mail.admin_address', 'admin@localhost');

        Mail::to($to)->send(new DailyTransactionsReportMail($transactions, $orders, $date));

        $this->info('Rapport quotidien envoyé à ' . $to . ' (' . $transactions->count() . ' transactions, ' . $orders->count() . ' commandes)');
        return 0;
    }
} 