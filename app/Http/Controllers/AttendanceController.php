<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    // GET: Ambil semua data absensi (Untuk Admin)
    public function index()
    {
        $data = Attendance::orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    // GET: Ambil data absensi khusus karyawan tertentu yang sedang login
    public function userAttendance($employee_id)
    {
        $data = Attendance::where('employee_id', $employee_id)
                          ->orderBy('created_at', 'desc')
                          ->get();

        return response()->json($data);
    }

    // POST: Simpan absensi baru dari HP/Web React
    public function store(Request $request)
    {
        $attendance = Attendance::create([
            'employee_id' => $request->employee_id ?? $request->user_id, // Mendukung key employee_id maupun user_id dari React
            'user_name'   => $request->user_name,
            'type'        => $request->type ?? 'check_in',
            'lat'         => $request->lat,
            'lng'         => $request->lng,
            'photo_url'   => $request->photo_url,
            'status'      => $request->status,
        ]);

        return response()->json([
            'message' => 'Absensi berhasil disimpan ke phpMyAdmin!',
            'data'    => $attendance
        ], 201);
    }

    // DELETE: Hapus data absensi dari Web Admin & Urutkan Kembali ID
    public function destroy($id)
    {
        $attendance = Attendance::where('attendance_id', $id)->first();
        
        if ($attendance) {
            // 1. Hapus data yang dipilih
            $attendance->delete();

            // 2. Urutkan kembali ID secara berurutan mulai dari 1
            DB::statement("SET @num := 0;");
            DB::statement("UPDATE attendances SET attendance_id = @num := (@num+1);");

            // 3. Reset nilai AUTO_INCREMENT ke angka tertinggi + 1
            $maxId = DB::table('attendances')->max('attendance_id') ?? 0;
            DB::statement("ALTER TABLE attendances AUTO_INCREMENT = " . ($maxId + 1));

            return response()->json([
                'message' => 'Data berhasil dihapus dan ID berhasil diurutkan ulang!'
            ]);
        }

        return response()->json(['message' => 'Data tidak ditemukan!'], 404);
    }
}