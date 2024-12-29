<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Inventory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Inventory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sku' => strtoupper(Str::random(10)), // SKU unik acak
            'name' => $this->faker->word(), // Nama barang acak
            'description' => $this->faker->sentence(), // Deskripsi barang
            'quantity' => $this->faker->numberBetween(1, 100), // Kuantitas stok acak
            'price' => $this->faker->randomFloat(2, 1, 1000), // Harga acak
            'image' => $this->faker->imageUrl(640, 480, 'products', true), // Gambar produk
            'supplier_id' => Supplier::inRandomOrder()->first()->id ?? null, // ID pemasok acak atau null
            'status' => $this->faker->randomElement(['active', 'inactive']), // Status stok
            'category_id' => Category::inRandomOrder()->first()->id ?? null, // ID kategori acak atau null
            'user_id' => User::inRandomOrder()->first()->id ?? null, // ID pengguna acak atau null
            'expiry_date' => Carbon::now()->addDays($this->faker->numberBetween(30, 365))->format('Y-m-d'),// Tanggal kedaluwarsa
        ];
    }
}
