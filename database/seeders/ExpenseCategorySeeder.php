<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Bisyaroh Khotib Jumat', 'description' => 'Bisyaroh Khotib Jumat'],
            ['name' => 'Bisyaroh Kajian rutin mingguan', 'description' => 'Bisyaroh Kajian rutin mingguan'],
            ['name' => 'Beriman', 'description' => 'Beriman'],
            ['name' => 'Buletin Imsyakiyah', 'description' => 'Buletin Imsyakiyah'],
            ['name' => 'Silaturahim ke Asatid', 'description' => 'Silaturahim ke Asatid'],
            ['name' => 'Cetak Spanduk dakwah', 'description' => 'Cetak Spanduk dakwah'],
            ['name' => 'PHBI', 'description' => 'PHBI'],
            ['name' => 'Pengadaan konten Facebook', 'description' => 'Pengadaan konten Facebook'],
            ['name' => 'Jadwal Imsyakiyah', 'description' => 'Jadwal Imsyakiyah'],
            ['name' => 'Program Ceria Ramadhan', 'description' => 'Program Ceria Ramadhan'],
            ['name' => 'Wisata Religi', 'description' => 'Wisata Religi'],
            ['name' => 'Cetak Buku', 'description' => 'Cetak Buku'],
            ['name' => 'Parcel Asatid', 'description' => 'Parcel Asatid'],
            ['name' => 'Berbagi Ta\'Jil', 'description' => 'Berbagi Ta\'Jil'],
            ['name' => 'Konsumsi Kajian Mingguan', 'description' => 'Konsumsi Kajian Mingguan'],
            ['name' => 'Konsumsi Meeting', 'description' => 'Konsumsi Meeting'],
            ['name' => 'Istigosah', 'description' => 'Istigosah'],
            ['name' => 'Gaji Marbot', 'description' => 'Gaji Marbot'],
            ['name' => 'BPJS Marbot', 'description' => 'BPJS Marbot'],
            ['name' => 'Laundry karpet / peci dan mukena', 'description' => 'Laundry karpet / peci dan mukena'],
            ['name' => 'Minyak wangi', 'description' => 'Minyak wangi'],
            ['name' => 'Perlengkapan Masjid', 'description' => 'Perlengkapan Masjid'],
            ['name' => 'Snack prepare sholat Jumat', 'description' => 'Snack prepare sholat Jumat'],
            ['name' => 'Akomodasi untuk prepare sholat Jumat (okihiba)', 'description' => 'Akomodasi untuk prepare sholat Jumat (okihiba)'],
            ['name' => 'Subsidi Foging', 'description' => 'Subsidi Foging'],
            ['name' => 'Lembur Marbot', 'description' => 'Lembur Marbot'],
            ['name' => 'Uang Makan Marbot bulan Puasa', 'description' => 'Uang Makan Marbot bulan Puasa'],
            ['name' => 'Bantuan yatim & Dhuafa', 'description' => 'Bantuan yatim & Dhuafa'],
            ['name' => 'Bantuan Pembangunan Masjid', 'description' => 'Bantuan Pembangunan Masjid'],
            ['name' => 'Bantuan Acara PHBI', 'description' => 'Bantuan Acara PHBI'],
            ['name' => 'Bantuan Ma Encah', 'description' => 'Bantuan Ma Encah'],
            ['name' => 'Bantuan Ustad Pelosok', 'description' => 'Bantuan Ustad Pelosok'],
            ['name' => 'Bantuan Kedukaan untuk karyawan & keluarga', 'description' => 'Bantuan Kedukaan untuk karyawan & keluarga'],
            ['name' => 'Bantuan Kedukaan untuk Asatid & Keluarga', 'description' => 'Bantuan Kedukaan untuk Asatid & Keluarga'],
            ['name' => 'Bantuan Bencana Alam untuk karyawan', 'description' => 'Bantuan Bencana Alam untuk karyawan'],
            ['name' => 'Bantuan Bencana Alam luar daerah', 'description' => 'Bantuan Bencana Alam luar daerah'],
            ['name' => 'Pengobatan Gratis', 'description' => 'Pengobatan Gratis'],
            ['name' => 'Bantuan BakSos', 'description' => 'Bantuan BakSos'],
            ['name' => 'Bantuan Sembako Ponpes Yatim', 'description' => 'Bantuan Sembako Ponpes Yatim'],
            ['name' => 'Bantuan Karyawan Pensiun', 'description' => 'Bantuan Karyawan Pensiun'],
            ['name' => 'Bantuan Pengelola Taman', 'description' => 'Bantuan Pengelola Taman'],
            ['name' => 'Akomodasi UPD', 'description' => 'Akomodasi UPD'],
            ['name' => 'Bantuan pendidikan yatim anak karyawan', 'description' => 'Bantuan pendidikan yatim anak karyawan'],
            ['name' => 'Bantuan pendidikan yatim anak Asatid', 'description' => 'Bantuan pendidikan yatim anak Asatid'],
            ['name' => 'Bantuan Karyawan sakit ( rawat inap )', 'description' => 'Bantuan Karyawan sakit ( rawat inap )'],
            ['name' => 'Bantuan Beasiswa santri', 'description' => 'Bantuan Beasiswa santri'],
            ['name' => 'Pembelian Kitab', 'description' => 'Pembelian Kitab'],
            ['name' => 'Bantuan pengadaan Ponpes / Masjid/Madrasah', 'description' => 'Bantuan pengadaan Ponpes / Masjid/Madrasah'],
            ['name' => 'Bantuan Haul', 'description' => 'Bantuan Haul'],
            ['name' => 'Konsumsi Meeting', 'description' => 'Konsumsi Meeting'],
            ['name' => 'Bantuan hewan qurban', 'description' => 'Bantuan hewan qurban'],
            ['name' => 'Bantuan sosial Luar Negeri', 'description' => 'Bantuan sosial Luar Negeri'],
            ['name' => 'Training', 'description' => 'Training'],
            ['name' => 'Seminar', 'description' => 'Seminar'],
            ['name' => 'Snack Meeting', 'description' => 'Snack Meeting'],
            ['name' => 'Biaya Raker', 'description' => 'Biaya Raker'],
            ['name' => 'Biaya Chanel Youtube', 'description' => 'Biaya Chanel Youtube'],
            ['name' => 'Biaya Study Banding', 'description' => 'Biaya Study Banding'],
            ['name' => 'Biaya Muktamar', 'description' => 'Biaya Muktamar'],
            ['name' => 'Biaya Kalender', 'description' => 'Biaya Kalender'],
            ['name' => 'Jadwal Imsakiyah', 'description' => 'Jadwal Imsakiyah'],
            ['name' => 'Snack Prepare sholat Jumat', 'description' => 'Snack Prepare sholat Jumat'],
            ['name' => 'Konsumsi Kajian Mingguan', 'description' => 'Konsumsi Kajian Mingguan'],
            ['name' => 'Pulsa Internet', 'description' => 'Pulsa Internet'],
            ['name' => 'Konsumsi UPD', 'description' => 'Konsumsi UPD'],
            ['name' => 'Kajian Mingguan Kemuslimahan', 'description' => 'Kajian Mingguan Kemuslimahan'],
            ['name' => 'Konsumsi Kajian Kemuslimahan', 'description' => 'Konsumsi Kajian Kemuslimahan'],
            ['name' => 'Program Seminar', 'description' => 'Program Seminar'],
            ['name' => 'Training skill kemuslimahan', 'description' => 'Training skill kemuslimahan'],
            ['name' => 'Silaturahim ke Asatid', 'description' => 'Silaturahim ke Asatid'],
            ['name' => 'Training Tahsin / Tajwid', 'description' => 'Training Tahsin / Tajwid'],
            ['name' => 'Bagi hasil Bank Syariah', 'description' => 'Bagi hasil Bank Syariah'],
            ['name' => 'Transfer ke Kas Kecil', 'description' => 'Transfer ke Kas Kecil'],
            ['name' => 'Infak karyawan', 'description' => 'Infak karyawan'],
            ['name' => 'Adm Bank', 'description' => 'Adm Bank'],
            ['name' => 'Transfer dari kas besar ke Kas Kecil', 'description' => 'Transfer dari kas besar ke Kas Kecil'],
            ['name' => 'Transfer dari kas kecil ke kas besar', 'description' => 'Transfer dari kas kecil ke kas besar'],
            ['name' => 'Infak Karyawan', 'description' => 'Infak Karyawan'],
            ['name' => 'Kotak Infak', 'description' => 'Kotak Infak'],
            ['name' => 'Bantuan Management', 'description' => 'Bantuan Management'],
            ['name' => 'Bantuan PUK', 'description' => 'Bantuan PUK'],
            ['name' => 'Bantuan Koperasi', 'description' => 'Bantuan Koperasi'],
            ['name' => 'Bantuan dari Luar', 'description' => 'Bantuan dari Luar'],
            ['name' => 'Kotak Infak Koperasi', 'description' => 'Kotak Infak Koperasi'],
        ];

        foreach ($categories as $category) {
            ExpenseCategory::create($category);
        }
    }
}
