<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MiscSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(LanguageAndCountryTablesSeeder::class);
        $this->call(ExperiencesTableSeeder::class);
        $this->call(ExperiencePricingSeeder::class);
        $this->call(CategoriesTableSeeder::class);
    }
}
