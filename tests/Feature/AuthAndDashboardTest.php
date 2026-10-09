<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAndDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_registration_assigns_user_role_and_redirects_to_dashboard(): void
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'Password123!@#',
            'password_confirmation' => 'Password123!@#',
            'math_num1' => 5,
            'math_num2' => 7,
            'math_answer' => 12,
        ]);

        $response->assertRedirect('/dashboard');

        $user = User::where('email', 'john@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('user', $user->role);
    }

    public function test_user_cannot_access_admin_panel_and_is_redirected_to_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('error');
    }

    public function test_user_can_access_user_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSeeText($user->name);
    }

    public function test_agent_can_access_admin_panel(): void
    {
        $agent = User::factory()->create([
            'role' => 'agent',
        ]);

        $response = $this->actingAs($agent)->get('/admin');

        $response->assertStatus(200);
    }

    public function test_check_email_endpoint_detects_available_email(): void
    {
        $response = $this->postJson('/check-email', [
            'email' => 'newuser@example.com',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'valid' => true,
                'available' => true,
                'reason' => 'available',
            ]);
    }

    public function test_check_email_endpoint_detects_invalid_format(): void
    {
        $response = $this->postJson('/check-email', [
            'email' => 'invalid-email-format',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'valid' => false,
                'available' => false,
                'reason' => 'format',
            ]);
    }

    public function test_check_email_endpoint_detects_existing_email(): void
    {
        User::factory()->create([
            'email' => 'existing@example.com',
        ]);

        $response = $this->postJson('/check-email', [
            'email' => 'existing@example.com',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'valid' => true,
                'available' => false,
                'reason' => 'exists',
            ]);
    }

    public function test_registration_fails_if_email_already_registered(): void
    {
        User::factory()->create([
            'email' => 'duplicate@example.com',
        ]);

        $response = $this->from('/register')->post('/register', [
            'name' => 'Jane Doe',
            'email' => 'duplicate@example.com',
            'password' => 'Password123!@#',
            'password_confirmation' => 'Password123!@#',
            'math_num1' => 2,
            'math_num2' => 3,
            'math_answer' => 5,
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_admin_can_view_all_users_in_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        $customer = User::factory()->create([
            'name' => 'Regular Customer',
            'role' => 'user',
        ]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSeeText('All Users & Administrators');
        $response->assertSeeText($customer->name);
    }

    public function test_admin_can_update_user_role(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        $targetUser = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($admin)->patch("/admin/users/{$targetUser->id}/role", [
            'role' => 'agent',
        ]);

        $response->assertRedirect();
        $this->assertEquals('agent', $targetUser->fresh()->role);
    }

    public function test_admin_can_delete_user_account(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);
        $targetUser = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($admin)->delete("/admin/users/{$targetUser->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('users', [
            'id' => $targetUser->id,
        ]);
    }

    public function test_admin_cannot_delete_own_account(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->delete("/admin/users/{$admin->id}");

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
        ]);
    }
}
