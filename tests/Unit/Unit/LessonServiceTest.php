<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\LessonService;
use PHPUnit\Framework\Attributes\Test;


class LessonServiceTest extends TestCase {
    use RefreshDatabase;

    protected LessonService $lessonService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->lessonService = new LessonService;
    }


    #[Test]
    public function test_create_lesson(): void{
        $course = Course::factory()->create();
        $data = [
            'course_id' => $course->id,
            'title' => 'Gel212',
            'content_url' => 'hthjgf',
        ];

        $lesson = $this->lessonService->createLesson($data);

        $this->assertInstanceOf(Lesson::class, $lesson);
        $this->assertDatabaseHas('lessons',
            ['title' => 'Gel212',
            'course_id' => $course->id
        ]
        );
    }
}
