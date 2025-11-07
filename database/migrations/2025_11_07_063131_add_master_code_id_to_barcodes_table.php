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
        Schema::table('barcodes', function (Blueprint $table) {
            $table->foreignId('master_code_id')->nullable()->after('id')->constrained('master_codes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barcodes', function (Blueprint $table) {
            $table->dropForeign(['master_code_id']);
            $table->dropColumn('master_code_id');
        });
    }
};
