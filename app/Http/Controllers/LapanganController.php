<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LapanganController extends Controller
{
    public function index()
    {
        $lapangan = Lapangan::orderBy('created_at', 'desc')->get();
        return view('lapangan.index', compact('lapangan'));
    }

    public function create()
    {
        return view('lapangan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'area_coordinates' => 'required|json',
            'area_color' => 'required|string|regex:/^#([A-Fa-f0-9]{6})$/',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'nama_lapangan.required' => 'Nama lapangan wajib diisi',
            'nama_lapangan.max' => 'Nama lapangan maksimal 255 karakter',
            'alamat.required' => 'Alamat wajib diisi',
            'foto.required' => 'Foto lapangan wajib diisi',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format foto harus jpeg, png, atau jpg',
            'foto.max' => 'Ukuran foto maksimal 2MB',
            'latitude.required' => 'Latitude wajib diisi',
            'latitude.numeric' => 'Latitude harus berupa angka',
            'latitude.between' => 'Latitude harus berada di antara -90 dan 90',
            'longitude.required' => 'Longitude wajib diisi',
            'longitude.numeric' => 'Longitude harus berupa angka',
            'longitude.between' => 'Longitude harus berada di antara -180 dan 180',
            'area_coordinates.required' => 'Area koordinat wajib diisi',
            'area_coordinates.json' => 'Format area koordinat tidak valid',
            'area_color.required' => 'Warna area wajib diisi',
            'area_color.regex' => 'Format warna tidak valid',
            'status.required' => 'Status wajib diisi',
            'status.in' => 'Status harus aktif atau nonaktif'
        ]);

        try {
            // Handle file upload
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $fileName = time() . '_' . $file->getClientOriginalName();
                // Simpan ke public/img/lapangan
                $file->move(public_path('img/lapangan'), $fileName);
                $fotoPath = 'img/lapangan/' . $fileName;
            }

            // Decode area coordinates
            $coordinates = json_decode($validated['area_coordinates'], true);

            // Calculate area size
            $area_size = $this->calculateAreaSize($coordinates);

            // Create new lapangan
            $lapangan = Lapangan::create([
                'nama_lapangan' => $validated['nama_lapangan'],
                'alamat' => $validated['alamat'],
                'foto' => $fotoPath,
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'area_coordinates' => $coordinates,
                'area_size' => $area_size,
                'area_color' => $validated['area_color'],
                'status' => $validated['status'],
            ]);

            return redirect()
                ->route('lapangan.index')
                ->with('success', 'Lapangan berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function calculateAreaSize($coordinates)
    {
        // Implementation of area calculation using Haversine formula
        $area = 0;
        $numPoints = count($coordinates);

        if ($numPoints < 3) {
            return 0;
        }

        for ($i = 0; $i < $numPoints; $i++) {
            $j = ($i + 1) % $numPoints;

            $xi = deg2rad($coordinates[$i][1]); // longitude
            $yi = deg2rad($coordinates[$i][0]); // latitude
            $xj = deg2rad($coordinates[$j][1]); // longitude
            $yj = deg2rad($coordinates[$j][0]); // latitude

            $area += ($xi * $yj) - ($xj * $yi);
        }

        $area = abs($area * 6371000 * 6371000 / 2);

        return $area;
    }

    public function show(Lapangan $lapangan)
    {
        return view('lapangan.show', compact('lapangan'));
    }

    public function edit(Lapangan $lapangan)
    {
        return view('lapangan.edit', compact('lapangan'));
    }

    public function update(Request $request, Lapangan $lapangan)
    {
        $validated = $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'area_coordinates' => 'required|json',
            'area_color' => 'required|string|regex:/^#([A-Fa-f0-9]{6})$/',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        try {
            $updateData = [
                'nama_lapangan' => $validated['nama_lapangan'],
                'alamat' => $validated['alamat'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'area_coordinates' => json_decode($validated['area_coordinates'], true),
                'area_color' => $validated['area_color'],
                'status' => $validated['status'],
            ];

            // Handle foto update
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($lapangan->foto && file_exists(public_path($lapangan->foto))) {
                    unlink(public_path($lapangan->foto));
                }

                // Upload foto baru
                $file = $request->file('foto');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('img/lapangan'), $fileName);
                $updateData['foto'] = 'img/lapangan/' . $fileName;
            }

            // Update area size
            $updateData['area_size'] = $this->calculateAreaSize($updateData['area_coordinates']);

            $lapangan->update($updateData);

            return redirect()
                ->route('lapangan.index')
                ->with('success', 'Lapangan berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Lapangan $lapangan)
    {
        try {
            if ($lapangan->foto && file_exists(public_path($lapangan->foto))) {
                unlink(public_path($lapangan->foto));
            }
            $lapangan->delete();
            return redirect()
                ->route('lapangan.index')
                ->with('success', 'Lapangan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function getMapData()
    {
        $lapangan = Lapangan::select('id', 'nama_lapangan', 'alamat', 'latitude', 'longitude', 'foto', 'status')
            ->where('status', 'aktif')
            ->get();

        return response()->json($lapangan);
    }
}
