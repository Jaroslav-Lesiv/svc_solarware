<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            ['name' => 'Metro Supermarket'],
            ['name' => 'GreenMart Retail'],
            ['name' => 'City Corner Shop'],
            ['name' => 'FreshStop Markets'],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}
