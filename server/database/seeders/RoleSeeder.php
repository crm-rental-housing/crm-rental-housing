<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;

class RoleSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $roles = [
      [
        'id' => 1,
        'value' => 'ADMIN',
        'description' => 'Администратор системы',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 2,
        'value' => 'USER',
        'description' => 'Обычный пользователь системы',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 3,
        'value' => 'MANAGER',
        'description' => 'Менеджер системы',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 4,
        'value' => 'COMPANY_ADMIN',
        'description' => 'Администратор застройщика',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 5,
        'value' => 'COMPANY_MANAGER',
        'description' => 'Менеджер застройщика',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 6,
        'value' => 'SUPERUSER',
        'description' => 'Суперпользователь',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ]
    ];

    foreach($roles as $role) {
      Role::create($role);
    }
  }
}