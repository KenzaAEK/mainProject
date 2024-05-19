<?php


namespace Tests\Feature\Auth;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create([
            'email' => 'sylla@aly',
            'password' => bcrypt('password'),
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'sylla@aly',
        ]);
        $response = $this->postJson('/api/login', [
            'email' => 'sylla@aly',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticated();
        // $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }


     /** @test */
     public function user_can_register()
     {
         $response = $this->postJson('/api/register', [
             'nom' => 'John',
             'prenom' => 'Doe',
             'email' => 'john.doe@example.com',
             'tel' => '1234567890',
             'password' => 'password123',
             'password_confirmation' => 'password123',
            //  'password_confirmation'=> '111111111111111111',
         ]);
 
         $response->assertStatus(200);
         $response->assertJson([
             'message' => 'Inscription réussie. :)'
         ]);
         $this->assertDatabaseHas('users', [
             'email' => 'john.doe@example.com'
         ]);
     }
 
     /** @test */
     public function user_can_not_register_with_existing_email()
     {
         User::create([
             'nom' => 'John',
             'prenom' => 'Doe',
             'email' => 'john.doe@example.com',
             'tel' => '1234567890',
             'password' => bcrypt('password123')
         ]);
 
         $response = $this->postJson('/api/register', [
             'nom' => 'Jane',
             'prenom' => 'Doe',
             'email' => 'john.doe@example.com',
             'tel' => '0987654321',
             'password' => 'password123',
             'password_confirmation' => 'password123',
         ]);
 
         $response->assertStatus(409);
         $response->assertJson([
             'message' => 'Un utilisateur avec cet email existe déjà. :('
         ]);
     }
 
     /** @test */
     public function user_cannot_login_with_invalid_credentials()
     {
         $response = $this->postJson('/api/login', [
             'email' => 'john.doe@example.com',
             'password' => 'wrongpassword'
         ]);
 
         $response->assertStatus(401);
         $response->assertJson([
             'message' => 'Les informations d\'identification ne correspondent pas. :('
         ]);
     }
 
     /** @test */
     public function user_can_logout()
     {
         $user = User::factory()->create();
 
         $token = $user->createToken('token-name')->plainTextToken;
         $response = $this->withHeaders([
             'Authorization' => 'Bearer ' . $token,
         ])->postJson('/api/logout');
 
         $response->assertStatus(200);
         $response->assertJson([
             'message' => 'Déconnecté avec succès et jeton supprimé. :)'
         ]);
     }
 
     /** @test */
    //  public function user_can_refresh_token()
    //  {
    //      $user = User::factory()->create();
 
    //      $token = $user->createToken('token-name')->plainTextToken;
    //      $response = $this->withHeaders([
    //          'Authorization' => 'Bearer ' . $token,
    //      ])->postJson('/api/refreshToken');
 
    //      $response->assertStatus(200);
    //      $response->assertJson([
    //          'message' => 'Jeton rafraîchi avec succès. :)'
    //      ]);
    //  }


     /** @test */
    public function registration_requires_valid_data()
    {
        $response = $this->postJson('/api/register', [
            'nom' => '', // Intentionally left blank to test validation
            'prenom' => '', // Intentionally left blank to test validation
            'email' => 'not-an-email', // Invalid email to test validation
            'tel' => '', // Intentionally left blank to test validation
            'password' => '123' // Too short to be valid
        ]);

        $response->assertStatus(422); // HTTP 422 Unprocessable Entity
        $response->assertJsonValidationErrors(['nom', 'prenom', 'email', 'tel', 'password']);
    }

    /** @test */
    public function login_fails_with_no_data_provided()
    {
        $response = $this->postJson('/api/login', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'password']);
    }

    /** @test */
    public function logout_fails_if_user_is_not_logged_in()
    {
        $response = $this->postJson('/api/logout');

        $response->assertStatus(401); // HTTP 401 Unauthorized
    }

    /** @test */
    // public function cannot_refresh_token_without_authentication()
    // {
    //     $response = $this->postJson('/api/refreshToken');

    //     $response->assertStatus(401); // Expecting authorization failure
    // }

    /** @test */
    public function user_registration_and_automatic_login()
    {
        $response = $this->postJson('/api/register', [
            'nom' => 'Jane',
            'prenom' => 'Smith',
            'email' => 'jane.smith@example.com',
            'tel' => '9876543210',
            'password' => 'securePassword',
            'password_confirmation' => 'securePassword',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Inscription réussie. :)'
        ]);

        // Assuming the user is automatically logged in after registration
        $user = User::where('email', 'jane.smith@example.com')->first();
        $this->assertNotNull($user->tokens->first(), "Token is not created.");
    }

    /** @test */
    public function multiple_logins_generate_multiple_tokens()
    {
        $user = User::factory()->create([
            'email' => 'example@example.com',
            'password' => bcrypt('password')
        ]);

        // First login
        $response1 = $this->postJson('/api/login', [
            'email' => 'example@example.com',
            'password' => 'password'
        ]);
        $token1 = $response1->getData()->data->token;

        // Second login
        $response2 = $this->postJson('/api/login', [
            'email' => 'example@example.com',
            'password' => 'password'
        ]);
        $token2 = $response2->getData()->data->token;

        $this->assertNotEquals($token1, $token2, "Tokens should be different for different login sessions.");
    }


        /** @test */
        // public function tokens_respect_user_permissions()
        // {
        //     $admin = User::factory()->create(['role' => '2']); // Assuming 2 is the admin role
        //     $adminToken = $admin->createToken('admin-token')->plainTextToken;
        
        //     $response = $this->withHeaders([
        //         'Authorization' => 'Bearer ' . $adminToken,
        //     ])->get('/api/admin-only-route');
        
        //     $response->assertStatus(200); // Only admins should be able to access
        // }
        
        /** @test */
        // public function expired_tokens_cannot_be_used()
        // {
        //     $user = User::factory()->create();
        //     $expiredToken = $user->createToken('expired-token', ['*'], now()->subMinutes(30))->plainTextToken;
        
        //     $response = $this->withHeaders([
        //         'Authorization' => 'Bearer ' . $expiredToken,
        //     ])->get('/api/protected-route');
        
        //     $response->assertStatus(401);
        // }
        
        /** @test */
        public function registration_handles_special_characters_in_input()
        {
            $response = $this->postJson('/api/register', [
                'nom' => 'O\'Reilly',
                'prenom' => 'Ana-María',
                'email' => 'test+email@example.com',
                'tel' => '1234567890',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ]);
        
            $response->assertStatus(200);
            $this->assertDatabaseHas('users', [
                'email' => 'test+email@example.com'
            ]);
        }
        
        /** @test */
        // public function password_change_logs_out_from_all_devices()
        // {
        //     $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        //     $token1 = $user->createToken('token1')->plainTextToken;
        //     $token2 = $user->createToken('token2')->plainTextToken;
        
        //     // User changes password
        //     $this->actingAs($user)->postJson('/api/change-password', [
        //         'old_password' => 'oldpassword',
        //         'new_password' => 'newpassword',
        //         'new_password_confirmation' => 'newpassword'
        //     ]);
        
        //     // Both tokens should be invalidated
        //     $response1 = $this->withHeaders(['Authorization' => 'Bearer ' . $token1])->get('/api/protected-route');
        //     $response2 = $this->withHeaders(['Authorization' => 'Bearer ' . $token2])->get('/api/protected-route');
        
        //     $response1->assertStatus(401);
        //     $response2->assertStatus(401);
        // }
        
        /** @test */
        // public function brute_force_login_attempts_are_prevented()
        // {
        //     $user = User::factory()->create([
        //         'email' => 'user@example.com',
        //         'password' => bcrypt('correctpassword')
        //     ]);
        
        //     // Simulate 5 failed login attempts
        //     for ($i = 0; $i < 5; $i++) {
        //         $this->post('/login', [
        //             'email' => $user->email,
        //             'password' => 'wrong-password'
        //         ]);
        //     }
        
        //     // Now attempt with correct credentials
        //     $response = $this->post('/login', [
        //         'email' => $user->email,
        //         'password' => 'correctpassword'
        //     ]);
        
        //     // Expecting lock out or some kind of rate limiting response
        //     $response->assertStatus(429); // Assuming

        // }

 /**
 * @dataProvider invalidRegistrationDataProvider
 */
