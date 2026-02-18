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

    public function to_create_course_by_teacher(){
        $teacher = User::factory()->create(['role' => 'teacher']);
        $response = $this->actingAs($teacher, 'sanctum')->postJson('/api/courses',[
            'title' => 'Creating a course',
            'description' => 'learning managenment system',
            'teacher_id' => $teacher->id,
            'is_published' => true,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('courses', ['title' => 'Laravel Testing']);
    }
    
}
