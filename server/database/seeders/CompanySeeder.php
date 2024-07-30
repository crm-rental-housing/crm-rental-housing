<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Company;

class CompanySeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $companies = [
      [
        'id' => 1,
        'name' => 'company1',
        'description' => 'First company',
        'email' => 'company@company1.ru',
        'phone_number' => '+7XXXXXXXXX1',
      ],
      [
        'id' => 2,
        'name' => 'company2',
        'description' => 'Second company',
        'email' => 'company@company2.ru',
        'phone_number' => '+7XXXXXXXXX2',
      ],
      [
        'id' => 3,
        'name' => 'company3',
        'description' => 'Third company',
        'email' => 'company@company3.ru',
        'phone_number' => '+7XXXXXXXXX3',
      ],
    ];

    foreach ($companies as $company) {
      Company::create($company);
    }
  }
}