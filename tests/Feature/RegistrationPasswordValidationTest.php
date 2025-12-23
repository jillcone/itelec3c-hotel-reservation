<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationPasswordValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_must_meet_complexity_requirements(): void
    {
        // Missing uppercase
        $this->post(route('register'), $this->basePayload(['password' => 'password1!', 'password_confirmation' => 'password1!']))
            ->assertSessionHasErrors(['password']);

        // Missing lowercase
        $this->post(route('register'), $this->basePayload(['password' => 'PASSWORD1!', 'password_confirmation' => 'PASSWORD1!']))
            ->assertSessionHasErrors(['password']);

        // Missing number
        $this->post(route('register'), $this->basePayload(['password' => 'Password!!', 'password_confirmation' => 'Password!!']))
            ->assertSessionHasErrors(['password']);

        // Missing special character
        $this->post(route('register'), $this->basePayload(['password' => 'Password11', 'password_confirmation' => 'Password11']))
            ->assertSessionHasErrors(['password']);

        // Too short
        $this->post(route('register'), $this->basePayload(['password' => 'Pa1!', 'password_confirmation' => 'Pa1!']))
            ->assertSessionHasErrors(['password']);
    }

    public function test_password_that_meets_requirements_allows_registration(): void
    {
        $response = $this->post(route('register'), $this->basePayload([
            'password' => 'ValidPass1!',
            'password_confirmation' => 'ValidPass1!',
        ]));

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success');
        $this->assertAuthenticated();
    }

    private function basePayload(array $overrides = []): array
    {
        return array_merge([
            'full_name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'ValidPass1!',
            'password_confirmation' => 'ValidPass1!',
        ], $overrides);
    }
}
