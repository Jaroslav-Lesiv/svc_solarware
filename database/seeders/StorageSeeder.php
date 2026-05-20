<?php

namespace Database\Seeders;

use App\Models\Storage;
use Illuminate\Database\Seeder;

class StorageSeeder extends Seeder
{
    public function run(): void
    {
        $storages = [
            ['name' => 'Main Warehouse'],
            ['name' => 'North Depot'],
            ['name' => 'Cold Storage Unit A'],
        ];

        foreach ($storages as $storage) {
            Storage::create($storage);
        }
    }
}
