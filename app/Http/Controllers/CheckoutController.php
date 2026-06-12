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
        // 1. TANGKAP ERROR VALIDASI (Silent Failure penyebab utama)
        try {
            $request->validate([
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email|max:255',
                'customer_phone' => 'required|string|max:20',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika ada nama input yang tidak cocok atau kosong, tampilkan paksa!
            dd('CCTV VALIDASI GAGAL! Ada masalah pada isian form:', $e->errors());
        }

        // 2. TANGKAP ERROR STOK
        if ($event->stock <= 0) {
            dd('CCTV STOK GAGAL! Stok tiket untuk event ini 0.');
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
                'status'        => 'pending',
            ]);

            // JIKA SEMUA BERJALAN LANCAR, LAYAR AKAN BERHENTI DAN MENAMPILKAN INI:
            dd('CCTV SUKSES! Data berhasil masuk database:', $transaction->toArray());

        } catch (\Exception $e) {
            // Jika database menolak, tampilkan alasan aslinya:
            dd('CCTV DATABASE ERROR! Gagal menyimpan:', $e->getMessage());
        }
    }
}
