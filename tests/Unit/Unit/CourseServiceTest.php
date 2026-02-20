<?php

namespace Tests\Unit;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use App\Services\CourseService;

class CourseServiceTest extends TestCase {
    use RefreshDatabase;

    protected CourseService $courseService;

    protected function setUp(): void{
        parent::setUp();
        $this->courseService = new CourseService;
    }

    #[Test]
    public function test_create_course(){
        $teacher = User::factory()->create(['role' => 'teacher']);
        $data = [
            'title' => 'Gel101',
            'description' => 'Domestic Minerology',
            'teacher_id' => $teacher->id,
            'is_published' => true,
            'status' => 'active',
        ];

        $new_course = $this->courseService->createCourse($data);

        $this->assertInstanceOf(Course::class, $new_course);
        $this->assertEquals('Domestic Minerology', $new_course->description);
        $this->assertDatabaseHas('courses', ['title' => 'Gel101']);
    }

    #[Test]
    public function view_published_courses(){
        $teacher = User::factory()->create();
        Course::factory()->create(['is_published' => true, 'teacher_id' => $teacher->id]);
        Course::factory()->create(['is_published' => true, 'teacher_id' => $teacher->id]);

        $publishedCourses = $this->courseService->getAllPublished();

        $this->assertCount(2, $publishedCourses);
        $this->assertTrue((bool) $publishedCourses->first()->is_published);

    }

    #[Test]
    public function remove_course(){
        $teacher = User::factory()->create(['role' => 'teacher']);
        $data = [
            'title' => 'Gel101',
            'description' => 'Domestic Minerology',
            'teacher_id' => $teacher->id,
            'is_published' => true,
            'status' => 'active',
        ];

        $new_course = $this->courseService->createCourse($data);


        $this->assertDatabaseCount('courses', 1);
        $this->courseService->deleteCourse($new_course);
        $this->assertDatabaseMissing('courses', $data);

    }

     #[Test]
    public function update_course(){
        $teacher = User::factory()->create(['role' => 'teacher']);
        $data = [
            'title' => 'Gel101',
            'description' => 'Domestic Minerology',
            'teacher_id' => $teacher->id,
            'is_published' => true,
            'status' => 'active',
        ];

        $course = $this->courseService->createCourse($data);
        $this->assertDatabaseCount('courses', 1);

        $updateData = [
            'title' => 'Advanced Geology',
            'description' => 'Advanced Rock Formations',
        ];

        $updatedCourse = $this->courseService->updateCourse($course, $updateData);

        $this->assertEquals('Advanced Rock Formations', $updatedCourse->description);
        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'title' => 'Advanced Geology',
            'description' => 'Advanced Rock Formations',
        ]);

        $this->assertDatabaseMissing('courses', [
            'title' => 'Gel101',
        ]);


    }

    #[Test]
    public function it_records_audit_information()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);

        $this->actingAs($teacher);

        $course = $this->courseService->createCourse([
            'title' => 'Audit Test',
            'description' => 'Testing BaseAudit',
            'teacher_id' => $teacher->id,
            'is_published' => true
        ]);

        $this->assertEquals($teacher->id, $course->created_by);
        $this->assertEquals($teacher->id, $course->updated_by);
        $this->assertNotNull($course->created_at); // This is your createDate
    }





}