public function test_registration_with_invalid_inputs($data, $expectedErrorFields)
{
    $response = $this->postJson('/api/register', $data);
    $response->assertStatus(422);
    $response->assertJsonValidationErrors($expectedErrorFields);
}

public function invalidRegistrationDataProvider()
{
    return [
        'empty fields' => [
            [
                'nom' => '',
                'prenom' => '',
                'email' => '',
                'tel' => '',
                'password' => '',
                'password_confirmation' => ''
            ],
            ['nom'=>[
                'The nom field is required.',
            ], 'prenom'=>[
                'The prenom field is required.',
            ], 'email'=>[
                'The email field is required.',
            ], 'tel'=>[
                'The tel field is required.',
            ], 'password'=>[
                'The password field is required.',
            ]]
        ],
        'invalid email' => [
            [
                'nom' => 'John',
                'prenom' => 'Doe',
                'email' => 'not-an-email',
                'tel' => '1234567890',
                'password' => 'password123',
                'password_confirmation' => 'password123'
            ],
            ['email'=>[
                'The email must be a valid email address.',
            ]]
        ],
        'password mismatch' => [
            [
                'nom' => 'John',
                'prenom' => 'Doe',
                'email' => 'john.doe@example.com',
                'tel' => '1234567890',
                'password' => 'password123',
                'password_confirmation' => 'password321'
            ],
            ['password'=>[
                'The password confirmation does not match.',
            ]]
        ],
    ];
}


