<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'city',
        'state',
        'image',
        'role',
    ];

    protected $hidden = [

        'remember_token',
    ];

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function invetoryOuts()
    {
        return $this->hasMany(InventoryOuts::class);
    }




}
