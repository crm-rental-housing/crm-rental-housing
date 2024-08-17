<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\UserInfo;

class UserInfoSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $infos = [
      [
        'id' => 1,
        'username' => 'admin1',
        'user_id' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 2,
        'username' => 'user1',
        'user_id' => 2,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 3,
        'username' => 'manager1',
        'user_id' => 3,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 4,
        'username' => 'company1_admin1',
        'user_id' => 4,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 5,
        'username' => 'company2_admin2',
        'user_id' => 5,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 6,
        'username' => 'company1_manager1',
        'user_id' => 6,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 7,
        'username' => 'company2_manager2',
        'user_id' => 7,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 8,
        'username' => 'superuser',
        'user_id' => 8,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
    ];

    foreach($infos as $info) {
      UserInfo::create($info);
    }
  }
}