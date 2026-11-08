<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Mengambil semua data user dengan role employee dari MySQL
    public function index()
    {
        $employees = User::where('role', 'employee')->get();
        return response()->json($employees);
    }

    // Menyimpan karyawan baru ke database MySQL
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|unique:users,employee_id',
            'name'        => 'required',
            'email'       => 'required|email|unique:users,email',
            'division'    => 'required',
            'position'    => 'required',
        ]);

        $user = User::create([
            'employee_id' => $request->employee_id,
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password ?? 'welcome123'),
            'role'        => 'employee',
            'division'    => $request->division,
            'position'    => $request->position,
            'active'      => $request->active ?? true,
        ]);

        return response()->json([
            'message' => 'Karyawan berhasil ditambahkan ke database',
            'user'    => $user
        ], 201);
    }
}