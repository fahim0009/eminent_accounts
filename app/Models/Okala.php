<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Okala extends Model
{
    use HasFactory;

    public function okalaDetail()
    {
        return $this->hasMany(OkalaDetail::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }


    
}
