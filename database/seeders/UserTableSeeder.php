<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Super Admin
        $superAdmin = new User();
        $superAdmin->name = 'Super Admin';
        $superAdmin->email = 'superadmin@6am.dev';
        $superAdmin->password = bcrypt('password');
        $superAdmin->is_admin = 1;
        $superAdmin->save();

        // Admin
        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'admin@6am.dev';
        $admin->password = bcrypt('password');
        $admin->save();
    }
}
