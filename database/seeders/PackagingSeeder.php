<?php

namespace Database\Seeders;

use App\Models\Packaging;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class PackagingSeeder extends Seeder
{
  public function run(): void
  {
    try {
      Packaging::firstOrCreate(
        [
          'name' => 'CAIXA 01',
          'id' => 1
        ],
        [
          'id' => 1,
          'name' => 'CAIXA 01',
          'height' => '24',
          'width' => '18',
          'length' => '22',
          'diameter' => '0',
          'weight' => '1',
          'active' => 1
        ],
      );

      Packaging::firstOrCreate(
        [
          'name' => 'CAIXA 02',
          'id' => 2
        ],
        [
          'id' => 2,
          'name' => 'CAIXA 02',
          'height' => '24',
          'width' => '18',
          'length' => '36',
          'diameter' => '0',
          'weight' => '1',
          'active' => 1
        ],
      );

      Packaging::firstOrCreate(
        [
          'name' => 'CAIXA 03',
          'id' => 3
        ],
        [
          'id' => 3,
          'name' => 'CAIXA 03',
          'height' => '31',
          'width' => '24',
          'length' => '36',
          'diameter' => '0',
          'weight' => '1',
          'active' => 1
        ],
      );

      Packaging::firstOrCreate(
        [
          'name' => 'CAIXA 04',
          'id' => 4
        ],
        [
          'id' => 4,
          'name' => 'CAIXA 04',
          'height' => '16',
          'width' => '16',
          'length' => '22',
          'diameter' => '0',
          'weight' => '1',
          'active' => 1
        ],
      );

      Packaging::firstOrCreate(
        [
          'name' => 'CAIXA 05',
          'id' => 5
        ],
        [
          'id' => 5,
          'name' => 'CAIXA 05',
          'height' => '31',
          'width' => '38',
          'length' => '47',
          'diameter' => '0',
          'weight' => '1',
          'active' => 1
        ],
      );

      Packaging::firstOrCreate(
        [
          'name' => 'CAIXA 06',
          'id' => 6
        ],
        [
          'id' => 6,
          'name' => 'CAIXA 06',
          'height' => '42',
          'width' => '47',
          'length' => '67',
          'diameter' => '0',
          'weight' => '1',
          'active' => 1
        ],
      );

      Packaging::firstOrCreate(
        [
          'name' => 'CAIXA 07',
          'id' => 7
        ],
        [
          'id' => 7,
          'name' => 'CAIXA 07',
          'height' => '25',
          'width' => '19',
          'length' => '65',
          'diameter' => '0',
          'weight' => '1',
          'active' => 1
        ],
      );

      Packaging::firstOrCreate(
        [
          'name' => 'CAIXA 09',
          'id' => 8
        ],
        [
          'id' => 8,
          'name' => 'CAIXA 09',
          'height' => '34',
          'width' => '24',
          'length' => '63',
          'diameter' => '0',
          'weight' => '1',
          'active' => 1
        ],
      );

      Packaging::firstOrCreate(
        [
          'name' => 'CAIXA 10',
          'id' => 9
        ],
        [
          'id' => 9,
          'name' => 'CAIXA 10',
          'height' => '46',
          'width' => '25',
          'length' => '38',
          'diameter' => '0',
          'weight' => '1',
          'active' => 1
        ],
      );

      Packaging::firstOrCreate(
        [
          'name' => 'CAIXA 11',
          'id' => 10
        ],
        [
          'id' => 10,
          'name' => 'CAIXA 11',
          'height' => '58',
          'width' => '39',
          'length' => '60',
          'diameter' => '0',
          'weight' => '1',
          'active' => 1
        ],
      );

      Packaging::firstOrCreate(
        [
          'name' => 'COSTAL 10L',
          'id' => 11
        ],
        [
          'id' => 11,
          'name' => 'COSTAL 10L',
          'height' => '67',
          'width' => '14',
          'length' => '47',
          'diameter' => '0',
          'weight' => '1',
          'active' => 1
        ],
      );

      Packaging::firstOrCreate(
        [
          'name' => 'COSTAL 16L',
          'id' => 12
        ],
        [
          'id' => 12,
          'name' => 'COSTAL 16L',
          'height' => '67',
          'width' => '19',
          'length' => '47',
          'diameter' => '0',
          'weight' => '1',
          'active' => 1
        ],
      );

      Packaging::firstOrCreate(
        [
          'name' => 'COSTAL 20L',
          'id' => 13
        ],
        [
          'id' => 13,
          'name' => 'COSTAL 20L',
          'height' => '67',
          'width' => '23',
          'length' => '47',
          'diameter' => '0',
          'weight' => '1',
          'active' => 1
        ],
      );

      Packaging::firstOrCreate(
        [
          'name' => 'EXPOSITOR',
          'id' => 14
        ],
        [
          'id' => 14,
          'name' => 'EXPOSITOR',
          'height' => '50',
          'width' => '22',
          'length' => '42',
          'diameter' => '0',
          'weight' => '1',
          'active' => 1
        ],
      );

      Packaging::firstOrCreate(
        [
          'name' => 'CAIXA DE PINGENTE',
          'id' => 15
        ],
        [
          'id' => 15,
          'name' => 'CAIXA DE PINGENTE',
          'height' => '34',
          'width' => '10',
          'length' => '74',
          'diameter' => '0',
          'weight' => '1',
          'active' => 1
        ],
      );
    } catch (Exception $e) {
      Log::notice('Embalagens não cadastrada.', ['error' => $e->getMessage()]);
    }
  }
}
