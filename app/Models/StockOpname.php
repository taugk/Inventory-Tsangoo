<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockOpname extends Model
{
    use HasFactory;

    protected $table = 'stock_opnames';

    protected $fillable = [
        'inventory_id',
        'system_stock',
        'actual_stock',
        'difference',
        'notes',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }


}
