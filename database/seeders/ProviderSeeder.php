<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_MX');
        
        $companyNames = [
            'Distribuidora Nacional S.A. de C.V.',
            'Suministros Industriales del Norte',
            'Comercializadora del Pacífico',
            'Proveedores Unidos de México',
            'Servicios y Abastecimientos S.A.',
            'Grupo Empresarial del Sureste',
            'Distribuidora Central de México',
            'Suministros y Servicios Integrales',
            'Comercializadora Nacional',
            'Proveedores del Bajío',
            'Distribuidora Regional S.A.',
            'Suministros Industriales del Centro',
            'Comercializadora del Golfo',
            'Proveedores y Servicios S.A.',
            'Distribuidora del Noroeste',
            'Suministros Nacionales S.A. de C.V.',
            'Comercializadora del Sur',
            'Proveedores Integrales de México',
            'Distribuidora del Sureste',
            'Suministros y Servicios S.A.',
            'Comercializadora del Norte',
            'Proveedores del Centro',
            'Distribuidora Nacional de Suministros',
            'Suministros Industriales S.A.',
            'Comercializadora Regional',
            'Proveedores y Distribuidores S.A.',
            'Distribuidora del Pacífico',
            'Suministros del Golfo',
            'Comercializadora Nacional S.A.',
            'Proveedores Unidos S.A. de C.V.',
            'Distribuidora Integral de México',
            'Suministros y Abastecimientos',
            'Comercializadora del Centro',
            'Proveedores Nacionales S.A.',
            'Distribuidora Regional del Norte',
        ];
        
        foreach ($companyNames as $name) {
            Provider::create([
                'name' => $name,
            ]);
        }
        
        $remaining = 30 - count($companyNames);
        if ($remaining > 0) {
            for ($i = 0; $i < $remaining; $i++) {
                Provider::create([
                    'name' => $faker->company() . ' ' . $faker->randomElement(['S.A.', 'S.A. de C.V.', 'S. de R.L.']),
                ]);
            }
        }
    }
}
