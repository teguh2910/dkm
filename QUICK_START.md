# Quick Start Guide - DKM AL-IKLAS

## Panduan Cepat Penggunaan Aplikasi

### 🚀 Cara Menjalankan Aplikasi

```bash
# Start development server
php artisan serve
```

Buka browser: `http://localhost:8000`

---

### 📝 Cara Menambah Pengeluaran Kas Baru

1. **Klik "Tambah Pengeluaran"** di halaman utama
2. **Isi form:**
    - **Kode Barcode**: Pilih dari dropdown (misal: BRG001 - Alat Tulis Kantor)
    - **Tanggal**: Pilih tanggal transaksi
    - **Dibayarkan Kepada**: Ketik nama penerima (misal: Toko ABC)
    - **Sebesar**: Ketik jumlah uang (misal: 150000)
    - **Terbilang**: Otomatis terisi → "Seratus Lima Puluh Ribu Rupiah"
    - **Kategori**: Pilih kategori (misal: Pembelian ATK)
    - **Keterangan**: Tambahan info (opsional)
3. **Klik "Simpan"**

---

### ✅ Sistem Approval

Setiap pengeluaran memiliki 3 status approval:

1. **Bendahara** → Approve/Reject
2. **Sekretaris** → Approve/Reject
3. **Ketua** → Approve/Reject (Final)

**Status Badge:**

-   🟡 **Pending** - Menunggu approval
-   🟢 **Approved** - Disetujui
-   🔴 **Rejected** - Ditolak

---

### 🔍 Fitur Utama

| Fitur                  | Deskripsi                                     |
| ---------------------- | --------------------------------------------- |
| **Daftar Pengeluaran** | Lihat semua data pengeluaran kas              |
| **Tambah Pengeluaran** | Input pengeluaran baru                        |
| **Detail**             | Lihat detail lengkap termasuk status approval |
| **Edit**               | Ubah data pengeluaran                         |
| **Hapus**              | Hapus data pengeluaran                        |
| **Auto Terbilang**     | Konversi angka ke kata otomatis               |
| **Select2**            | Dropdown dengan fitur search                  |

---

### 📊 Data Master (Sudah Tersedia)

**Kode Barcode:**

-   BRG001 - Alat Tulis Kantor
-   BRG002 - Konsumsi
-   BRG003 - Kebersihan
-   BRG004 - Operasional
-   BRG005 - Transportasi

**Kategori Pengeluaran:**

-   Pembelian ATK
-   Konsumsi Rapat
-   Biaya Kebersihan
-   Biaya Transportasi
-   Infaq & Sedekah
-   Pemeliharaan Masjid
-   Listrik & Air
-   Lain-lain

---

### 🛠️ Troubleshooting

**Error: Class not found**

```bash
composer dump-autoload
```

**Frontend tidak muncul dengan baik**

```bash
npm run build
# atau
npm run dev
```

**Database error**

```bash
php artisan migrate:fresh --seed
```

**Clear cache**

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

### 💡 Tips Penggunaan

1. **Select2 Searchable**: Ketik untuk mencari di dropdown
2. **Auto Terbilang**: Langsung terisi saat input jumlah
3. **Validasi Form**: Semua field required kecuali keterangan
4. **Responsive**: Bisa diakses dari mobile
5. **Alert Messages**: Notifikasi sukses/error setelah aksi

---

### 📱 Shortcut Keyboard

-   `Ctrl + S` - Submit form (saat di form)
-   `Esc` - Tutup modal/cancel (jika ada)
-   `Tab` - Navigasi antar field

---

### 🎯 Next Steps

Setelah aplikasi berjalan, Anda bisa:

1. ✅ Tambahkan data pengeluaran baru
2. ✅ Lihat daftar pengeluaran
3. ✅ Edit atau hapus data
4. ✅ Cek detail dan status approval
5. ✅ Export data (future feature)

---

**Selamat menggunakan aplikasi DKM AL-IKLAS! 🎉**

---

_Untuk dokumentasi lengkap, lihat: `README_DKM.md`_
