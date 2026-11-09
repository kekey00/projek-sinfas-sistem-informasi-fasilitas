<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Representasi Database View 'v_rekap_inventaris'
 *
 * Mengimplementasikan Rubrik Poin No. 9: Database View.
 * Memetakan view rekapitulasi inventaris barang per kategori lengkap dengan
 * akumulasi unit fisik dan status ketersediaan langsung dari database engine.
 *
 * @property string $kode_barang
 * @property string $nama_barang
 * @property string|null $merk_model
 * @property string $nama_kategori
 * @property int $jumlah_baik
 * @property int $jumlah_kurang_baik
 * @property int $jumlah_rusak_berat
 * @property int $total_unit
 * @property string $status_ketersediaan
 */
class RekapInventarisView extends Model
{
    protected $table = 'v_rekap_inventaris';
    protected $primaryKey = 'kode_barang';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}

