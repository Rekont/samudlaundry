<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $services = Service::all();
        $isMember = Auth::user()->isMember(); // Cek status member untuk tampilan
        
        return view('customer.services', compact('services', 'isMember'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'qty' => 'required|integer|min:1',
        ]);

        // Hitung harga menggunakan logika yang kita buat di Model tadi
        $finalPrice = Transaction::calculateFinalPrice(
            Auth::id(), 
            $request->service_id, 
            $request->qty
        );

        Transaction::create([
            'user_id' => Auth::id(),
            'service_id' => $request->service_id,
            'weight_or_qty' => $request->qty,
            'total_price' => $finalPrice,
            'status' => 'pending', // Menunggu konfirmasi admin/pembayaran
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil dibuat! Menunggu proses.');
    }
}
