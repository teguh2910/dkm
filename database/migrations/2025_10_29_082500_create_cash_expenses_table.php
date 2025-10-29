<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cash_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barcode_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('dibayarkan_kepada');
            $table->decimal('sebesar', 15, 2);
            $table->string('terbilang');
            $table->foreignId('expense_category_id')->constrained()->cascadeOnDelete();
            $table->text('keterangan2')->nullable();
            $table->enum('status_bendahara', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('status_sekretaris', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('status_ketua', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('approved_bendahara_at')->nullable();
            $table->timestamp('approved_sekretaris_at')->nullable();
            $table->timestamp('approved_ketua_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_expenses');
    }
};
