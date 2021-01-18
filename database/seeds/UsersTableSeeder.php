<?php

use Illuminate\Database\Seeder;

use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super = new User();
        $super->name = 'ILA';
        $super->email = 'super@ila.org';
        $super->password = bcrypt('josiahilaproject');
        $super->organization_id = 1;
        $super->role_id = 4;
        $super->save();
    }
}
