<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminInstructorController extends Controller
{
    // إضافة مدرس جديد
    public function store(Request $request)
    {
        try {
            // التحقق من الصلاحيات
            if ($request->user()->role !== 'admin') {
                return response()->json(['message' => 'غير مصرح لك'], 403);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'bio' => 'required|string',
                'specialization' => 'required|string|max:255',
                'rating' => 'required|numeric|between:0,5',
                'experience_years' => 'required|integer|min:0',
            ]);

            // رفع الصورة
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('instructors', 'public');
            }

            $instructor = Instructor::create([
                'name' => $validated['name'],
                'bio' => $validated['bio'],
                'specialization' => $validated['specialization'],
                'rating' => $validated['rating'],
                'experience_years' => $validated['experience_years'],
                'avatar' => $avatarPath,
            ]);

            return response()->json([
                'message' => 'تم إضافة المدرس بنجاح',
                'instructor' => $instructor
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'خطأ في البيانات',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'خطأ في الإضافة',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // تعديل مدرس
    public function update(Request $request, $id)
    {
        try {
            if ($request->user()->role !== 'admin') {
                return response()->json(['message' => 'غير مصرح لك'], 403);
            }

            $instructor = Instructor::find($id);

            if (!$instructor) {
                return response()->json(['message' => 'المدرس غير موجود'], 404);
            }

            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'bio' => 'sometimes|string',
                'specialization' => 'sometimes|string|max:255',
                'rating' => 'sometimes|numeric|between:0,5',
                'experience_years' => 'sometimes|integer|min:0',
            ]);

            // تحديث البيانات
            if (isset($validated['name'])) {
                $instructor->name = $validated['name'];
            }
            if (isset($validated['bio'])) {
                $instructor->bio = $validated['bio'];
            }
            if (isset($validated['specialization'])) {
                $instructor->specialization = $validated['specialization'];
            }
            if (isset($validated['rating'])) {
                $instructor->rating = $validated['rating'];
            }
            if (isset($validated['experience_years'])) {
                $instructor->experience_years = $validated['experience_years'];
            }

            // رفع صورة جديدة
            if ($request->hasFile('avatar')) {
                // حذف الصورة القديمة
                if ($instructor->avatar) {
                    Storage::disk('public')->delete($instructor->avatar);
                }

                $avatarPath = $request->file('avatar')->store('instructors', 'public');
                $instructor->avatar = $avatarPath;
            }

            $instructor->save();

            return response()->json([
                'message' => 'تم تحديث المدرس بنجاح',
                'instructor' => $instructor
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'خطأ في التحديث',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // حذف مدرس
    public function destroy(Request $request, $id)
    {
        try {
            if ($request->user()->role !== 'admin') {
                return response()->json(['message' => 'غير مصرح لك'], 403);
            }

            $instructor = Instructor::find($id);

            if (!$instructor) {
                return response()->json(['message' => 'المدرس غير موجود'], 404);
            }

            // حذف الصورة
            if ($instructor->avatar) {
                Storage::disk('public')->delete($instructor->avatar);
            }

            $instructor->delete();

            return response()->json([
                'message' => 'تم حذف المدرس بنجاح'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'خطأ في الحذف',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
