<?php

namespace Tests\Unit\Unit;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\User;
use App\Models\Lesson;
use App\Services\AssignmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;


class AssignmentServiceTest extends TestCase
{

    use RefreshDatabase;

    protected AssignmentService $assignmentService;

    protected function setUp(): void{
        parent::setUp();
        $this->assignmentService = new AssignmentService;
    }

    #[Test]
    public function test_to_create_assignment(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $course = Course::factory()->create(['teacher_id' => $teacher->id]);
        $data = [
            'course_id' => $course->id,
            'title' => 'Gel234',
            'description' => 'descriptive mineralogy',
            'due_date' => '2026-12-23',
        ];

        $assignment = $this->assignmentService->createAssignment($data);

        $this->assertInstanceOf(Assignment::class, $assignment);
        $this->assertDatabaseHas('assignments', [
        'title' => 'Gel234',
        'course_id' => $course->id
        ]);

    }

    #[Test]
    public function test_to_update_assignment(){
        $course = Course::factory()->create();
        $assignment = Assignment::factory()->create([
            'title' => 'Old Title',
            'course_id' => $course->id,
            'due_date' => '2026-01-01'
        ]);

        $updateData = [
            'title' => 'Updated Assignment Title',
            'due_date' => '2026-12-25'
        ];

        $updatedAssignment = $this->assignmentService->updateAssignment($assignment, $updateData);

        $this->assertEquals('Updated Assignment Title', $updatedAssignment->title);
        $this->assertDatabaseHas('assignments', [
            'id' => $assignment->id,
            'title' => 'Updated Assignment Title'
        ]);
    }

    #[Test]
    public function test_to_view_assignment(){
        $course = Course::factory()->create();
        $assignment = Assignment::factory()->create([
            'course_id' => $course->id,
            'title' => 'Mineral Lab'
        ]);

        $details = $this->assignmentService->getAssignmentDetails($assignment->id);

        $this->assertInstanceOf(Assignment::class, $details);
        $this->assertEquals('Mineral Lab', $details->title);
        $this->assertTrue($details->relationLoaded('course'));

        $this->assertEquals($course->id, $details->course->id);

    }
}
