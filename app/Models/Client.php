<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kafelaclient()
    {
        return $this->hasMany(KafelaClient::class);
    }

    public function okalaDetail()
    {
        return $this->hasMany(OkalaDetail::class, 'assign_to', 'id');
    }

    public function rldetail()
    {
        return $this->belongsTo(CodeMaster::class, 'rlid', 'id');
    }

    public function trade()
    {
        return $this->belongsTo(CodeMaster::class, 'mofa_trade', 'id');
    }

    public function mofaHistories()
    {
        return $this->hasMany(MofaHistory::class)->orderBy('date', 'desc');
    }

   

}
