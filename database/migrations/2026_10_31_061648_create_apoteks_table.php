
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
        Schema::create('apoteks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama', 150);
            $table->text('deskripsi')->nullable();
            $table->text('alamat');
            $table->string('phone_number', 20)->nullable();
            $table->string('foto_apotek', 255)->nullable();
            $table->string('status', 20)->default('aktif');
            $table->string('jam_buka', 50)->nullable();
            $table->string('jam_tutup', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apoteks');
    }
};
