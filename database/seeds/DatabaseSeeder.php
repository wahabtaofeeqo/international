<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
        	[
        		RolesTableSeeder::class,
        		LocationSeeder::class,
                LanguagesTableSeeder::class,
                OrganizationsTableSeeder::class,
                UsersTableSeeder::class,
        	]
        );
    }
}
