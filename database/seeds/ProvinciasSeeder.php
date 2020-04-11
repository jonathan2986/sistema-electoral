<?php

use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use App\Provincias;

class ProvinciasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $client = new Client();

        $response = $client->get('http://provinciasrd.raydelto.org/provincias');
        $body = $response->getBody();
        $provincias = json_decode($body, true);
        $provincias = $provincias['data'];
        
        foreach($provincias as $provincia){
            printf("{$provincia['nombre']} \n");
            Provincias::create([
                'name' => $provincia['nombre']
            ]);
        }
    }
}
