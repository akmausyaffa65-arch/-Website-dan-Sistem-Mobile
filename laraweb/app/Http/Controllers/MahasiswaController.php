<?php

namespace App\Http\Controllers;

use App\Http\Resources\MahasiswaResource;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswas = Mahasiswa::when($request->q, function ($mahasiswas, $request) {
            $mahasiswas->where('nama', 'like', '%' . $request->q . '%');
        })
        ->latest()
        ->paginate(5);

        return new MahasiswaResource(
            true,
            'List Data Mahasiswa',
            $mahasiswas
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required|size:13|unique:mahasiswas',
            'nama' => 'required|max:100',
            'program_studi_id' => 'required|exists:program_studis,id',
            'email' => 'required|email|max:100|unique:mahasiswas',
            'nomor_hp' => 'required|max:15|unique:mahasiswas',
            'jenis_kelamin' => 'required|boolean',
            'tempat_lahir' => 'required|max:100',
            'tanggal_lahir' => 'required|date',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $mahasiswa = Mahasiswa::create($request->all());

        if ($mahasiswa) {
            return new MahasiswaResource(
                true,
                'Data Mahasiswa Berhasil Ditambahkan!',
                $mahasiswa
            );
        }

        return new MahasiswaResource(
            false,
            'Data Mahasiswa Gagal Ditambahkan!',
            null
        );
    }

    public function show(Mahasiswa $mahasiswa)
    {
        if ($mahasiswa) {
            return new MahasiswaResource(
                true,
                'Detail Data Mahasiswa!',
                $mahasiswa
            );
        }

        return new MahasiswaResource(
            false,
            'Data Mahasiswa Tidak Ditemukan!',
            null
        );
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:100',
            'nim' => 'required|size:13|unique:mahasiswas,nim,' . $mahasiswa->id,
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $mahasiswa->update($request->all());

        if ($mahasiswa) {
            return new MahasiswaResource(
                true,
                'Data Mahasiswa Berhasil Diubah!',
                $mahasiswa
            );
        }

        return new MahasiswaResource(
            false,
            'Data Mahasiswa Gagal Diubah!',
            null
        );
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();

        if ($mahasiswa) {
            return new MahasiswaResource(
                true,
                'Data Mahasiswa Berhasil Dihapus!',
                null
            );
        }

        return new MahasiswaResource(
            false,
            'Data Mahasiswa Gagal Dihapus!',
            null
        );
    }
}   