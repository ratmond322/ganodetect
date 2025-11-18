<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@ganodetect.test'],
            [
                'name' => 'Site Admin',
                'password' => Hash::make('password123'), // ganti setelah login
                'is_admin' => true,
            ]
        );
    }
}
