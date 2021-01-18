<?php

use Illuminate\Database\Seeder;

use App\Models\Organization;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ila = new Organization();
        $ila->name = 'International Longevity Alliance';
        $ila->slogan = 'Healthy Longevity for all through Scientific Research';
        $ila->description = 'To create the world where every person can obtain healthy longevity and ageing control through innovative technologies.';
        $ila->city_id = 1;
        $ila->save();
    }
}
