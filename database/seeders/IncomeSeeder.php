<?php

namespace Database\Seeders;

use App\Models\Income;
use App\Models\Provider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_MX');
        $providers = Provider::all();
        
        if ($providers->isEmpty()) {
            $this->command->warn('No hay proveedores. Ejecuta primero ProviderSeeder.');
            return;
        }
        
        $concepts = [
            'Venta de productos',
            'Servicios de consultoría',
            'Venta de mercancía',
            'Servicios profesionales',
            'Ingresos por servicios',
            'Venta de inventario',
            'Servicios de mantenimiento',
            'Ingresos por comisiones',
            'Venta de productos terminados',
            'Servicios de asesoría',
            'Ingresos por arrendamiento',
            'Venta de servicios',
            'Ingresos por intereses',
            'Servicios de instalación',
            'Venta de productos manufacturados',
        ];
        
        $totalIncomes = 35;
        
        for ($i = 0; $i < $totalIncomes; $i++) {
            Income::create([
                'provider_id' => $faker->randomElement($providers)->id,
                'amount' => $faker->randomFloat(2, 500, 50000),
                'concept' => $faker->randomElement($concepts),
                'date' => $faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
                'description' => $faker->optional(0.7)->sentence(),
            ]);
        }
    }
}
