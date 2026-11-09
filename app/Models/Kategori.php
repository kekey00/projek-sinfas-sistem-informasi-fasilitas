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

    /**
     * Relasi ke tabel barang (one-to-many).
     * Mengambil seluruh daftar barang sarana yang termasuk dalam kategori ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'id_kategori', 'id_kategori');
    }

    /**
     * Alias untuk relasi barangs().
     * Disediakan sebagai penamaan singular agar konsisten dengan konvensi pemanggilan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function barang()
    {
        return $this->barangs();
    }
}
