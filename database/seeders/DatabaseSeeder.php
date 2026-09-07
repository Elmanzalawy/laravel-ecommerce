<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@bytesoftware.io',
        ]);

        Artisan::call('shield:generate --all --panel=admin --option=policies_and_permissions');

        $admin->assignRole('super_admin');

        $this->call([
            ProductCategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
