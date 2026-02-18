<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LmsTest extends TestCase{
     use RefreshDatabase;

    public function to_create_userBy_admin()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin, 'sanctum')->postJson('api/admin/create-user', [
            'name' => 'Mukhtar',
            'email' => 'Mukhtar001@t.com',
            'password' => '000000123',
            'role' => 'teacher',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'Mukhtar001@t.com']);
    }
}
