<?php

namespace Tests\Feature;

use App\Models\Articles;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Categories;

class CategoryTest extends TestCase
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


      public function test_create_category()
    {
        $this->withoutExceptionHandling();
        $data = [
            'name' => fake()->name(),
            'user_id' => User::factory()->create()->id,
        ];
     
        $response = $this->actingAs($this->user)->post('/dashboard/categories', $data);
        $results = [
            'name' => $data['name'],
        ];
         $this->assertDatabaseHas('categories', $results);
         $response->assertRedirect(route('categories.index'));

    }


      public function test_update_categories()
    {
        $this->withoutExceptionHandling();
     
        $newData = [
            'name' => fake()->name(),
            'user_id' => User::factory()->create()->id
        ];

        $response = $this->actingAs($this->user)->put('/dashboard/categories/1' , $newData);
        
        $results = [
            'name' => $newData['name'],

        ];
         $this->assertDatabaseHas('categories', $results);
         $response->assertRedirect(route('categories.index'));

    }

     public function test_can_get_a_category()
    {

        $response = $this->actingAs($this->user)
                        ->get('/dashboard/categories/1');

        $response->assertStatus(200);
         $response->assertOk();
    
    }

     public function test_can_view_categories_list()
    {

        $response = $this->actingAs($this->user)
                        ->get('/dashboard/categories');

        $response->assertStatus(200);             
        $response->assertOk();
    }

    public function test_can_delete_a_categories()
    {
        $this->withoutExceptionHandling();
        $task = $this->category;

        $response = $this->actingAs($this->user)->delete('/dashboard/categories/' . $task->id);

        $this->assertDatabaseMissing('categories', $task->toArray());
        // $response->assertStatus(200);             
        // $response->assertOk();
         $response->assertRedirect(route('categories.index'));

    }
}
