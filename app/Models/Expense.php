<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'repair_id',
        'description',
        'amount',
    ];

    public function repair()
    {
        return $this->belongsTo(Repair::class);
    }
}