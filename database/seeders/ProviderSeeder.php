<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    public function run(): void
    {
        $providers = [
            ['name' => 'Ahmad Tea Co.'],
            ['name' => 'Lipton International'],
            ['name' => 'Twinings Group'],
        ];

        foreach ($providers as $provider) {
            Provider::create($provider);
        }
    }
}
