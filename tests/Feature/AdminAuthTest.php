<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'admin.email' => 'triowash@admin.co.id',
            'admin.password_hash' => Hash::make('triowashadmingacor01'),
        ]);
    }

    public function test_admin_dashboard_requires_login(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'triowash@admin.co.id',
            'password' => 'triowashadmingacor01',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas(config('admin.session_key'), true);
    }

    public function test_admin_login_rejects_invalid_credentials(): void
    {
        $response = $this->from('/admin/login')->post('/admin/login', [
            'email' => 'triowash@admin.co.id',
            'password' => 'password-salah',
        ]);

        $response->assertRedirect('/admin/login');
        $response->assertSessionHasErrors('email');
        $response->assertSessionMissing(config('admin.session_key'));
    }

    public function test_admin_can_logout(): void
    {
        $response = $this
            ->withSession([
                config('admin.session_key') => true,
                config('admin.session_email_key') => 'triowash@admin.co.id',
            ])
            ->post('/admin/logout');

        $response->assertRedirect(route('admin.login'));
        $response->assertSessionMissing(config('admin.session_key'));
        $response->assertSessionMissing(config('admin.session_email_key'));
    }
}
