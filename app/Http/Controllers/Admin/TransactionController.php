<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction; // Impor model yang BENAR dari folder Models

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('event')->latest()->paginate(20);
        return view('admin.transactions.index', compact('transactions'));
    }
}
