<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $blackTea      = Category::where('name', 'Black Tea')->first();
        $greenTea      = Category::where('name', 'Green Tea')->first();
        $earlGrey      = Category::where('name', 'Earl Grey Blends')->first();
        $chamomile     = Category::where('name', 'Chamomile')->first();
        $engBreakfast  = Category::where('name', 'English Breakfast')->first();
        $fruitHerbal   = Category::where('name', 'Fruit & Herbal')->first();

        $products = [
            ['name' => 'Ahmad Tea Black Classic 500g',     'category_id' => $blackTea->id,     'price' => '9.99'],
            ['name' => 'Ahmad Tea Earl Grey 250g',         'category_id' => $earlGrey->id,     'price' => '8.49'],
            ['name' => 'Ahmad Tea Earl Grey 500g',         'category_id' => $earlGrey->id,     'price' => '14.99'],
            ['name' => 'Ahmad Tea Green Jasmine 200g',     'category_id' => $greenTea->id,     'price' => '7.99'],
            ['name' => 'Lipton Chamomile Nights 20 bags',  'category_id' => $chamomile->id,    'price' => '4.29'],
            ['name' => 'Lipton Chamomile Pure 40 bags',    'category_id' => $chamomile->id,    'price' => '6.99'],
            ['name' => 'Twinings English Breakfast 50g',   'category_id' => $engBreakfast->id, 'price' => '5.49'],
            ['name' => 'Twinings Cranberry & Raspberry',   'category_id' => $fruitHerbal->id,  'price' => '4.99'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
