<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;
use App\Models\User;

class DailyLowStockReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $products;
    public $admin;
    public $totalProducts;
    public $criticalProducts; // Produits en rupture (stock = 0)
    public $lowStockProducts; // Produits avec stock faible mais > 0

    /**
     * Create a new message instance.
     */
    public function __construct($products, User $admin)
    {
        $this->products = $products;
        $this->admin = $admin;
        $this->totalProducts = $products->count();
        
        // Séparer les produits critiques des produits en stock faible
        $this->criticalProducts = $products->where('quantity', 0);
        $this->lowStockProducts = $products->where('quantity', '>', 0);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $criticalCount = $this->criticalProducts->count();
        $subject = $criticalCount > 0 
            ? "🚨 RAPPORT QUOTIDIEN - {$criticalCount} produit(s) en RUPTURE + {$this->lowStockProducts->count()} en stock faible"
            : "📊 RAPPORT QUOTIDIEN - {$this->totalProducts} produit(s) en stock faible";

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            htmlString: view('emails.admin.daily-low-stock-report', [
                'products' => $this->products,
                'admin' => $this->admin,
                'totalProducts' => $this->totalProducts,
                'criticalProducts' => $this->criticalProducts,
                'lowStockProducts' => $this->lowStockProducts,
            ])->render(),
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
