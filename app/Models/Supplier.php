<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;
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

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    public function inventoryOuts()
    {
        return $this->hasMany(InventoryOuts::class);
    }
}
