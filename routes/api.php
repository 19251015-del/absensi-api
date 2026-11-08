<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendanceController;

// Route Karyawan / Users
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);

// Route Publik
Route::post('/login', [AuthController::class, 'login']);
Route::get('/employees', [UserController::class, 'index']);

// Route Absensi (Attendance)
Route::get('/attendance', [AttendanceController::class, 'index']);
Route::get('/attendance/user/{employee_id}', [AttendanceController::class, 'userAttendance']); // <-- Menambahkan route absensi spesifik karyawan
Route::post('/attendance', [AttendanceController::class, 'store']);
Route::delete('/attendance/{id}', [AttendanceController::class, 'destroy']);

// Route Terproteksi
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});