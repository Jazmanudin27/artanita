<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiswaResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'kode_siswa' => $this->kode_siswa,
            'nama_siswa' => $this->nama_siswa,
            'nisn' => $this->nisn,
            'email' => $this->email,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
