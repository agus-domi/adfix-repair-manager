<?php

namespace App\Models;

use App\Enums\RepairStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'status' => RepairStatus::class,
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function getProfitAttribute(): float
    {
        $expenses = $this->getAttribute('expenses_sum_amount') ?? $this->expenses->sum('amount');
        return ($this->charged_amount ?? 0) - $expenses;
    }
}