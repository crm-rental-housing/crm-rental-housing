<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\PaymentType;

class PaymentTypeSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $payment_types = [
      [
        'id' => 1,
        'name' => 'Ипотека',
        'description' => 'Ипотека',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 2,
        'name' => 'Нал',
        'description' => 'Нал',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 3,
        'name' => 'Карта',
        'description' => 'Карта',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
    ];

    foreach ($payment_types as $type) {
      PaymentType::create($type);
    }
  }
}