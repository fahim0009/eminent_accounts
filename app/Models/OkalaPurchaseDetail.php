<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkalaPurchaseDetail extends Model
{
    use HasFactory;

    public function okalaPurchase()
    {
        return $this->belongsTo(OkalaPurchase::class);
    }

    public function rldetail()
    {
        return $this->belongsTo(RLDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function client()
    {
        return $this->belongsTo(Client::class, 'assign_to', 'id');
    }
}
