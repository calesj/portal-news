<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new Admin();
        $admin->name = 'Cales Junes';
        $admin->email = 'admin@admin.com';
        $admin->image = '/test';
        $admin->status = 1;
        $admin->password = bcrypt('12345678');
        $admin->save();

        Role::create(['name' => 'super admin', 'guard_name' => 'admin']);

        $admin->assignRole('super admin');
    }
}
