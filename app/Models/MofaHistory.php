<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MofaHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'user_id',
        'client_id',
        'mofa_trade',
        'rlid',
        'note',
        'status',
        'updated_by',
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function mofaTrade()
    {
        return $this->belongsTo(CodeMaster::class, 'mofa_trade');
    }

    public function rlidCode()
    {
        return $this->belongsTo(CodeMaster::class, 'rlid');
    }

    
}
