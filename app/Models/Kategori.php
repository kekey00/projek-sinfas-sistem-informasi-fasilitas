<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Kategori Sarana
 *
 * Mengelompokkan inventaris fasilitas sekolah (contoh: Multimedia, Elektronika, Jaringan, Olahraga).
 *
 * @property int $id_kategori
 * @property string $nama_kategori
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Kategori extends Model
{
    protected $table      = 'kategori';
    protected $primaryKey = 'id_kategori';

    protected $fillable = ['nama_kategori'];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'id_kategori', 'id_kategori');
    }

    public function barang()
    {
        return $this->barangs();
    }
}
