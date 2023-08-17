<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'amount',
        'type',
        'date',
        'category',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function wallet($month, $year, $user_id)
    {
        return Transaction::query()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('user_id', $user_id)
            ->groupBy('type')
            ->selectRaw('type, sum(amount) as total')
            ->toSql();
    }
}
