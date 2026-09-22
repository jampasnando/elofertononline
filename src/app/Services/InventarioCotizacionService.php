<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InventarioCotizacionService
{
    public function aplicarCotizacion(float $cotizacionDolarBs): array
    {
        $cotizacion = max(0, $cotizacionDolarBs);
        $timestamp = now()->format('Ymd_His');
        $tablaBackup = 'inventarios_backup_' . $timestamp;

        if (Schema::hasTable($tablaBackup)) {
            Schema::dropIfExists($tablaBackup);
        }

        DB::statement('CREATE TABLE ' . $tablaBackup . ' AS SELECT * FROM inventarios');

        $inventarios = DB::table('inventarios')->get();

        foreach ($inventarios as $inventario) {
            $precioSus = (float) ($inventario->preciosus ?? 0);
            $precioVenta = $precioSus > 0 ? (int) ceil($precioSus * $cotizacion) : (float) ($inventario->precioventa ?? 0);

            DB::table('inventarios')
                ->where('id', $inventario->id)
                ->update([
                    'precioventa' => $precioVenta,
                ]);
        }

        return [
            'cotizacion' => $cotizacion,
            'tabla_backup' => $tablaBackup,
            'actualizados' => $inventarios->count(),
        ];
    }
}
