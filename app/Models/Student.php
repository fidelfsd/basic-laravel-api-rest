<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $last_name
 * @property string $email
 * @property string|null $address
 * @property string $active
 * @property string $password
 * @property int $role_id
 */

class Student extends Model
{
    use HasFactory, HasApiTokens;
    protected $hidden = ['created_at', 'updated_at', 'pivot', 'password'];

    /**
     * The courses that belong to the student.
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'students_courses');
    }

    /**
     * The role that belong to the student.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
