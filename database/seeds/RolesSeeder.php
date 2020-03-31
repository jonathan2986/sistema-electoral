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
        Roles::create(
        [
            'name' =>'Admin'
        ]);
        Roles::create([
            'name' => 'Coordiandor de Provincia'
        ]);

        Roles::create([
            'name' => 'Coordinador de Municipio'
        ]);
        
        Roles::create([
            'name' => 'Coordinador de Distrito'
        ]);

        Roles::create([
            'name' => 'Coordinador de Recinto'
        ]);

        Roles::create([
            'name' => 'Coordinador de Colegio'
        ]);

        Roles::create([
            'name' => 'Digitador'
        ]);
    }
}
