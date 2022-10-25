<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Categories;

class PassportCategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
     protected function setUp(): void
    {
        parent::setUp();
        $this->category = Categories::factory()->create();
     
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

      public function test_create_category()
    {
       
        $token = $this->authenticate();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.  $token,
        ])->json('POST','/api/v1/categories',[
            'name'  => fake()->word(),
            'user_id' => User::factory()->create()->id,
        ]);

        $response->assertStatus(200);

    }

      public function test_update_category()
    {

        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('PUT','/api/v1/categories/1',[
            'name' => fake()->word(),
            'user_id' => User::factory()->create()->id,
        ]);


        $response->assertStatus(200);
    }

    public function test_find_category()
     {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','/api/v1/categories/1');


        $response->assertStatus(200);
    }


      public function test_get_all_category()
    {
        $token = $this->authenticate();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','/api/v1/categories');

        $response->assertStatus(200);
     }

      public function test_delete_categories()
    {
        $token = $this->authenticate();
        $task = $this->category;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('DELETE','/api/v1/categories/' . $task->id);

        $this->assertDatabaseMissing('categories', $task->toArray());
        $response->assertStatus(200);

    }

}