/** @test */
// public function user_can_login_with_correct_metadata_and_receive_token()
// {
//     // Create a mock for the User model
//     $user = Mockery::mock('App\Models\User');
//     $user->shouldReceive('createToken')->andReturn((object)['plainTextToken' => 'mocked-token']);

//     // Mock the Auth facade methods
//     Auth::shouldReceive('attempt')
//         ->once()
//         ->with(['email' => 'example@example.com', 'password' => 'validpassword'])
//         ->andReturn(true);
    
//     Auth::shouldReceive('user')->andReturn($user);
//     Auth::shouldReceive('userResolver')->andReturn(function() use ($user) {
//         return $user;
//     });

//     // Making the API call
//     $response = $this->postJson('/api/login', [
//         'email' => 'example@example.com',
//         'password' => 'validpassword'
//     ]);

//     // Assertions
//     $response->assertStatus(200);
//     $response->assertJson(['token' => 'mocked-token']);
//     $this->assertAuthenticated();
// }


/**
 * @dataProvider loginDataProvider
 */
// public function test_login_responses_based_on_credentials($credentials, $expectedStatus)
// {
//     Auth::shouldReceive('attempt')->with($credentials)->andReturn($expectedStatus == 200);

//     if ($expectedStatus == 200) {
//         $user = User::factory()->make($credentials);
//         Auth::shouldReceive('user')->andReturn($user);
//         $mockToken = 'mocked-token';
//         $user->shouldReceive('createToken')->andReturn((object)['plainTextToken' => $mockToken]);
//     }

//     $response = $this->postJson('/api/login', $credentials);
//     $response->assertStatus($expectedStatus);

//     if ($expectedStatus == 200) {
//         $response->assertJson(['token' => 'mocked-token']);
//         $this->assertAuthenticated();
//     } else {
//         $this->assertGuest();
//     }
// }

// public function loginDataProvider()
// {
//     return [
//         'correct credentials' => [[
//             'email' => 'user@example.com',
//             'password' => 'correctpassword'
//         ], 200],
//         'incorrect password' => [[
//             'email' => 'user@example.com',
//             'password' => 'wrongpassword'
//         ], 401],
//         'non-existent user' => [[
//             'email' => 'nonexistent@example.com',
//             'password' => 'any'
//         ], 401],
//     ];
// }

// }
}