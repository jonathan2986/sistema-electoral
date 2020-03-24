<?php

use Illuminate\Database\Seeder;
use App\Roles;
class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Roles::create([
            'name' =>'Admin'
        ],
        [
            'name' => 'Coordiandor de Provincia'
        ],
        [
            'name' => 'Coordinador de Municipio'
        ],
        [
            'name' => 'Coordinador de Distrito'
        ],
        [
            'name' => 'Coordinador de Recinto'
        ],
        [
            'name' => 'Coordinador de Colegio'
        ],
        [
            'name' => 'Digitador'
        ]);
    }
}
