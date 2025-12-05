<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use App\Models\UserAbsen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DataController extends Controller
{
    public function dashboard()
    {
        $users = UserData::latest()->get();
        $absens = UserAbsen::latest()->get();
        
        return view('dashboard', compact('users', 'absens'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|unique:data_user,username|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $request->username . '.' . $image->getClientOriginalExtension();
                
                // Pastikan folder uploads ada
                if (!File::exists(public_path('uploads'))) {
                    File::makeDirectory(public_path('uploads'), 0755, true);
                }
                
                $image->move(public_path('uploads'), $imageName);

                UserData::create([
                    'username' => $request->username,
                    'image' => 'uploads/' . $imageName
                ]);

                return redirect()->back()->with('success', 'Data user berhasil ditambahkan!');
            }

            return redirect()->back()->with('error', 'Gagal upload image!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = UserData::findOrFail($id);
            
            // Hapus file image
            if (File::exists(public_path($user->image))) {
                File::delete(public_path($user->image));
            }
            
            $user->delete();
            
            return redirect()->back()->with('success', 'Data user berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroyAbsen($id)
    {
        try {
            $absen = UserAbsen::findOrFail($id);
            $absen->delete();
            
            return redirect()->back()->with('success', 'Data absen berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}