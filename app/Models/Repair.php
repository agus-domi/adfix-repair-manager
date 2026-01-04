<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    protected $fillable = [
        'client_id',
        'device',
        'issue',
        'estimated_price',
        'charged_amount',
        'status',
        'received_at',
        'delivered_at',
    ];

    protected $casts = [
        'received_at' => 'date',
        'delivered_at' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    // Ganancia calculada
    public function getProfitAttribute()
    {
        $expenses = $this->expenses->sum('amount');
        return ($this->paid_amount ?? 0) - $expenses;
    }
}