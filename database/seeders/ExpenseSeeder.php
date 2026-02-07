<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\Provider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ExpenseSeeder extends Seeder
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
            'Compra de materiales',
            'Servicios de mantenimiento',
            'Gastos de operación',
            'Compra de suministros',
            'Servicios profesionales',
            'Gastos de transporte',
            'Compra de mercancía',
            'Servicios de consultoría',
            'Gastos administrativos',
            'Compra de equipo',
            'Servicios de instalación',
            'Gastos de servicios públicos',
            'Compra de insumos',
            'Servicios de reparación',
            'Gastos de almacenamiento',
        ];
        
        $totalExpenses = 35;
        
        for ($i = 0; $i < $totalExpenses; $i++) {
            Expense::create([
                'provider_id' => $faker->randomElement($providers)->id,
                'amount' => $faker->randomFloat(2, 200, 30000),
                'concept' => $faker->randomElement($concepts),
                'date' => $faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
                'description' => $faker->optional(0.7)->sentence(),
            ]);
        }
    }
}
