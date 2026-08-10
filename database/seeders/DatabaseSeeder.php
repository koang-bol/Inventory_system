<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $wirelessMouse = Product::create([
            'name' => 'Wireless Mouse',
            'description' => 'Ergonomic mouse with adjustable DPI and USB receiver.',
            'price' => 29.99,
            'quantity' => 20,
        ]);

        StockTransaction::create([
            'product_id' => $wirelessMouse->id,
            'type' => 'in',
            'quantity' => 5,
            'notes' => 'Wireless; Mouse; USB receiver',
            'created_at' => now()->subMinutes(12),
            'updated_at' => now()->subMinutes(12),
        ]);

        StockTransaction::create([
            'product_id' => $wirelessMouse->id,
            'type' => 'out',
            'quantity' => 2,
            'notes' => 'Sold; Customer order',
            'created_at' => now()->subMinutes(9),
            'updated_at' => now()->subMinutes(9),
        ]);

        $mechanicalKeyboard = Product::create([
            'name' => 'Mechanical Keyboard',
            'description' => 'Tactile keyboard with RGB lighting and durable switches.',
            'price' => 79.99,
            'quantity' => 15,
        ]);

        StockTransaction::create([
            'product_id' => $mechanicalKeyboard->id,
            'type' => 'in',
            'quantity' => 4,
            'notes' => 'Keyboard; RGB lighting',
            'created_at' => now()->subMinutes(18),
            'updated_at' => now()->subMinutes(18),
        ]);

        StockTransaction::create([
            'product_id' => $mechanicalKeyboard->id,
            'type' => 'out',
            'quantity' => 1,
            'notes' => 'Demo unit; Display',
            'created_at' => now()->subMinutes(15),
            'updated_at' => now()->subMinutes(15),
        ]);

        $usbHub = Product::create([
            'name' => 'USB-C Hub',
            'description' => '7-in-1 hub with HDMI, USB-A, Ethernet, and SD card slots.',
            'price' => 49.99,
            'quantity' => 10,
        ]);

        StockTransaction::create([
            'product_id' => $usbHub->id,
            'type' => 'in',
            'quantity' => 6,
            'notes' => 'Hub; HDMI; Ethernet',
            'created_at' => now()->subMinutes(24),
            'updated_at' => now()->subMinutes(24),
        ]);

        StockTransaction::create([
            'product_id' => $usbHub->id,
            'type' => 'out',
            'quantity' => 2,
            'notes' => 'Kit; Office setup',
            'created_at' => now()->subMinutes(21),
            'updated_at' => now()->subMinutes(21),
        ]);

        $clothingPack = Product::create([
            'name' => 'Clothing Pack',
            'description' => 'Shoes Stockings',
            'price' => 109.95,
            'quantity' => 8,
        ]);

        StockTransaction::create([
            'product_id' => $clothingPack->id,
            'type' => 'in',
            'quantity' => 3,
            'notes' => 'Shoes; Stockings',
            'created_at' => now()->subMinutes(3),
            'updated_at' => now()->subMinutes(3),
        ]);

        StockTransaction::create([
            'product_id' => $clothingPack->id,
            'type' => 'in',
            'quantity' => 1,
            'notes' => 'Shoes; Stockings',
            'created_at' => now()->subMinutes(6),
            'updated_at' => now()->subMinutes(6),
        ]);
    }
}
