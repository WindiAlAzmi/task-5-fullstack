<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class PassportAuthTest extends TestCase
{
   // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_register()
    {
     
      
        $response = $this->json('POST', '/api/v1/users/register', [
            'name'  =>  'Test',
            'email'  =>  time().'test@example.com',
            'password'  =>   '123456789',
        ]);
    
            $response->assertStatus(200);
            $response->assertJsonFragment(['success'  => true, 'name' => 'Test']);
        }


        public function test_login(){
    
         User::create([
            'name'=> 'coba',
            'email'=>  $email = time().'@example.com',
            'password' =>   bcrypt('123456789')
        ]);

    
        $response = $this->json('POST', '/api/v1/users/login' ,[
            'email' => $email,
            'password' => 123456789
        ]);

        $response->assertStatus(200);

        User::where('email','test@gmail.com')->delete();

        }
}
