<?php

use Illuminate\Database\Seeder;
use App\Index;

class MiscSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $tables=["experience"];

    public function run()
    {
        foreach($this->tables as $index) {
            Index::insert([
                'table' => $index,
                'value' => 1
            ]);
        }
    }
}
