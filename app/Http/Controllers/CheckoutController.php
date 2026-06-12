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
        $categories = \App\Models\Category::all();
        return view('checkout.create', compact('event','categories'));
    }

    public function store(Request $request, Event $event)
    {
        // 1. Validasi Input
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        // 2. Cegah Check-out Jika Tiket Habis
        if ($event->stock <= 0) {
            return back()->with('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');
        }

        // 3. Generate Data
        $orderId = 'TRX-' . time() . '-' . Str::random(5);
        $totalPrice = $event->price + 5000;

        // 4. Merekam Transaksi ke Database
        try {
            $transaction = Transaction::create([
                'event_id'      => $event->id,
                'order_id'      => $orderId,
                'customer_name' => $request->customer_name,
                'customer_email'=> $request->customer_email,
                'customer_phone'=> $request->customer_phone,
                'total_price'   => $totalPrice,
                'status'        => 'pending', // Ubah ke huruf kecil sesuai blade
            ]);

            // Jika berhasil simpan, kita arahkan ke halaman utama dengan pesan sukses
            return redirect('/')->with('success', 'Transaksi berhasil! Order ID Anda: ' . $orderId);

        } catch (\Exception $e) {
            // Jika GAGAL, pesan error akan muncul di layar (Bukan redirect)
            return "Terjadi kesalahan saat menyimpan transaksi: " . $e->getMessage();
        }
    }
}
