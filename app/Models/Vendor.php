<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    public function okalaDetail()
    {
        return $this->hasMany(OkalaDetail::class);
    }

    public function okala()
    {
        return $this->hasMany(Okala::class);
    }
}
