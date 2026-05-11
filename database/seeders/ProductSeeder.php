<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get category IDs
        $categories = [
            'Beverages'      => Category::where('name', 'Beverages')->first()?->id ?? 1,
            'Snacks'         => Category::where('name', 'Snacks')->first()?->id ?? 2,
            'Dairy'          => Category::where('name', 'Dairy')->first()?->id ?? 3,
            'Personal Care'  => Category::where('name', 'Personal Care')->first()?->id ?? 4,
        ];

        $products = [
            ['name' => 'Skyflakes Crackers',       'brand' => 'M.Y. San',          'sku' => 'SKU-001', 'category_id' => $categories['Snacks'],         'stock' => 120, 'stock_max' => 150, 'price' => 12.00, 'status' => 'active'],
            ['name' => 'C2 Green Tea',              'brand' => 'Universal Robina',  'sku' => 'SKU-002', 'category_id' => $categories['Beverages'],     'stock' => 8,   'stock_max' => 100, 'price' => 25.00, 'status' => 'low'],
            ['name' => 'Mang Tomas Sauce',          'brand' => 'NutriAsia',         'sku' => 'SKU-003', 'category_id' => $categories['Snacks'],        'stock' => 45,  'stock_max' => 60,  'price' => 18.00, 'status' => 'active'],
            ['name' => 'Lucky Me Pancit Canton',    'brand' => 'Monde Nissin',      'sku' => 'SKU-004', 'category_id' => $categories['Snacks'],        'stock' => 3,   'stock_max' => 80,  'price' => 15.00, 'status' => 'low'],
            ['name' => 'Purefoods Corned Beef',     'brand' => 'San Miguel',        'sku' => 'SKU-005', 'category_id' => $categories['Snacks'],        'stock' => 30,  'stock_max' => 50,  'price' => 55.00, 'status' => 'active'],
            ['name' => 'Palmolive Shampoo',         'brand' => 'Colgate-Palmolive', 'sku' => 'SKU-006', 'category_id' => $categories['Personal Care'], 'stock' => 0,   'stock_max' => 40,  'price' => 75.00, 'status' => 'out'],
            ['name' => 'Alaska Evap Milk',          'brand' => 'Alaska Milk',       'sku' => 'SKU-007', 'category_id' => $categories['Dairy'],         'stock' => 22,  'stock_max' => 48,  'price' => 30.00, 'status' => 'active'],
            ['name' => 'Datu Puti Vinegar',         'brand' => 'NutriAsia',         'sku' => 'SKU-008', 'category_id' => $categories['Snacks'],        'stock' => 5,   'stock_max' => 60,  'price' => 22.00, 'status' => 'low'],
            ['name' => 'Chippy Barbecue',           'brand' => 'Jack n Jill',       'sku' => 'SKU-009', 'category_id' => $categories['Snacks'],        'stock' => 60,  'stock_max' => 100, 'price' => 10.00, 'status' => 'active'],
            ['name' => 'Kopiko 78C',                'brand' => 'Kopiko',            'sku' => 'SKU-010', 'category_id' => $categories['Beverages'],     'stock' => 48,  'stock_max' => 120, 'price' => 20.00, 'status' => 'active'],
            ['name' => 'Argentina Corned Beef',     'brand' => 'Argentina',         'sku' => 'SKU-011', 'category_id' => $categories['Snacks'],        'stock' => 15,  'stock_max' => 50,  'price' => 45.00, 'status' => 'active'],
            ['name' => 'Safeguard Soap',            'brand' => 'Procter & Gamble',  'sku' => 'SKU-012', 'category_id' => $categories['Personal Care'], 'stock' => 25,  'stock_max' => 60,  'price' => 35.00, 'status' => 'active'],
        ];

        foreach ($products as $data) {
            Product::create($data);
        }
    }
}
