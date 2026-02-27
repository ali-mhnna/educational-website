<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    // تسجيل الطالب بكورس
    public function enroll(Request $request, $courseId)
    {
        $user = $request->user();
        $course = Course::findOrFail($courseId);

        // التحقق: هل مسجل مسبقاً؟
        if ($course->isEnrolledBy($user->id)) {
            return response()->json([
                'message' => 'أنت مسجل مسبقاً في هذا الكورس'
            ], 400);
        }

        // التسجيل
        $user->courses()->attach($courseId, [
            'enrolled_at' => now()
        ]);

        return response()->json([
            'message' => 'تم التسجيل بنجاح! 🎉',
            'enrolled' => true
        ]);
    }

    // إلغاء التسجيل
    public function unenroll(Request $request, $courseId)
    {
        $user = $request->user();
        $course = Course::findOrFail($courseId);

       
        if (!$course->isEnrolledBy($user->id)) {
            return response()->json([
                'message' => 'أنت غير مسجل في هذا الكورس'
            ], 400);
        }

        // الإلغاء
        $user->courses()->detach($courseId);

        return response()->json([
            'message' => 'تم إلغاء التسجيل',
            'enrolled' => false
        ]);
    }

    // كورسات الطالب
    public function myCourses(Request $request)
    {
        $user = $request->user();
        
        $courses = $user->courses()
                        ->with('instructor')
                        ->get();

        return response()->json($courses);
    }

    // التحقق: هل مسجل بكورس معين؟
    public function checkEnrollment(Request $request, $courseId)
    {
        $user = $request->user();
        $course = Course::findOrFail($courseId);

        return response()->json([
            'enrolled' => $course->isEnrolledBy($user->id)
        ]);
    }

    // الطلاب المسجلين بكورس (للأدمن)
    public function courseStudents($courseId)
    {
        $course = Course::with('users')->findOrFail($courseId);

        return response()->json([
            'course' => $course->title,
            'students_count' => $course->users->count(),
            'students' => $course->users
        ]);
    }

    // عرض كل الكورسات مع عدد المسجلين
public function allCoursesWithEnrollments()
{
    $courses = Course::withCount('users')->with('instructor')->get();
    
    return response()->json($courses);
}
}