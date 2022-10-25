<?php

namespace Tests;

use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;


abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
 
    protected function createPersonalClient()
    {
        Passport::$hashesClientSecrets = false;

        $this->artisan(
            'passport:client',
            ['--name' => config('app.name'), '--personal' => null]
        );

        // use the query builder instead of the model, to retrieve the client secret
        return DB::table('oauth_clients')
            ->where('personal_access_client','=',true)
            ->first();
    }

     

}
