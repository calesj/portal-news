<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new Admin();
        $admin->name = 'Super User';
        $admin->email = 'admin@admin.com';
        $admin->image = '/test';
        $admin->status = 1;
        $admin->password = bcrypt('12345678');
        $admin->save();
    }
}
