<?php

namespace Tests\Unit\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Services\EnrollmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class EnrollmentServiceTest extends TestCase {
    use RefreshDatabase;

    protected EnrollmentService $enrollmentService;

    protected function setUp(): void {
        parent::setUp();
        $this->enrollmentService = new EnrollmentService;

    }

    #[Test]
    public function test_enroll_student(): void {
        $student = User::factory()->create(['role' => 'student']);
        $course = Course::factory()->create();

        $enrollment = $this->enrollmentService->enrollStudent($student, $course->id);

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $student->id,
            'course_id' => $course->id,
        ]);

        $this->assertEquals("Welcome to the Course!", $enrollment->message);
    }
}
