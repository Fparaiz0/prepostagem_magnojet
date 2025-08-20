<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Seeds que devem rodar em produção
        if (App::environment() === 'production') {
            $this->call([
                
                UserStatusSeeder::class,
                UserSeeder::class,
                PackagingSeeder::class,
                PermissionSeeder::class, 
                RoleSeeder::class,
                SenderSeeder::class,

            ]);
        }

        // Seeds que devem rodar em qualquer ambiente
        if (App::environment() !== 'production') {
            $this->call([
                PermissionSeeder::class, 
                RoleSeeder::class,

                UserStatusSeeder::class,
                UserSeeder::class,

                PackagingSeeder::class,
                SenderSeeder::class,
            ]);
        }
    }
}
