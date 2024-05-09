<?php

namespace Tests\Feature\Auth;
use App\Models\User;
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


}
