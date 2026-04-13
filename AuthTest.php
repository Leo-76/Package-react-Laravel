<?php

namespace YourVendor\LaravelReactAuth\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase;
use YourVendor\LaravelReactAuth\LaravelReactAuthServiceProvider;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app): array
    {
        return [LaravelReactAuthServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
        ]);
        $app['config']->set('react-auth.user_model', \App\Models\User::class);
        $app['config']->set('react-auth.allow_registration', true);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__ . '/../../src/database/migrations');
    }

    public function test_login_page_renders(): void
    {
        $response = $this->get(route('react-auth.login'));
        $response->assertStatus(200);
    }

    public function test_register_page_renders(): void
    {
        $response = $this->get(route('react-auth.register'));
        $response->assertStatus(200);
    }

    public function test_user_can_register(): void
    {
        $response = $this->post(route('react-auth.register.post'), [
            'name'                  => 'Jane Doe',
            'email'                 => 'jane@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('react-auth.dashboard'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'jane@example.com']);
    }

    public function test_registration_validates_required_fields(): void
    {
        $response = $this->post(route('react-auth.register.post'), []);
        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_user_can_login(): void
    {
        $user = \App\Models\User::create([
            'name'     => 'Test User',
            'email'    => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post(route('react-auth.login.post'), [
            'email'    => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('react-auth.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_wrong_credentials(): void
    {
        $response = $this->post(route('react-auth.login.post'), [
            'email'    => 'nobody@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = \App\Models\User::create([
            'name'     => 'Test User',
            'email'    => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)->get(route('react-auth.dashboard'));
        $response->assertStatus(200);
    }

    public function test_unauthenticated_user_redirected_from_dashboard(): void
    {
        $response = $this->get(route('react-auth.dashboard'));
        $response->assertRedirect(route('react-auth.login'));
    }

    public function test_user_can_logout(): void
    {
        $user = \App\Models\User::create([
            'name'     => 'Test User',
            'email'    => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user)
             ->post(route('react-auth.logout'))
             ->assertRedirect(route('react-auth.login'));

        $this->assertGuest();
    }

    public function test_registration_disabled_when_config_false(): void
    {
        config(['react-auth.allow_registration' => false]);

        $this->get(route('react-auth.register'))->assertStatus(403);
        $this->post(route('react-auth.register.post'), [])->assertStatus(403);
    }
}
