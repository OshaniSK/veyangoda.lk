<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_is_available_at_both_dashboard_urls(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        foreach (['/admin/dashboard', '/admin'] as $url) {
            $this->actingAs($admin)
                ->get($url)
                ->assertOk()
                ->assertSee('Dashboard Overview')
                ->assertSee('Total Users');
        }
    }
}
