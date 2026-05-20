<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Provider;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $ahmad = Provider::where('name', 'Ahmad Tea Co.')->first();
        $lipton = Provider::where('name', 'Lipton International')->first();
        $twinings = Provider::where('name', 'Twinings Group')->first();

        // Ahmad Tea hierarchy
        $ahmadRoot = Category::create(['name' => 'Ahmad Tea', 'provider_id' => $ahmad->id]);
        $blackTea  = Category::create(['name' => 'Black Tea',  'parent_id' => $ahmadRoot->id]);
        $greenTea  = Category::create(['name' => 'Green Tea',  'parent_id' => $ahmadRoot->id]);
        Category::create(['name' => 'Earl Grey Blends', 'parent_id' => $blackTea->id]);

        // Lipton hierarchy
        $liptonRoot = Category::create(['name' => 'Lipton', 'provider_id' => $lipton->id]);
        $herbal     = Category::create(['name' => 'Herbal',  'parent_id' => $liptonRoot->id]);
        Category::create(['name' => 'Chamomile', 'parent_id' => $herbal->id]);

        // Twinings hierarchy
        $twiningsRoot = Category::create(['name' => 'Twinings', 'provider_id' => $twinings->id]);
        Category::create(['name' => 'English Breakfast', 'parent_id' => $twiningsRoot->id]);
        Category::create(['name' => 'Fruit & Herbal',   'parent_id' => $twiningsRoot->id]);
    }
}
