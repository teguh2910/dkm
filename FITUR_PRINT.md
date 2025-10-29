# Fitur Print & Download Format Excel

## 📄 Fitur yang Ditambahkan

### 1. **Download Format Excel** 📥
Tombol untuk download template/format Excel yang sudah tersedia di `public/format.xlsx`

**Lokasi:**
- Halaman Daftar Pengeluaran (Index)
- Tombol hijau: "📄 Download Format Excel"

**Cara Kerja:**
1. Klik tombol "Download Format Excel"
2. File `Format_Pengeluaran_Kas_DKM.xlsx` akan otomatis terdownload
3. Bisa digunakan sebagai template untuk input data

**Route:**
```php
GET /cash-expenses/download-format
```

**Controller Method:**
```php
public function downloadFormat()
{
    $filePath = public_path('format.xlsx');
    return response()->download($filePath, 'Format_Pengeluaran_Kas_DKM.xlsx');
}
```

---

### 2. **Print Detail Pengeluaran** 🖨️
Tombol untuk print/cetak detail pengeluaran kas kecil

**Lokasi:**
- Halaman Detail Pengeluaran (Show)
- Tombol hijau: "🖨️ Print"

**Cara Kerja:**
1. Buka detail pengeluaran
2. Klik tombol "Print"
3. Browser akan membuka dialog print
4. Tombol dan header akan otomatis tersembunyi saat print
5. Hanya detail data yang akan dicetak

**Fitur Print:**
- Auto-hide header aplikasi
- Auto-hide semua tombol (Edit, Kembali, Print)
- Format print optimized
- Background putih untuk hemat tinta
- Border hitam pada card

---

## 🎨 CSS Print Styles

```css
@media print {
    .header,
    .btn,
    button,
    a.btn {
        display: none !important;
    }
    
    body {
        background: white;
    }
    
    .card {
        box-shadow: none;
        border: 1px solid #000;
    }
}
```

---

## 📂 File Structure

```
public/
├── format.xlsx          <- Template Excel (sudah ada)
└── js/
    └── terbilang.js

routes/
└── web.php              <- Route download-format ditambahkan

app/Http/Controllers/
└── CashExpenseController.php  <- Method downloadFormat() ditambahkan

resources/views/cash-expenses/
├── index.blade.php      <- Tombol Download Format
└── show.blade.php       <- Tombol Print
```

---

## 🚀 Cara Penggunaan

### Download Format Excel:
1. Buka halaman utama (http://localhost:8000)
2. Klik tombol hijau "📄 Download Format Excel"
3. File akan terdownload dengan nama `Format_Pengeluaran_Kas_DKM.xlsx`

### Print Detail:
1. Klik tombol "Detail" pada data pengeluaran
2. Klik tombol hijau "🖨️ Print"
3. Pilih printer atau "Save as PDF"
4. Print/Save

---

## ⚙️ Konfigurasi

### Mengganti File Format Excel:
1. Replace file `public/format.xlsx` dengan template baru
2. Pastikan nama file tetap `format.xlsx` atau
3. Update di `CashExpenseController.php`:
   ```php
   $filePath = public_path('nama_file_baru.xlsx');
   ```

### Mengubah Nama Download:
Edit di `CashExpenseController.php`:
```php
return response()->download($filePath, 'Nama_File_Baru.xlsx');
```

---

## 🎯 Testing

### Test Download:
```
✅ Klik tombol "Download Format Excel"
✅ File terdownload dengan benar
✅ Nama file: Format_Pengeluaran_Kas_DKM.xlsx
✅ File bisa dibuka di Excel/Spreadsheet
```

### Test Print:
```
✅ Klik tombol "Print"
✅ Dialog print muncul
✅ Preview print tidak menampilkan header/tombol
✅ Hanya data detail yang ditampilkan
✅ Format rapi dan readable
```

---

## 💡 Tips

**Print to PDF:**
- Pilih "Save as PDF" di dialog print
- Lebih ramah lingkungan
- Bisa di-share digital

**Excel Template:**
- Buat format Excel sesuai kebutuhan
- Simpan sebagai `format.xlsx` di folder `public/`
- Otomatis bisa didownload

**Customize Print Layout:**
- Edit `@media print` styles di `layouts/app.blade.php`
- Bisa tambahkan logo, watermark, dll

---

## 📱 Browser Support

✅ Chrome/Edge - Full support  
✅ Firefox - Full support  
✅ Safari - Full support  
✅ Opera - Full support

---

**Fitur Print & Download Format - Ready to Use!** 🎉
