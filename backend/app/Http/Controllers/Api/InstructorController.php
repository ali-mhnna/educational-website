<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    // عرض كل المدرسين
    public function index()
    {
        $instructors = Instructor::withCount('courses')->get();

        
        $instructors = $instructors->map(function ($instructor) {
            return [
                'id' => $instructor->id,
                'name' => $instructor->name,
                'avatar' => $instructor->avatar ? asset('storage/' . $instructor->avatar) : null,
                'bio' => $instructor->bio,
                'specialization' => $instructor->specialization,
                'rating' => $instructor->rating,
                'experience_years' => $instructor->experience_years,
                'courses_count' => $instructor->courses_count,
            ];
        });

        return response()->json($instructors);
    }

    // عرض مدرس واحد مع كورساته
    public function show($id)
    {
        $instructor = Instructor::with('courses')->find($id);

        if (!$instructor) {
            return response()->json(['message' => 'المدرس غير موجود'], 404);
        }

      
        $data = [
            'id' => $instructor->id,
            'name' => $instructor->name,
            'avatar' => $instructor->avatar ? asset('storage/' . $instructor->avatar) : null,
            'bio' => $instructor->bio,
            'specialization' => $instructor->specialization,
            'rating' => $instructor->rating,
            'experience_years' => $instructor->experience_years,
            'courses' => $instructor->courses->map(function ($course) {
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'description' => $course->description,
                    'price' => $course->price,
                    'rating' => $course->rating,
                    'image' => $course->image,
                    'is_featured' => $course->is_featured,
                ];
            })
        ];

        return response()->json($data);
    }
}
