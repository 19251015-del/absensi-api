<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required', // Bisa berisi email ATAU employee_id
            'password' => 'required',
        ]);

        // Cari user berdasarkan email ATAU employee_id di database MySQL
        $user = User::where('email', $request->login)
                    ->orWhere('employee_id', $request->login)
                    ->first();

        // Verifikasi keberadaan user & kecocokan password HASH di MySQL
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email/ID Karyawan atau kata sandi salah.'
            ], 401);
        }

        // Cek jika akun dinonaktifkan
        if (isset($user->active) && !$user->active) {
            return response()->json([
                'message' => 'Akun Anda sedang dinonaktifkan.'
            ], 403);
        }

        return response()->json([
            'message' => 'Login berhasil',
            'user' => [
                'id' => $user->employee_id ?? "EMP00{$user->id}",
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'position' => $user->position ?? ($user->role === 'admin' ? 'Administrator' : 'Karyawan'),
                'division' => $user->division ?? 'Operasional',
            ]
        ]);
    }
}