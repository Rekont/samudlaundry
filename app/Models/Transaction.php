<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Fungsi statis untuk menghitung harga final
    public static function calculateFinalPrice($userId, $serviceId, $qty)
    {
        $user = User::find($userId);
        $service = Service::find($serviceId);
        
        $basePrice = $service->price * $qty;

        // Jika User adalah Member, beri diskon 10% (contoh)
        if ($user && $user->isMember()) {
            return $basePrice * 0.90; // Diskon 10%
        }

        return $basePrice;
    }
}