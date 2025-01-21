<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:admin,user'],
            'status' => ['required', 'string', 'in:active,inactive'],
            'profile_photo' => ['nullable', 'image', 'max:2048'], // max 2MB
        ]);

        try {
            $userData = $request->except('profile_photo');
            $userData['password'] = Hash::make($request->password);

            if ($request->hasFile('profile_photo')) {
                // Buat direktori jika belum ada
                if (!Storage::exists('public/img/user')) {
                    Storage::makeDirectory('public/img/user');
                }

                $file = $request->file('profile_photo');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('img/user', $fileName, 'public');
                $userData['profile_photo_path'] = $path;
            }

            User::create($userData);

            return redirect()
                ->route('user.index')
                ->with('success', 'Pengguna berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Jika terjadi error, hapus file yang sudah diupload (jika ada)
            if (isset($path)) {
                Storage::disk('public')->delete($path);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan pengguna. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'string', 'in:admin,user'],
            'status' => ['required', 'string', 'in:active,inactive'],
            'profile_photo' => ['nullable', 'image', 'max:2048'], // max 2MB
        ];

        // Hanya validasi password jika diisi
        if ($request->filled('password')) {
            $rules['password'] = ['string', 'min:8', 'confirmed'];
        }

        $request->validate($rules);

        try {
            $userData = $request->except(['password', 'profile_photo']);

            // Update password jika diisi
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            // Handle update foto profil
            if ($request->hasFile('profile_photo')) {
                // Hapus foto lama jika ada
                if ($user->profile_photo_path) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }

                $file = $request->file('profile_photo');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('img/user', $fileName, 'public');
                $userData['profile_photo_path'] = $path;
            }

            $user->update($userData);

            return redirect()
                ->route('user.show', $user)
                ->with('success', 'Data pengguna berhasil diperbarui!');
        } catch (\Exception $e) {
            // Jika terjadi error, hapus file yang sudah diupload (jika ada)
            if (isset($path)) {
                Storage::disk('public')->delete($path);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data pengguna. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            // Simpan path foto untuk dihapus nanti
            $photoPath = $user->profile_photo_path;

            // Hapus user dulu
            $user->delete();

            // Jika berhasil hapus user, baru hapus foto
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }

            return redirect()
                ->route('user.index')
                ->with('success', 'Pengguna berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->route('user.index')
                ->with('error', 'Terjadi kesalahan saat menghapus pengguna. Silakan coba lagi.');
        }
    }
}
