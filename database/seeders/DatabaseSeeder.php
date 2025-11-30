<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'), // كلمة المرور: password
        ]);

        $this->command->info('تم إنشاء مستخدم Admin: admin@example.com');
        $this->command->info('كلمة المرور: password');

        $this->call([
            PositionSeeder::class,
            ApplicantSeeder::class,
        ]);

        $this->command->info('تم إكمال جميع Seeders بنجاح!');
    }
}
