<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function showLoginPage()
    {
        $response = $this->get('/auth/login');
        $response->assertStatus(200);
    }
    
    /** @test */
    public function guestCanLogin(){
        
        //$this->withoutExceptionHandling();
        
        $email = factory(User::class)->create()->first()->email;
        
        $response = $this->post('/auth/login', [
            'email' => $email,
            'password' => 'password'
        ]);
        
        $response->assertOk();
    }
    
    /** @test */
    public function authenticatedUserCannotChangeSessionWhileLoggedIn(){
        
        $user = factory(User::class, 2)->create();
        $response = $this->actingAs($user[0])->post('/auth/login', [
            'email' => $user[1]->email,
            'password' => 'password'
        ]);
        
        //$response->assert
        $this->assertAuthenticatedAs($user[0]);
        
    }
    
    /** @test */
    public function loginEmailIsRequired(){
        $response = $this->post('/auth/login', [
            'email' => '',
            'password' => 'password',
        ]);
        
        $response->assertSessionHasErrors('email');
    }
    
    /** @test */
    public function loginPasswordIsRequired(){
        $response = $this->post('/auth/login', [
            'email' => 'random@email.com',
            'password' => '',
        ]);
        
        $response->assertSessionHasErrors('password');
    }
    
    /** @test */
    public function loginPasswordShouldBeAtleast6Characters(){
        $response = $this->post('/auth/login', [
            'email' => 'random@email.com',
            'password' => '12345'
        ]);
        
        $response->assertSessionHasErrors('password');
    }
    
    /** @test */
    public function authenticatedUserCanLogout(){
        
        $user = factory(User::class)->create();
        
        $response = $this->actingAs($user)->post('/auth/logout');
        
        $this->assertGuest();
        
    }
    
}
