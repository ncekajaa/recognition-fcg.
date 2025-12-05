<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use App\Models\UserAbsen;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsenController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function checkUsername(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string'
            ]);

            $user = UserData::where('username', $request->username)->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Username tidak ditemukan! Silakan registrasi di dashboard.'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'Username ditemukan!',
                'data' => [
                    'username' => $user->username,
                    'image' => asset($user->image)
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function submitAbsen(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'status' => 'required|in:success,failed'
            ]);

            $location = "https://www.google.com/maps?q={$request->latitude},{$request->longitude}";

            $absen = UserAbsen::create([
                'username' => $request->username,
                'location' => $location,
                'status' => $request->status,
                'time_absen' => Carbon::now()
            ]);

            return response()->json([
                'status' => true,
                'message' => $request->status === 'success' 
                    ? 'Absensi berhasil!' 
                    : 'Absensi gagal! Wajah tidak cocok.',
                'data' => $absen
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}