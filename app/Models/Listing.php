<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
       'title',
        'description',
       'job_type',
       'salary',
       'roles',
       'address',
       'feature_image',
        'application_close_date',
        'feature_image',
        'slug'
       
    ];

    public function users(){
          $this->belongsToMany(User::class)
          ->withPivot('shortlisted')
          ->withTimestamps();
    }
}
