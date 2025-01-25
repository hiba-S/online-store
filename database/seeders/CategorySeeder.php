<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name'=>'Food',
                'description'=>'All kinds of food are here!',
            ],
            [
                'name'=>'Devices',
                'description'=>'All kinds of devices are here!',
            ],
            [
                'name'=>'Furniture',
                'description'=>'All kinds of furniture are here!',
            ],
            [
                'name'=>'Toys',
                'description'=>'All kinds of toys are here!',
            ],
        ];

        foreach ($categories as $category)
        {
            Category::create($category);
        }

    }
}
