<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'order']);

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('min_amount')) {
            $query->where('amount', '>=', $request->min_amount);
        }

        if ($request->filled('max_amount')) {
            $query->where('amount', '<=', $request->max_amount);
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $transactions = $query->paginate(20);

        // Statistiques
        $stats = $this->getTransactionStats($request);

        return view('admin.transactions.index', compact('transactions', 'stats'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'order.products', 'order.livreur']);
        
        return view('admin.transactions.show', compact('transaction'));
    }

    public function create()
    {
        $orders = Order::whereDoesntHave('transactions')->get();
        $users = User::all();
        
        return view('admin.transactions.create', compact('orders', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'status' => 'required|in:pending,completed,failed,refunded',
            'description' => 'nullable|string',
            'transaction_id' => 'nullable|string|unique:transactions',
        ]);

        try {
            DB::beginTransaction();

            $transaction = Transaction::create([
                'order_id' => $request->order_id,
                'user_id' => $request->user_id,
                'amount' => $request->amount,
                'currency' => $request->currency ?? 'XOF',
                'payment_method' => $request->payment_method,
                'status' => $request->status,
                'transaction_id' => $request->transaction_id,
                'description' => $request->description,
                'metadata' => $request->metadata ?? [],
                'processed_at' => $request->status === 'completed' ? now() : null,
            ]);

            // Si la transaction est complétée, marquer la commande comme payée
            if ($request->status === 'completed') {
                $order = Order::find($request->order_id);
                $order->markAsPaid();
            }

            DB::commit();

            Log::info("Transaction créée", [
                'transaction_id' => $transaction->id,
                'order_id' => $transaction->order_id,
                'amount' => $transaction->amount,
                'created_by' => auth()->id()
            ]);

            return redirect()->route('admin.transactions.index')
                ->with('success', 'Transaction créée avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erreur lors de la création de la transaction", [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return back()->with('error', 'Erreur lors de la création de la transaction')
                ->withInput();
        }
    }

    public function edit(Transaction $transaction)
    {
        $orders = Order::all();
        $users = User::all();
        
        return view('admin.transactions.edit', compact('transaction', 'orders', 'users'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'status' => 'required|in:pending,completed,failed,refunded',
            'description' => 'nullable|string',
            'transaction_id' => 'nullable|string|unique:transactions,transaction_id,' . $transaction->id,
        ]);

        try {
            DB::beginTransaction();

            $oldStatus = $transaction->status;
            $oldAmount = $transaction->amount;

            $transaction->update([
                'order_id' => $request->order_id,
                'user_id' => $request->user_id,
                'amount' => $request->amount,
                'currency' => $request->currency ?? 'XOF',
                'payment_method' => $request->payment_method,
                'status' => $request->status,
                'transaction_id' => $request->transaction_id,
                'description' => $request->description,
                'metadata' => $request->metadata ?? $transaction->metadata,
                'processed_at' => $request->status === 'completed' ? now() : null,
            ]);

            // Gérer les changements de statut
            if ($oldStatus !== $request->status) {
                $this->handleStatusChange($transaction, $oldStatus, $request->status);
            }

            DB::commit();

            Log::info("Transaction mise à jour", [
                'transaction_id' => $transaction->id,
                'old_status' => $oldStatus,
                'new_status' => $request->status,
                'old_amount' => $oldAmount,
                'new_amount' => $request->amount,
                'updated_by' => auth()->id()
            ]);

            return redirect()->route('admin.transactions.index')
                ->with('success', 'Transaction mise à jour avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erreur lors de la mise à jour de la transaction", [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Erreur lors de la mise à jour de la transaction')
                ->withInput();
        }
    }

    public function destroy(Transaction $transaction)
    {
        try {
            $transactionId = $transaction->id;
            $transaction->delete();

            Log::warning("Transaction supprimée", [
                'transaction_id' => $transactionId,
                'deleted_by' => auth()->id()
            ]);

            return redirect()->route('admin.transactions.index')
                ->with('success', 'Transaction supprimée avec succès');

        } catch (\Exception $e) {
            Log::error("Erreur lors de la suppression de la transaction", [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Erreur lors de la suppression de la transaction');
        }
    }

    public function markAsCompleted(Transaction $transaction)
    {
        try {
            DB::beginTransaction();

            $transaction->markAsCompleted();
            
            // Marquer la commande comme payée
            $order = $transaction->order;
            $order->markAsPaid();

            DB::commit();

            Log::info("Transaction marquée comme complétée", [
                'transaction_id' => $transaction->id,
                'order_id' => $order->id,
                'marked_by' => auth()->id()
            ]);

            return back()->with('success', 'Transaction marquée comme complétée');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erreur lors du marquage de la transaction", [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Erreur lors du marquage de la transaction');
        }
    }

    public function markAsFailed(Transaction $transaction)
    {
        try {
            $transaction->markAsFailed();

            Log::info("Transaction marquée comme échouée", [
                'transaction_id' => $transaction->id,
                'marked_by' => auth()->id()
            ]);

            return back()->with('success', 'Transaction marquée comme échouée');

        } catch (\Exception $e) {
            Log::error("Erreur lors du marquage de la transaction", [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Erreur lors du marquage de la transaction');
        }
    }

    public function markAsRefunded(Transaction $transaction)
    {
        try {
            DB::beginTransaction();

            $transaction->markAsRefunded();
            
            // Marquer la commande comme remboursée
            $order = $transaction->order;
            $order->markAsRefunded();

            DB::commit();

            Log::info("Transaction marquée comme remboursée", [
                'transaction_id' => $transaction->id,
                'order_id' => $order->id,
                'marked_by' => auth()->id()
            ]);

            return back()->with('success', 'Transaction marquée comme remboursée');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erreur lors du remboursement de la transaction", [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Erreur lors du remboursement de la transaction');
        }
    }

    public function export(Request $request)
    {
        $query = Transaction::with(['user', 'order']);

        // Appliquer les mêmes filtres que dans index()
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->get();

        // Générer le CSV
        $filename = 'transactions_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            
            // En-têtes
            fputcsv($file, [
                'ID', 'Commande', 'Client', 'Montant', 'Devise', 'Méthode', 
                'Statut', 'Date', 'Description'
            ]);

            // Données
            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->id,
                    $transaction->order_id,
                    $transaction->user->name,
                    $transaction->amount,
                    $transaction->currency,
                    $transaction->payment_method,
                    $transaction->status_label,
                    $transaction->created_at->format('d/m/Y H:i'),
                    $transaction->description,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getTransactionStats(Request $request)
    {
        $query = Transaction::query();

        // Appliquer les mêmes filtres
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return [
            'total_transactions' => $query->count(),
            'total_amount' => $query->sum('amount'),
            'completed_transactions' => $query->where('status', 'completed')->count(),
            'completed_amount' => $query->where('status', 'completed')->sum('amount'),
            'pending_transactions' => $query->where('status', 'pending')->count(),
            'failed_transactions' => $query->where('status', 'failed')->count(),
            'refunded_transactions' => $query->where('status', 'refunded')->count(),
            'refunded_amount' => $query->where('status', 'refunded')->sum('amount'),
        ];
    }

    private function handleStatusChange(Transaction $transaction, $oldStatus, $newStatus)
    {
        $order = $transaction->order;

        switch ($newStatus) {
            case 'completed':
                if ($oldStatus !== 'completed') {
                    $order->markAsPaid();
                }
                break;
                
            case 'refunded':
                if ($oldStatus !== 'refunded') {
                    $order->markAsRefunded();
                }
                break;
        }
    }
}
