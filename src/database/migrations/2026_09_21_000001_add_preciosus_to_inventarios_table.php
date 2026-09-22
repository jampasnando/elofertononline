<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventarios', function (Blueprint $table) {
            if (!Schema::hasColumn('inventarios', 'preciosus')) {
                $table->decimal('preciosus', 12, 2)->nullable()->after('preciolocal');
            }
        });
    }

    public function down(): void
    {
        Schema::table('inventarios', function (Blueprint $table) {
            if (Schema::hasColumn('inventarios', 'preciosus')) {
                $table->dropColumn('preciosus');
            }
        });
    }
};
