<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Event; // Tambahan untuk keamanan mapping model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // WAJIB DIIMPORT
use Illuminate\Support\Facades\Log;  // WAJIB DIIMPORT
use App\Mail\EventTicketMail;         // WAJIB DIIMPORT

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        if (!$orderId) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // Mencari ID transaksi tersebut di database lokal kita dengan eager loading event[cite: 1]
        $transaction = Transaction::with('event')->where('order_id', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Cegah proses berulang dengan konversi huruf kecil agar lebih aman dari case-sensitive[cite: 1]
        $currentStatus = strtolower($transaction->status);
        if ($currentStatus === 'settlement' || $currentStatus === 'success') {
            return response()->json(['message' => 'Already processed']);
        }

        // Logika Penerjemahan Status Midtrans API[cite: 1]
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $transaction->status = 'challenge';
            } else if ($fraudStatus == 'accept') {
                $transaction->status = 'success';
                $this->processSuccess($transaction);
            }
        } else if ($transactionStatus == 'settlement') {
            $transaction->status = 'success'; // Mengubah langsung ke 'success' agar konsisten dengan flow user
            $this->processSuccess($transaction);
        } else if (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $transaction->status = 'failed';
        } else if ($transactionStatus == 'pending') {
            $transaction->status = 'pending';
        }

        $transaction->save();
        return response()->json(['message' => 'OK']);
    }

    private function processSuccess(Transaction $transaction)
    {
        $event = $transaction->event;

        // Jika tiket masih ada dan terhubung dengan data event, kurangi jumlahnya sebanyak 1[cite: 1]
        if ($event && $event->stock > 0) {
            $event->stock = $event->stock - 1;
            $event->save();

            // Mengirimkan email E-Ticket ke pelanggan[cite: 1]
            try {
                Mail::to($transaction->customer_email)->send(new EventTicketMail($transaction));
            } catch (\Exception $e) {
                Log::error('Gagal mengirim email E-Ticket: ' . $e->getMessage());
            }
        } else {
            Log::warning('Stock habis setelah pembayaran berhasil (Perlu proses refund opsional). Order: ' . $transaction->order_id);
        }
    }
}
