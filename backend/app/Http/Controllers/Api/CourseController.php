<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // جلب كل الكورسات مع بيانات المدرس
    public function index()
    {
        $courses = Course::with('instructor')->get();

        $courses = $courses->map(function ($course) {
            return [
                'id' => $course->id,
                'title' => $course->title,
                'description' => $course->description,
                'price' => $course->price,
                'rating' => $course->rating,
                'image' => $course->image,
                'is_featured' => $course->is_featured,
                'instructor_id' => $course->instructor_id,
                'instructor' => $course->instructor ? [
                    'id' => $course->instructor->id,
                    'name' => $course->instructor->name,
                    'avatar' => $course->instructor->avatar ? asset('storage/' . $course->instructor->avatar) : null,
                    'specialization' => $course->instructor->specialization,
                    'rating' => $course->instructor->rating,
                ] : null
            ];
        });

        return response()->json($courses);
    }
    // جلب الكورسات المميزة مع بيانات المدرس
    public function featured()
    {
        $courses = Course::with('instructor')->where('is_featured', true)->get();

        $courses = $courses->map(function ($course) {
            return [
                'id' => $course->id,
                'title' => $course->title,
                'description' => $course->description,
                'price' => $course->price,
                'rating' => $course->rating,
                'image' => $course->image,
                'is_featured' => $course->is_featured,
                'instructor' => $course->instructor ? [
                    'id' => $course->instructor->id,
                    'name' => $course->instructor->name,
                    'avatar' => $course->instructor->avatar ? asset('storage/' . $course->instructor->avatar) : null,
                    'specialization' => $course->instructor->specialization,
                    'rating' => $course->instructor->rating,
                ] : null
            ];
        });

        return response()->json($courses);
    }

    // جلب كورس واحد مع بيانات المدرس
    public function show($id)
    {
        $course = Course::with('instructor')->find($id);

        if (!$course) {
            return response()->json(['message' => 'الكورس غير موجود'], 404);
        }

        $data = [
            'id' => $course->id,
            'title' => $course->title,
            'description' => $course->description,
            'price' => $course->price,
            'rating' => $course->rating,
            'image' => $course->image,
            'is_featured' => $course->is_featured,
            'instructor' => $course->instructor ? [
                'id' => $course->instructor->id,
                'name' => $course->instructor->name,
                'avatar' => $course->instructor->avatar ? asset('storage/' . $course->instructor->avatar) : null,
                'bio' => $course->instructor->bio,
                'specialization' => $course->instructor->specialization,
                'rating' => $course->instructor->rating,
                'experience_years' => $course->instructor->experience_years,
            ] : null
        ];

        return response()->json($data);
    }
}
