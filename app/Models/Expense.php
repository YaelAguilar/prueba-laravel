<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['provider_id', 'amount', 'concept', 'date', 'description'];
    
    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2'
    ];
    
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}
