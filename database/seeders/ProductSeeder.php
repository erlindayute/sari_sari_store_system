<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Skyflakes Crackers',       'brand' => 'M.Y. San',          'sku' => 'SKU-001', 'category' => 'Snacks',        'stock' => 120, 'stock_max' => 150, 'price' => 12.00],
            ['name' => 'C2 Green Tea',              'brand' => 'Universal Robina',  'sku' => 'SKU-002', 'category' => 'Beverages',     'stock' => 8,   'stock_max' => 100, 'price' => 25.00],
            ['name' => 'Mang Tomas Sauce',          'brand' => 'NutriAsia',         'sku' => 'SKU-003', 'category' => 'Condiments',    'stock' => 45,  'stock_max' => 60,  'price' => 18.00],
            ['name' => 'Lucky Me Pancit Canton',    'brand' => 'Monde Nissin',      'sku' => 'SKU-004', 'category' => 'Snacks',        'stock' => 3,   'stock_max' => 80,  'price' => 15.00],
            ['name' => 'Purefoods Corned Beef',     'brand' => 'San Miguel',        'sku' => 'SKU-005', 'category' => 'Canned goods',  'stock' => 30,  'stock_max' => 50,  'price' => 55.00],
            ['name' => 'Palmolive Shampoo',         'brand' => 'Colgate-Palmolive', 'sku' => 'SKU-006', 'category' => 'Personal care', 'stock' => 0,   'stock_max' => 40,  'price' => 75.00],
            ['name' => 'Alaska Evap Milk',          'brand' => 'Alaska Milk',       'sku' => 'SKU-007', 'category' => 'Dairy',         'stock' => 22,  'stock_max' => 48,  'price' => 30.00],
            ['name' => 'Datu Puti Vinegar',         'brand' => 'NutriAsia',         'sku' => 'SKU-008', 'category' => 'Condiments',    'stock' => 5,   'stock_max' => 60,  'price' => 22.00],
            ['name' => 'Chippy Barbecue',           'brand' => 'Jack n Jill',       'sku' => 'SKU-009', 'category' => 'Snacks',        'stock' => 60,  'stock_max' => 100, 'price' => 10.00],
            ['name' => 'Kopiko 78C',                'brand' => 'Kopiko',            'sku' => 'SKU-010', 'category' => 'Beverages',     'stock' => 48,  'stock_max' => 120, 'price' => 20.00],
            ['name' => 'Argentina Corned Beef',     'brand' => 'Argentina',         'sku' => 'SKU-011', 'category' => 'Canned goods',  'stock' => 15,  'stock_max' => 50,  'price' => 45.00],
            ['name' => 'Safeguard Soap',            'brand' => 'Procter & Gamble',  'sku' => 'SKU-012', 'category' => 'Personal care', 'stock' => 25,  'stock_max' => 60,  'price' => 35.00],
        ];

        foreach ($products as $data) {
            Product::create($data);
        }
    }
}
