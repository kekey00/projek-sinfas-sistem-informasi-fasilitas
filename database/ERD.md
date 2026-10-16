# Entity Relationship Diagram

Diagram ini merepresentasikan struktur database aktual berdasarkan seluruh
migrasi aplikasi, bukan relasi yang hanya didefinisikan pada model Eloquent.

```mermaid
erDiagram
    SISWA {
        string nis PK
        string nama
        string email "nullable"
        string no_hp "nullable"
        enum jenis_kelamin "nullable"
        timestamp created_at
        timestamp updated_at
    }

    PEGAWAI {
        string nip PK
        string nama
        enum jenis_kelamin "nullable"
        timestamp created_at
        timestamp updated_at
    }

    AKUN {
        bigint id_akun PK
        string nis FK "nullable"
        string nip FK "nullable"
        string nama
        string nomor_kontak "nullable"
        enum role "siswa, admin_sarana, admin_sistem"
        string username UK
        string password
        timestamp created_at
        timestamp updated_at
    }

    KATEGORI {
        bigint id_kategori PK
        string nama_kategori
        timestamp created_at
        timestamp updated_at
    }

    BARANG {
        string kode_barang PK
        bigint id_kategori FK
        string nama_barang
        string merk_model "nullable"
        string no_seri_pabrik "nullable"
        string ukuran_dimensi "nullable"
        string bahan "nullable"
        year tahun_pembelian "nullable"
        unsigned_integer jumlah_baik
        unsigned_integer jumlah_kurang_baik
        unsigned_integer jumlah_rusak_berat
        text keterangan "nullable"
        string foto "nullable"
        enum kondisi
        timestamp created_at
        timestamp updated_at
    }

    PEMINJAMAN {
        string kode_pinjam PK
        string nis FK
        string nomor_telepon "nullable"
        string kode_barang FK
        date tanggal_pinjam
        string jam_pinjam "nullable"
        date tanggal_kembali "nullable"
        string jam_kembali "nullable"
        text keterangan_penggunaan "nullable"
        string lokasi "nullable"
        enum status_pengajuan "menunggu, disetujui, ditolak"
        timestamp created_at
        timestamp updated_at
    }

    PENGEMBALIAN {
        string kode_kembali PK
        string kode_pinjam FK
        date tanggal_kembali
        string kondisi_barang "nullable"
        string bukti_foto_video "nullable"
        string status "default selesai"
        timestamp created_at
        timestamp updated_at
    }

    NOTIFIKASI {
        bigint id_notifikasi PK
        bigint id_akun FK
        text pesan
        boolean status_baca
        timestamp created_at
        timestamp updated_at
    }

    SISWA o|--o{ AKUN : "nis nullable, tidak unik"
    PEGAWAI o|--o{ AKUN : "nip nullable, tidak unik"
    SISWA ||--o{ PEMINJAMAN : melakukan
    BARANG ||--o{ PEMINJAMAN : dipinjam
    KATEGORI ||--o{ BARANG : mengelompokkan
    PEMINJAMAN ||--o| PENGEMBALIAN : memiliki
    AKUN ||--o{ NOTIFIKASI : menerima
```

## Catatan kardinalitas dan batasan

- Setiap peminjaman harus memiliki tepat satu siswa dan satu barang. Siswa atau
  barang dapat belum pernah atau sudah berkali-kali muncul pada transaksi.
- Satu peminjaman dapat belum memiliki pengembalian atau memiliki paling banyak
  satu pengembalian. Kolom `pengembalian.kode_pinjam` adalah foreign key unik.
- Satu barang harus berada dalam satu kategori; satu kategori dapat memiliki
  banyak barang.
- `akun.nis` dan `akun.nip` nullable dan tidak diberi unique constraint.
  Karena itu, skema saat ini mengizinkan satu siswa/pegawai direferensikan oleh
  beberapa akun, dan satu akun dapat tidak terhubung ke salah satu atau bahkan
  terhubung ke keduanya. Diagram menunjukkan aturan database ini, bukan dugaan
  hubungan satu-ke-satu.
- `akun.role` tidak memiliki constraint yang mewajibkan akun `siswa` mengisi
  `nis`, atau akun admin mengisi `nip`. Jika setiap profil memang harus punya
  maksimal satu akun dan jenis akun harus cocok dengan profilnya, tambahkan
  unique constraint pada `akun.nis` dan `akun.nip` serta validasi konsistensi
  role/FK melalui skema aplikasi atau database.
- Peminjaman saat ini hanya menyimpan `nis`, sehingga guru/pegawai tidak dapat
  menjadi peminjam menurut skema yang berlaku.
- Foreign key `peminjaman.kode_barang` dan `pengembalian.kode_pinjam` memakai
  cascade delete. Menghapus barang akan menghapus riwayat pinjaman dan
  pengembaliannya; jika riwayat perlu dipertahankan, gunakan soft delete atau
  larang penghapusan barang yang pernah dipinjam.
- Catatan implementasi: foreign key `peminjaman.nis` menunjuk `siswa.nis`, tetapi
  relasi `Peminjaman::siswa()` saat ini menunjuk model `Akun`. Relasi model itu
  tidak sesuai dengan foreign key dan sebaiknya dipisahkan menjadi relasi ke
  `Siswa` dan relasi akun jika informasi akun juga diperlukan.
- Tabel framework seperti `personal_access_tokens`, `failed_jobs`, dan tabel
  reset password tidak ditampilkan karena diagram ini fokus pada domain
  peminjaman fasilitas.
