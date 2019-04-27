<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Testmodule as Module;

class Testmodule extends TestCase
{

	public function getToken($access_token = false)
    {
        $body = [
            'client_id' => 1,
            'client_secret' => '0dH7UpeOXhwmgGwbQYUsSUtgZzGAmctiD7v4xsgR',
            'grant_type' => 'client_credentials',
            'scope' => '*'
        ];

        $response = $this->post('/oauth/token',$body,['Accept' => 'application/json']); 
        if($access_token) {
            return json_decode($response->getContent())->access_token;
        }
        return $response;
    }
    
    /**
     * @group testmodule-list
     */
    public function testIndex(){
        
        $response = $this->get('api/testmodules',
                        [
                            'Accept' => 'application/json',
                            'Authorization' => "Bearer ".$this->getToken(true)
                        ]
                    );
        $response->assertSeeText(200);
    }

    /**
     * @group testmodule-store
     */
    public function testStore(){
        $body =  [        
                    'name' => 'Test-Case',
						        
                ];

        $response = $this->post('/api/testmodule/store',$body,
                        [
                            'Accept' => 'application/json',
                            'Authorization' => "Bearer ".$this->getToken(true)
                        ]
                    );
        $response->assertSeeText('Test Module Created!');
    }

    /**
     * @group testmodule-edit
     */
    public function testEdit(){

        $model = Module::orderBy('id', 'desc')->first();

        $response = $this->get('api/testmodule/edit/'.$model->id,
                        [
                            'Accept' => 'application/json',
                            'Authorization' => "Bearer ".$this->getToken(true)
                        ]
                    );
        $response->assertSeeText(200);
    }

    /**
     * @group testmodule-update
     */
    public function testUpdate(){

        $model = Module::orderBy('id', 'desc')->first();

        $body =  [        
                    'name' => 'Test-Case',
						
                    'id' => $model->id,        
                ];

        $response = $this->post('/api/testmodule/update',$body,
                        [
                            'Accept' => 'application/json',
                            'Authorization' => "Bearer ".$this->getToken(true)
                        ]
                    );
        $response->assertSeeText('Test Module Updated!');
    }

    /**
     * @group testmodule-delete
     */
    public function testDelete(){

        $model = Module::orderBy('id', 'desc')->first();

        $response = $this->get('api/testmodule/destroy/'.$model->id,
                        [
                            'Accept' => 'application/json',
                            'Authorization' => "Bearer ".$this->getToken(true)
                        ]
                    );
        $response->assertSeeText('Test Module Deleted!');
    }
}
