<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $users = [
      [
        'id' => 1,
        'email' => 'admin@admin.ru',
        'password' => Hash::make('12345678'),
        'email_verified_at' => null,
        'email_remember_token' => null,
        'role_id' => 1,
        'company_id' => null,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 2,
        'email' => 'user@user.ru',
        'password' => Hash::make('12345678'),
        'email_verified_at' => null,
        'email_remember_token' => null,
        'role_id' => 2,
        'company_id' => null,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 3,
        'email' => 'manager@manager.ru',
        'password' => Hash::make('12345678'),
        'email_verified_at' => null,
        'email_remember_token' => null,
        'role_id' => 3,
        'company_id' => null,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 4,
        'email' => 'admin1@company1.ru',
        'password' => Hash::make('12345678'),
        'email_verified_at' => null,
        'email_remember_token' => null,
        'role_id' => 4,
        'company_id' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 5,
        'email' => 'admin2@company2.ru',
        'password' => Hash::make('12345678'),
        'email_verified_at' => null,
        'email_remember_token' => null,
        'role_id' => 4,
        'company_id' => 2,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 6,
        'email' => 'manager1@company1.ru',
        'password' => Hash::make('12345678'),
        'email_verified_at' => null,
        'email_remember_token' => null,
        'role_id' => 5,
        'company_id' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 7,
        'email' => 'manager2@company2.ru',
        'password' => Hash::make('12345678'),
        'email_verified_at' => null,
        'email_remember_token' => null,
        'role_id' => 5,
        'company_id' => 2,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 8,
        'email' => 'su@su.ru',
        'password' => Hash::make('12345678'),
        'email_verified_at' => null,
        'email_remember_token' => null,
        'role_id' => 6,
        'company_id' => null,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
    ];

    foreach($users as $user) {
      User::create($user);
    }
  }
}