<?php

use Illuminate\Database\Seeder;

use App\Models\Language;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $en = new Language();
        $en->name = 'English';
        $en->code = 'en';
        $en->save();
    }
}
