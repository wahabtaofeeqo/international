<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new Role();
        $user->name = 'user';
        $user->save();

        $editor = new Role();
        $editor->name = 'editor';
        $editor->save();
        
        $admin = new Role();
        $admin->name = 'admin';
        $admin->save();

        $super = new Role();
        $super->name = 'super';
        $super->save();
    }
}
