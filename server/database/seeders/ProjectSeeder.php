<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Project;

class ProjectSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $projects = [
      [
        'id' => 1,
        'name' => 'project1',
        'description' => 'First project',
        'deadline' => 'None',
        'payment_type_id' => 1,
        'company_id' => 1,
        'user_id' => 4,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 2,
        'name' => 'project2',
        'description' => 'Second project',
        'deadline' => 'None',
        'payment_type_id' => 2,
        'company_id' => 1,
        'user_id' => 4,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
    ];

    foreach ($projects as $project) {
      Project::create($project);
    }
  }
}