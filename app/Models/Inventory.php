<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventory';

    protected $fillable = [
        'sku',
        'name',
        'description',
        'quantity',
        'price',
        'status',
        'supplier_id',
        'image',
        'category_id',
        'user_id',
        'unit',
        'expiry_date',
        'entry_date',
        'created_at',
    ];

    protected $casts = [
        'expiry_date' => 'datetime',
        'entry_date' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transactions::class);
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function inventoryOuts()
    {
        return $this->hasMany(InventoryOuts::class);
    }
}
