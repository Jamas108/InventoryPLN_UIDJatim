<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\BarangMasuk;

class SufficientStock implements Rule
{
    protected $index;
    protected $jumlahBarang;
    protected $namaBarang;

    public function __construct($index, $jumlahBarang, $namaBarang)
    {
        $this->index = $index;
        $this->jumlahBarang = $jumlahBarang;
        $this->namaBarang = $namaBarang;
    }

    public function passes($attribute, $value)
    {
        // Ambil stok barang dari database
        $barangMasuk = BarangMasuk::where('Kode_Barang', $value)->first();

        if ($barangMasuk) {
            $stokBarang = $barangMasuk->JumlahBarang_Masuk - $barangMasuk->barangKeluar->sum('Jumlah_Barang');
            return $stokBarang >= $this->jumlahBarang;
        }

        return false;
    }

    public function message()
    {
        return 'Stok tidak mencukupi untuk barang ' . $this->namaBarang . '.';
    }
}
