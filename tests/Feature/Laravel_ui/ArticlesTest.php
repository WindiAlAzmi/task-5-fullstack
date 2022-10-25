<?php

namespace Tests\Feature;

use App\Models\Articles;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Categories;

class ArticlesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
      
      protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->category = Categories::factory()->create();
        $this->articles = Articles::factory()->create();
    }


      public function test_create_articles()
    {
        $this->withoutExceptionHandling();
        $data = [
            'title' => fake()->name(),
            'content' => fake()->sentence(),
            'image' =>  UploadedFile::fake()->image('avatar.jpg'),
            'user_id' => User::factory()->create()->id,
            'category_id' => Categories::factory()->create()->id
        ];
     
        $response = $this->actingAs($this->user)->post('/dashboard/articles', $data);
        $results = [
            'title' => $data['title'],
            'content' => $data['content'],
        ];
         $this->assertDatabaseHas('articles', $results);
         $response->assertRedirect(route('articles.index'));

    }


      public function test_update_articles()
    {
        $this->withoutExceptionHandling();
     
        $newData = [
            'title' => fake()->name(),
            'content' => fake()->sentence(),
            'image' =>  UploadedFile::fake()->image('avatar.jpg'),
            'user_id' => User::factory()->create()->id,
            'category_id' => Categories::factory()->create()->id
        ];

        $response = $this->actingAs($this->user)->put('/dashboard/articles/1' , $newData);
        
        $results = [
            'title' => $newData['title'],
            'content' => $newData['content'],
        ];
         $this->assertDatabaseHas('articles', $results);
         $response->assertRedirect(route('articles.index'));

    }

     public function test_can_get_a_article()
    {

        $response = $this->actingAs($this->user)
                        ->get('/dashboard/articles/1');

        $response->assertStatus(200);
         $response->assertOk();
    
    }

     public function test_can_view_articles_list()
    {

        $response = $this->actingAs($this->user)
                        ->get('/dashboard/articles');

        $response->assertStatus(200);             
        $response->assertOk();
    }

    public function test_can_delete_a_article()
    {
        $this->withoutExceptionHandling();
        $task = $this->articles;

        $response = $this->actingAs($this->user)->delete('/dashboard/articles/' . $task->id);

        $this->assertDatabaseMissing('articles', $task->toArray());
        // $response->assertStatus(200);             
        // $response->assertOk();
         $response->assertRedirect(route('articles.index'));

    }


}
