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
        Schema::table('branches', function (Blueprint $table) {
            $table->renameColumn('text', 'alamat');
            $table->renameColumn('telepom', 'telepon');
        });
    }

    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->renameColumn('alamat', 'text');
            $table->renameColumn('telepon', 'telepom');
        });
    }
};
