<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'rating',
        'image',
        'instructor_id',
        'is_featured'
    ];


    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

  

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            ->withPivot('enrolled_at');
    }

    
    public function enrolledStudentsCount()
    {
        return $this->users()->count();
    }

  
    public function isEnrolledBy($userId)
    {
        return $this->users()->where('user_id', $userId)->exists();
    }
}
