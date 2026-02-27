<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{AuthController, CourseController, EnrollmentController, InstructorController};
use App\Http\Controllers\Api\Admin\{AdminCourseController, AdminInstructorController, AdminUserController};

//  Public Routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('courses', [CourseController::class, 'index']);
Route::get('courses/featured', [CourseController::class, 'featured']);
Route::get('courses/{id}', [CourseController::class, 'show']);

Route::get('instructors', [InstructorController::class, 'index']);
Route::get('instructors/{id}', [InstructorController::class, 'show']);

//  Protected Routes (Auth Required)
Route::middleware('auth:sanctum')->group(function () {
    
    // User Account
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);

    // Student Enrollment
    Route::prefix('courses/{id}')->group(function () {
        Route::post('enroll', [EnrollmentController::class, 'enroll']);
        Route::delete('unenroll', [EnrollmentController::class, 'unenroll']); 
        Route::get('check-enrollment', [EnrollmentController::class, 'checkEnrollment']);
    });
    Route::get('my-courses', [EnrollmentController::class, 'myCourses']);

 
    // | Admin Routes
    Route::prefix('admin')->group(function () {
        // Users Management
        Route::apiResource('users', AdminUserController::class);
        Route::patch('users/{id}/role', [AdminUserController::class, 'updateRole']);

        // Courses Management
        Route::apiResource('courses', AdminCourseController::class)->except(['index', 'show']);
        Route::get('courses/{id}/students', [EnrollmentController::class, 'courseStudents']);

        // Instructors Management
        Route::apiResource('instructors', AdminInstructorController::class)->except(['index', 'show']);
        
        // General Admin Reports
        Route::get('enrollments', [EnrollmentController::class, 'allCoursesWithEnrollments']);
    });
});