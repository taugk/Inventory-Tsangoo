<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';

    protected $fillable = [
        'name',
        'contact',
        'email',
        'address',
    ];

    public function transactions()
    {
        return $this->hasMany(Transactions::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
