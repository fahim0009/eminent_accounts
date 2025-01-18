<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    use HasFactory;

    public function expense()
    {
        return $this->hasMany(Expense::class, 'chart_of_account_id');
    }
}
