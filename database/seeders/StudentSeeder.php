<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('students')->insert([
            [
                'name' => 'Admon',
                'last_name' => 'Json',
                'email' => 'admin@admin.comn',
                'password' => Hash::make('12345678'),
                'role_id' => UserRole::ADMIN,
            ]
        ]);
        Student::factory(100)->create();
    }
}
