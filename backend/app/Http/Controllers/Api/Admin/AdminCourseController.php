<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class AdminCourseController extends Controller
{
    // إضافة كورس جديد
    public function store(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'غير مصرح لك'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'rating' => 'nullable|numeric|between:0,5',
            'image' => 'required|string',
            'instructor_id' => 'required|exists:instructors,id',
            'is_featured' => 'nullable|boolean',
        ]);

        $course = Course::create($request->all());

        return response()->json([
            'message' => 'تم إضافة الكورس بنجاح',
            'course' => $course
        ], 201);
    }

    // تعديل كورس
    public function update(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'غير مصرح لك'], 403);
        }

        $course = Course::find($id);

        if (!$course) {
            return response()->json(['message' => 'الكورس غير موجود'], 404);
        }

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'rating' => 'sometimes|numeric|between:0,5',
            'image' => 'sometimes|string',
            'instructor_id' => 'sometimes|exists:instructors,id',
            'is_featured' => 'sometimes|boolean',
        ]);

        $course->update($request->all());

        return response()->json([
            'message' => 'تم تحديث الكورس بنجاح',
            'course' => $course
        ]);
    }

    // حذف كورس
    public function destroy(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'غير مصرح لك'], 403);
        }

        $course = Course::find($id);

        if (!$course) {
            return response()->json(['message' => 'الكورس غير موجود'], 404);
        }

        $course->delete();

        return response()->json([
            'message' => 'تم حذف الكورس بنجاح'
        ]);
    }
}
