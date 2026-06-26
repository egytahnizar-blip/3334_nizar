<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function create(Event $event)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = \App\Models\Category::all();

        return view('checkout.create', compact('event', 'categories'));
    }

    public function store(Request $request, Event $event)
    {
       // 1. Validasi Input Kredensial Pelanggan
    $request->validate([
        'customer_name' => 'required|string|max:255',
        'customer_email' => 'required|email|max:255',
        'customer_phone' => 'required|string|max:20',
    ]);

    // 2. Cegah Check-out Jika Tiket Habis
    if ($event->stock <= 0) {
        return back()->with('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');
    }

    // 3. Generate Kode TRX (Unik)
    $orderId = 'TRX-' . time() . '-' . Str::random(5);
    $totalPrice = $event->price + 5000;

    // Simpan data transaksi awal (Pending) ke database
    $transaction = Transaction::create([
        'event_id' => $event->id,
        'order_id' => $orderId,
        'customer_name' => $request->customer_name,
        'customer_email' => $request->customer_email,
        'customer_phone' => $request->customer_phone,
        'total_price' => $totalPrice,
        'status' => 'Pending',
    ]);

        // Konfigurasi Kredensial Environment Midtrans
        // Konfigurasi Kredensial Environment Midtrans
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Susun Paket Array Data Transaksi
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone,
            ],
        ];

        try {
            // Perintah Tembak Generate Snap Token
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Update rekaman kita bahwa transaksi terkait sudah memiliki id token pelunasan
            $transaction->update(['snap_token' => $snapToken]);

            // Redirect ke halaman antarmuka pembayaran final pelanggan
            return redirect()->route('checkout.payment', $transaction->order_id);

        } catch (\Exception $e) {
            // Hapus data transaksi jika gagal mendapatkan token pembayaran
            if (isset($transaction)) {
                $transaction->delete();
            }
            return back()->with('error', 'Gagal memproses pembayaran jaringan: ' . $e->getMessage());
        }
    }

    public function payment($order_id)
    {
         // Mengambil daftar kategori untuk keperluan menu footer
         $categories = \App\Models\Category::all();

         $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
         return view('checkout.payment', compact('transaction','categories'));
    }

    public function success($order_id)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
         $categories = \App\Models\Category::all();

         $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();

         // Validasi status pembayaran asli dari Midtrans (Mencegah manipulasi URL)
         \Midtrans\Config::$serverKey = config('midtrans.serverKey');
         \Midtrans\Config::$isProduction = config('midtrans.isProduction');

         try {

             $midtransStatus = \Midtrans\Transaction::status($order_id);

            // Ambil nilai status dengan aman (mengantisipasi balasan berupa Object maupun Array)
            $trx_status = is_array($midtransStatus) ? ($midtransStatus['transaction_status'] ?? '') : ($midtransStatus->transaction_status ?? '');

            // Hanya ubah status menjadi sukses jika Midtrans mengonfirmasi pembayaran lunas
            if (in_array($trx_status, ['capture', 'settlement'])) {
                if ($transaction->status !== 'success') {
                    $transaction->update(['status' => 'success']);
                    $transaction->event->decrement('stock');
                }
            }
         } catch (\Exception $e) {
             // Jika error (transaksi tidak ada di Midtrans, koneksi terputus), kembalikan ke beranda
             return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan atau gagal diproses oleh sistem pembayaran.');
         }

         return view('checkout.success', compact('transaction','categories'));
    }
}
