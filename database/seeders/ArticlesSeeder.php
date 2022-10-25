<?php

namespace Database\Seeders;
use App\Models\Articles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Articles::factory(4)->create();
     
        //  $article = [
        //     [
        //         'title' => 'article 1',
        //         'content' => 'lorem opsumm grehe',
        //         'image' => 'gambar.jpg', 
        //         'user_id' => '3',
        //         'category_id' => '2',
        //     ],
        //     [
        //         'title' => 'article 2',
        //         'content' => 'lorem ipsumrehre',
        //         'image' => 'gambar2.jpg', 
        //         'user_id' => '3',
        //         'category_id' => '4',
        //     ],
        // ];

        // Articles::insert($article);
      
    }
}
