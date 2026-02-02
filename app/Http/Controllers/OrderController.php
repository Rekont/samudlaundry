<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Halaman untuk memilih layanan
    public function index()
    {
        $services = Service::all();
        
        // Default values untuk tamu (Guest)
        $isMember = false;
        $completedCount = 0;
        $remainingToMember = 5; // Default butuh 5 lagi

        if (Auth::check()) {
            $user = Auth::user();
            $isMember = $user->isMember();
            
            // Hitung transaksi yang SUDAH SELESAI (Completed)
            $completedCount = $user->transactions()->where('status', 'completed')->count();
            
            // Hitung sisa berapa kali lagi (5 dikurangi jumlah yang sudah selesai)
            // Jika hasilnya minus (karena sudah lebih dari 5), kita set jadi 0
            $remainingToMember = max(0, 5 - $completedCount);
        }

        return view('order.index', compact('services', 'isMember', 'completedCount', 'remainingToMember'));
    }
public function create(Service $service)
    {
        // Cek apakah user member untuk menampilkan info diskon di form
        $isMember = Auth::user()->isMember();
        
        return view('order.create', compact('service', 'isMember'));
    }

    // Proses menyimpan pesanan
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'weight' => 'required|numeric|min:1', // Berat minimal 1 kg/satuan
        ]);

        // 2. Hitung Harga
        // Kita panggil fungsi hitung otomatis yang sudah kita buat di Model Transaction sebelumnya
        $finalPrice = Transaction::calculateFinalPrice(
            Auth::id(),
            $request->service_id,
            $request->weight
        );

        // 3. Simpan Transaksi
        Transaction::create([
            'user_id' => Auth::id(),
            'service_id' => $request->service_id,
            'weight_or_qty' => $request->weight,
            'total_price' => $finalPrice,
            'status' => 'pending', // Status awal 'pending' menunggu admin
        ]);

        return redirect()->route('dashboard')->with('success', 'Pesanan berhasil! Silakan tunggu konfirmasi Admin.');
    }
}