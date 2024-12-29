<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryOuts extends Model
{
    protected $table = 'inventory_outs';
    protected $fillable = [
        'id',
        'inventory_id',
        'quantity',
        'date_out',
        'user_id',
        'supplier_id',
    ];

    protected $casts = [
        'date_out' => 'datetime',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
