<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
  public function run(): void
  {

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
