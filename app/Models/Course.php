<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;
    protected $hidden = ['created_at', 'updated_at', 'pivot'];


    /**
     * The students that belong to the course.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'students_courses');
    }
}
