<?php

namespace Tests\Unit;

use App\Services\SubmissionService;
use App\Models\User;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SubmissionServiceTest extends TestCase
{
    use RefreshDatabase;

    protected SubmissionService $submissionService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->submissionService = new SubmissionService;
    }

    #[Test]
    public function test_to_create_submission(): void
    {

        $student = User::factory()->create(['role' => 'student']);
        $assignment = Assignment::factory()->create();

        Storage::fake('public');
        $file = UploadedFile::fake()->create('assignment_solution.pdf', 100);

        $this->actingAs($student);

           $data = [
            'assignment_id' => $assignment->id,
            'student_id'    => $student->id,
            'grade'         => null,
            'teacher_feedback' => null,
            'submitted_at'  => now(),
        ];

        $submission = $this->submissionService->createSubmission($data, $file);

        $this->assertInstanceOf(Submission::class, $submission);
        $this->assertDatabaseHas('submissions', [
            'assignment_id' => $assignment->id,
            'user_id'       => $student->id,
        ]);
        $this->assertNull($submission->teacher_feedback);
        $this->assertNull($submission->grade);
        $this->assertEquals($student->id, $submission->user_id);
    }

    #[Test]
    public function test_to_grade_submission(){

        $student = User::factory()->create(['role' => 'student']);
        $assignment = Assignment::factory()->create();


        $submission = Submission::create([
            'assignment_id' => $assignment->id,
            'user_id'       => $student->id,
            'student_id'    => $student->id,
            'file_url'      => 'submissions/test.pdf',
            'submitted_at'  => now(),
            'grade'         => null,
        ]);


        $grade = 85;
        $feedback = "Great work on the implementation!";

        $result = $this->submissionService->gradeSubmission($submission, $grade, $feedback);


        $this->assertTrue($result);
        $this->assertEquals(85, $submission->fresh()->grade);

        $this->assertDatabaseHas('submissions', [
            'id' => $submission->id,
            'grade' => 85,
            'teacher_feedback' => $feedback
        ]);
    }
}
