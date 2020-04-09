<?php

use Illuminate\Database\Seeder;
use App\Provincias;
use App\Circunscripciones;
use App\Municipios;
use App\Recintos;
use App\People;
use App\ColegiosElectorales;
use App\Votantes;
use App\User;
use App\RolesUsers;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Provincias::create([
            'name' => 'Provincia Admin'
        ]);
        
        Circunscripciones::create([
            'name' => 'Admin Circunscripciones'
        ]);

        Municipios::create([
            'circunscripciones_id' => '1',
            'provincias_id' => '1',
            'name' => 'Admin Municipios',
        ]);
        
        Recintos::create([
            'municipios_id' => 1,
            'name' => 'Recintos Admin',
            'address' =>' '
        ]);
        
        People::create([
            'first_name' => 'Admin First Name',
            'last_name' => 'Admin Last Name',
            'card_id' => '111-1111111-9',
            'phone_number' => '111-111-1111',
            'celphone' => '111-111-1111',
            'email' => 'admin@sistemaelectoral.com',
            'date_birthdate' => '2020-04-04',
            'profession' => 'Progamador',
        ]);
        
        ColegiosElectorales::create([
            'recintos_id' => 1,
            'name' => 'Colegio Admin'
        ]);

        Votantes::create([
            'people_id' => 1,
            'circunscripciones_id' => 1,
            'municipios_id'=> 1,
            'distritos_id' => 1,
            'recintos_id' => 1,
            'colegios_electorales_id' => 1,
            'first_name' => 'Admin First Name',
            'last_name' => 'Admin Last Name',
            'card_id' => '111-1111111-9',
        ]);

        User::create([
            'name' => 'admin',
            'email' => 'admin', 
            'password' => bcrypt('Admin@2020'),
            'votantes_id' => '1',
        ]);
        
        RolesUsers::create([
            'users_id' => '1',
            'roles_id' => '1',
            'entity' => 'Admin',
            'entity_id' => '1'
        ]);
    }
}
