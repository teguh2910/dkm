<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For SQLite, we need to recreate the table without foreign keys
        // Then add back only the necessary foreign keys

        // Disable foreign key checks
        DB::statement('PRAGMA foreign_keys = OFF');

        // Create new table without expense_category_id
        Schema::create('cash_expenses_new', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barcode_id')->constrained('barcodes')->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('dibayarkan_kepada');
            $table->decimal('sebesar', 15, 2);
            $table->string('terbilang');
            $table->text('keterangan2')->nullable();
            $table->string('status_bendahara')->default('pending');
            $table->string('status_sekretaris')->default('pending');
            $table->string('status_ketua')->default('pending');
            $table->timestamp('approved_bendahara_at')->nullable();
            $table->timestamp('approved_sekretaris_at')->nullable();
            $table->timestamp('approved_ketua_at')->nullable();
            $table->integer('year')->nullable();
            $table->timestamps();
        });

        // Copy data from old table to new table (excluding expense_category_id)
        DB::statement('
            INSERT INTO cash_expenses_new 
            (id, barcode_id, tanggal, dibayarkan_kepada, sebesar, terbilang, keterangan2, 
             status_bendahara, status_sekretaris, status_ketua, 
             approved_bendahara_at, approved_sekretaris_at, approved_ketua_at, year, created_at, updated_at)
            SELECT 
            id, barcode_id, tanggal, dibayarkan_kepada, sebesar, terbilang, keterangan2, 
            status_bendahara, status_sekretaris, status_ketua, 
            approved_bendahara_at, approved_sekretaris_at, approved_ketua_at, year, created_at, updated_at
            FROM cash_expenses
        ');

        // Drop old table
        Schema::dropIfExists('cash_expenses');

        // Rename new table to original name
        Schema::rename('cash_expenses_new', 'cash_expenses');

        // Re-enable foreign key checks
        DB::statement('PRAGMA foreign_keys = ON');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cash_expenses', function (Blueprint $table) {
            $table->foreignId('expense_category_id')->nullable()->after('terbilang')->constrained('expense_categories');
        });
    }
};
