<?php

namespace Tests\Feature;

use App\Models\Categories;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Articles;

class PassportArticlesTest extends TestCase
{

    //   use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
 
    protected function setUp(): void
    {
        parent::setUp();
        $this->articles = Articles::factory()->create();
     
    }

     public function authenticate(){
         $user = User::create([
            'name' => 'test',
            'email' => rand(12345,678910).'test@gmail.com',
            'password' => bcrypt('secretWindi')
        ]);

         if (!auth()->attempt(['email'=>$user->email, 'password'=>'secretWindi'])) {
            return response(['message' => 'Login credentials are invaild']);
        }

         $token = $user->createToken('windiToken')->accessToken;
         return $token;
     }

      public function test_create_articles()
    {
       
        $token = $this->authenticate();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.  $token,
        ])->json('POST','/api/v1/articles',[
            'title' => 'coba title',
            'content' => 'coba content',
            'image' => 'iamge.jpg',
            'user_id' => User::factory()->create()->id,
            'category_id' => Categories::factory()->create()->id
        ]);

      
        $response->assertStatus(200);

    }

    public function test_update_articles()
    {

        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('PUT','/api/v1/articles/1',[
            'title' => fake()->name(),
            'content' => fake()->sentence(),
            'image' => 'iamge.jpg',
            'user_id' => User::factory()->create()->id,
            'category_id' => Categories::factory()->create()->id
        ]);


        $response->assertStatus(200);
    }

    public function test_find_articles()
     {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','/api/v1/articles/1');


        $response->assertStatus(200);
    }


      public function test_get_all_articles()
    {
        $token = $this->authenticate();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','/api/v1/articles');

        $response->assertStatus(200);
     }

      public function test_delete_articles()
    {
        $token = $this->authenticate();
        $task = $this->articles;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('DELETE','/api/v1/articles/' .  $task->id);

        $this->assertDatabaseMissing('articles', $task->toArray());
        $response->assertStatus(200);
    }

    

}
