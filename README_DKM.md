# DKM AL-IKLAS PT Aisin Indonesia

## Sistem Pencatatan Bukti Pengeluaran Kas Kecil

Aplikasi web untuk mencatat dan mengelola bukti pengeluaran kas kecil DKM AL-IKLAS di PT Aisin Indonesia dengan sistem approval 3 tingkat.

## Fitur Utama

### 1. **Pencatatan Pengeluaran Kas**

-   Input data pengeluaran dengan form yang user-friendly
-   Kode Barcode dengan Select2 dropdown (searchable)
-   Input tanggal transaksi
-   Input nama penerima pembayaran
-   Input jumlah uang (Rupiah)
-   Auto-generate terbilang dari jumlah uang
-   Kategori pengeluaran dengan Select2 dropdown
-   Keterangan tambahan (opsional)

### 2. **Sistem Approval 3 Tingkat**

Setiap pengeluaran harus melalui approval dari:

-   **Bendahara** - Approval tingkat pertama
-   **Sekretaris** - Approval tingkat kedua
-   **Ketua** - Approval tingkat ketiga (final)

Status approval: `pending`, `approved`, `rejected`

### 3. **Manajemen Data**

-   Daftar semua pengeluaran dengan pagination
-   Detail pengeluaran lengkap dengan status approval
-   Edit data pengeluaran
-   Hapus data pengeluaran
-   Filter dan pencarian data

## Struktur Database

### Tabel: `barcodes`

-   `id` - Primary key
-   `code` - Kode barcode (unique)
-   `name` - Nama item/kategori
-   `description` - Deskripsi
-   `is_active` - Status aktif

### Tabel: `expense_categories`

-   `id` - Primary key
-   `name` - Nama kategori
-   `description` - Deskripsi
-   `is_active` - Status aktif

### Tabel: `cash_expenses`

-   `id` - Primary key
-   `barcode_id` - Foreign key ke barcodes
-   `tanggal` - Tanggal transaksi
-   `dibayarkan_kepada` - Nama penerima
-   `sebesar` - Jumlah uang (decimal)
-   `terbilang` - Terbilang dari jumlah
-   `expense_category_id` - Foreign key ke expense_categories
-   `keterangan2` - Keterangan tambahan
-   `status_bendahara` - Status approval bendahara (enum)
-   `status_sekretaris` - Status approval sekretaris (enum)
-   `status_ketua` - Status approval ketua (enum)
-   `approved_bendahara_at` - Timestamp approval bendahara
-   `approved_sekretaris_at` - Timestamp approval sekretaris
-   `approved_ketua_at` - Timestamp approval ketua
-   `created_at`, `updated_at` - Timestamps

## Technology Stack

-   **Laravel 12** - PHP Framework
-   **PHP 8.4.2** - Programming Language
-   **MySQL** - Database
-   **Select2** - Enhanced select dropdown with search
-   **jQuery** - JavaScript library
-   **Tailwind CSS** - Utility-first CSS (via CDN)
-   **Blade Templates** - Laravel templating engine

## Instalasi

### Prerequisites

-   PHP >= 8.4
-   Composer
-   MySQL/MariaDB
-   Node.js & NPM (untuk asset compilation)

### Langkah Instalasi

1. **Clone repository**

```bash
git clone <repository-url>
cd dkm
```

2. **Install dependencies**

```bash
composer install
npm install
```

3. **Setup environment**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi database**
   Edit file `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dkm_database
DB_USERNAME=root
DB_PASSWORD=
```

5. **Migrasi dan seed database**

```bash
php artisan migrate
php artisan db:seed
```

6. **Build assets**

```bash
npm run build
# atau untuk development:
npm run dev
```

7. **Jalankan aplikasi**

```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## Data Awal (Seeder)

### Kode Barcode

-   BRG001 - Alat Tulis Kantor
-   BRG002 - Konsumsi
-   BRG003 - Kebersihan
-   BRG004 - Operasional
-   BRG005 - Transportasi

### Kategori Pengeluaran

-   Pembelian ATK
-   Konsumsi Rapat
-   Biaya Kebersihan
-   Biaya Transportasi
-   Infaq & Sedekah
-   Pemeliharaan Masjid
-   Listrik & Air
-   Lain-lain

## Penggunaan

### Menambah Pengeluaran Baru

1. Klik tombol "Tambah Pengeluaran" di halaman utama
2. Pilih kode barcode dari dropdown Select2
3. Pilih tanggal transaksi
4. Masukkan nama penerima pembayaran
5. Masukkan jumlah uang (otomatis akan generate terbilang)
6. Pilih kategori pengeluaran dari dropdown Select2
7. Tambahkan keterangan tambahan jika diperlukan
8. Klik "Simpan"

### Melihat Detail Pengeluaran

1. Klik tombol "Detail" pada baris data yang ingin dilihat
2. Tampil semua informasi lengkap termasuk status approval

### Edit Pengeluaran

1. Klik tombol "Edit" pada baris data yang ingin diubah
2. Ubah data yang diperlukan
3. Klik "Update"

### Hapus Pengeluaran

1. Klik tombol "Hapus" pada baris data yang ingin dihapus
2. Konfirmasi penghapusan
3. Data akan terhapus dari database

## Fitur JavaScript

### Auto-fill Terbilang

File: `public/js/terbilang.js`

Fungsi untuk mengkonversi angka menjadi format terbilang dalam Bahasa Indonesia:

-   Mendukung angka hingga Triliun
-   Otomatis mengupdate field terbilang saat user menginput jumlah uang
-   Format: "Dua Juta Lima Ratus Ribu Rupiah"

## Routes

```php
GET  /                              -> Redirect ke cash-expenses.index
GET  /cash-expenses                 -> Daftar pengeluaran
GET  /cash-expenses/create          -> Form tambah pengeluaran
POST /cash-expenses                 -> Simpan pengeluaran baru
GET  /cash-expenses/{id}            -> Detail pengeluaran
GET  /cash-expenses/{id}/edit       -> Form edit pengeluaran
PUT  /cash-expenses/{id}            -> Update pengeluaran
DELETE /cash-expenses/{id}          -> Hapus pengeluaran
POST /cash-expenses/{id}/approval/{role}/{status} -> Update status approval
```

## Models & Relationships

### CashExpense

```php
// Relationships
belongsTo(Barcode::class)
belongsTo(ExpenseCategory::class)

// Helper Methods
isFullyApproved() - Cek apakah sudah disetujui semua
hasRejection() - Cek apakah ada yang menolak
```

### Barcode

```php
hasMany(CashExpense::class)
```

### ExpenseCategory

```php
hasMany(CashExpense::class)
```

## Validasi Form

### StoreCashExpenseRequest & UpdateCashExpenseRequest

-   `barcode_id` - Required, must exist in barcodes table
-   `tanggal` - Required, must be valid date
-   `dibayarkan_kepada` - Required, string, max 255 characters
-   `sebesar` - Required, numeric, minimum 0
-   `terbilang` - Required, string
-   `expense_category_id` - Required, must exist in expense_categories table
-   `keterangan2` - Optional, string

Semua error messages dalam Bahasa Indonesia.

## Development

### Code Style

Aplikasi ini menggunakan **Laravel Pint** untuk code formatting.

Jalankan Pint sebelum commit:

```bash
vendor/bin/pint
```

### Testing

```bash
php artisan test
```

## Kontributor

Aplikasi ini dibuat untuk DKM AL-IKLAS PT Aisin Indonesia.

## License

Proprietary - Internal use only

---

**Dibuat dengan ❤️ menggunakan Laravel 12**
