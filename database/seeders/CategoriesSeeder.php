<?php

namespace Database\Seeders;
use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  $category = [
        //     [
        //         'name' => 'category-1',
        //         'user_id' => '2',
        //     ],
        //     [
        //         'name' => 'category-2',
        //         'user_id' => '4',
        //     ],
        // ];

        //  Categories::insert($category);
        // }

        Categories::factory(4)->create();
    }
}
