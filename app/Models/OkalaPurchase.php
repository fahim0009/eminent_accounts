<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkalaPurchase extends Model
{
    use HasFactory;

    public function okalaPurchaseDetail()
    {
        return $this->hasMany(OkalaPurchaseDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function codeMaster()
    {
        return $this->belongsTo(CodeMaster::class, 'r_l_detail_id');
    }
    
}
