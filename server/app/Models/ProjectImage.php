<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
  use HasFactory;

  protected $fillable = [
    'image_url',
    'project_id'
  ];
  
  public function project(): HasOne {
    return $this->hasOne(Project::class);
  }
}
