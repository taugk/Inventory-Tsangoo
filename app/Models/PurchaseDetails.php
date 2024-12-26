<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    protected $table = 'purchase_details';

    protected $fillable = [
        'purchase_id',
        'inventory_id',
        'quantity',
        'price',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
