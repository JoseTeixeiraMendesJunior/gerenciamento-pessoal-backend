<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'amount',
        'type',
        'date',
        'frequency',
        'active',
        'transaction_category_id',
        'user_id',
    ];

    public function category()
    {
        return $this->belongsTo(TransactionCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
