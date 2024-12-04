<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkalaDetail extends Model
{
    use HasFactory;

    public function okala()
    {
        return $this->belongsTo(Okala::class);
    }

    public function rldetail()
    {
        return $this->belongsTo(RLDetail::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }


    public function client()
    {
        return $this->belongsTo(Client::class, 'assign_to', 'id');
    }
}
