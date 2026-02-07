<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = ['name'];
    
    public function incomes()
    {
        return $this->hasMany(Income::class);
    }
    
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
