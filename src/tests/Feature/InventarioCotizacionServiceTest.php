<?php

namespace Tests\Feature;

use App\Models\Inventario;
use App\Services\InventarioCotizacionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class InventarioCotizacionServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_updates_precioventa_from_preciosus_and_creates_a_backup_table(): void
    {
        Inventario::create([
            'idprod' => 'A-001',
            'marca' => 'Marca X',
            'cantidad' => 10,
            'categoria' => 'Accesorios',
            'unidad' => 'und',
            'preciolocal' => 10,
            'precioventa' => 0,
            'preciosus' => 1.25,
            'comision' => 0,
            'deposito' => 'A',
            'proveedor' => 'Prov',
            'descripcion' => 'Producto de prueba',
            'imagenes' => '[]',
            'img1' => null,
            'img2' => null,
            'img3' => null,
        ]);

        $service = new InventarioCotizacionService();
        $result = $service->aplicarCotizacion(7.2);

        $this->assertSame(9, (int) Inventario::first()->precioventa);
        $this->assertNotEmpty($result['tabla_backup']);
        $this->assertTrue(Schema::hasTable($result['tabla_backup']));
        $this->assertMatchesRegularExpression('/^inventarios_backup_\d{8}_\d{6}$/', $result['tabla_backup']);
    }
}
