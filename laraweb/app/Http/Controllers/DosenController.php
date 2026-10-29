<?php

namespace App\Http\Controllers;

use App\Http\Resources\DosenResource;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    public function index(Request $request)
    {
        $dosens = Dosen::when($request->q, function ($dosens, $request) {
            $dosens->where('nama_lengkap', 'like', '%' . $request->q . '%');
        })
        ->latest()
        ->paginate(5);

        return new DosenResource(
            true,
            'List Data Dosen',
            $dosens
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nidn' => 'nullable|size:10|unique:dosens,nidn',
            'nip' => 'nullable|size:18|unique:dosens,nip',
            'tmt' => 'nullable|date',
            'nama_lengkap' => 'required|max:100',
            'pangkat_id' => 'nullable|exists:pangkats,id',
            'jenis_kelamin' => 'required|boolean',
            'foto' => 'nullable|string|max:255',
            'kelompok_bidang_keahlian_id' => 'nullable|exists:kelompok_bidang_keahlians,id',
            'bidang_keilmuan' => 'nullable|string',
            'fungsi_fungsional' => 'required|in:tenaga pengajar,asisten ahli,lektor,lektor kepala,guru besar',
            'status' => 'required|in:aktif,cuti,ijin belajar,tugas di instansi lain,tugas belajar',
            'user_id' => 'nullable|exists:users,id',
            'program_studi_id' => 'nullable|exists:program_studis,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $dosen = Dosen::create($request->all());

        if ($dosen) {
            return new DosenResource(
                true,
                'Data Dosen Berhasil Ditambahkan!',
                $dosen
            );
        }

        return new DosenResource(
            false,
            'Data Dosen Gagal Ditambahkan!',
            null
        );
    }

    public function show(Dosen $dosen)
    {
        if ($dosen) {
            return new DosenResource(
                true,
                'Detail Data Dosen!',
                $dosen
            );
        }

        return new DosenResource(
            false,
            'Data Dosen Tidak Ditemukan!',
            null
        );
    }

    public function update(Request $request, Dosen $dosen)
    {
        $validator = Validator::make($request->all(), [
            'nidn' => 'nullable|size:10|unique:dosens,nidn,' . $dosen->id,
            'nip' => 'nullable|size:18|unique:dosens,nip,' . $dosen->id,
            'nama_lengkap' => 'required|max:100',
            'pangkat_id' => 'nullable|exists:pangkats,id',
            'jenis_kelamin' => 'required|boolean',
            'foto' => 'nullable|string|max:255',
            'kelompok_bidang_keahlian_id' => 'nullable|exists:kelompok_bidang_keahlians,id',
            'bidang_keilmuan' => 'nullable|string',
            'fungsi_fungsional' => 'required|in:tenaga pengajar,asisten ahli,lektor,lektor kepala,guru besar',
            'status' => 'required|in:aktif,cuti,ijin belajar,tugas di instansi lain,tugas belajar',
            'user_id' => 'nullable|exists:users,id',
            'program_studi_id' => 'nullable|exists:program_studis,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $dosen->update($request->all());

        if ($dosen) {
            return new DosenResource(
                true,
                'Data Dosen Berhasil Diubah!',
                $dosen
            );
        }

        return new DosenResource(
            false,
            'Data Dosen Gagal Diubah!',
            null
        );
    }

    public function destroy(Dosen $dosen)
    {
        $dosen->delete();

        if ($dosen) {
            return new DosenResource(
                true,
                'Data Dosen Berhasil Dihapus!',
                null
            );
        }

        return new DosenResource(
            false,
            'Data Dosen Gagal Dihapus!',
            null
        );
    }
}