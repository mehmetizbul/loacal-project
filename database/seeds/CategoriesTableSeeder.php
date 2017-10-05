<?php

use Illuminate\Database\Seeder;
use App\Category;
class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $path = 'exports/categories.csv';
        $file = fopen($path, 'r');

        while (($line = fgetcsv($file)) !== FALSE) {
            $image = explode('uploads/',$line[4])[1];
            $aTmp = explode('/',$image);
            $filename = end($aTmp);

            if(Storage::exists($image)) {
                Storage::move($image, 'categories/'.$filename);
            }

            Category::firstOrCreate([
                "id"    => $line[0],
                "name"  => $line[1],
                "slug"  => $line[2],
                "parent"=> $line[3] ? $line[3] : 0,
                "icon"  => $filename
            ]);
        }
    }
}
