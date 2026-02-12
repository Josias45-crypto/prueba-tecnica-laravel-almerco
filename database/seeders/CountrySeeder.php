<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear Perú
        $peru = Country::create([
            'name' => 'Perú',
            'code' => 'PE'
        ]);

        // Lima
        $lima = State::create([
            'country_id' => $peru->id,
            'name' => 'Lima'
        ]);

        City::create(['state_id' => $lima->id, 'name' => 'Lima']);
        City::create(['state_id' => $lima->id, 'name' => 'Callao']);
        City::create(['state_id' => $lima->id, 'name' => 'San Isidro']);
        City::create(['state_id' => $lima->id, 'name' => 'Miraflores']);

        // Arequipa
        $arequipa = State::create([
            'country_id' => $peru->id,
            'name' => 'Arequipa'
        ]);

        City::create(['state_id' => $arequipa->id, 'name' => 'Arequipa']);
        City::create(['state_id' => $arequipa->id, 'name' => 'Cayma']);
        City::create(['state_id' => $arequipa->id, 'name' => 'Yanahuara']);

        // Cusco
        $cusco = State::create([
            'country_id' => $peru->id,
            'name' => 'Cusco'
        ]);

        City::create(['state_id' => $cusco->id, 'name' => 'Cusco']);
        City::create(['state_id' => $cusco->id, 'name' => 'Wanchaq']);
        City::create(['state_id' => $cusco->id, 'name' => 'Santiago']);

        // La Libertad
        $laLibertad = State::create([
            'country_id' => $peru->id,
            'name' => 'La Libertad'
        ]);

        City::create(['state_id' => $laLibertad->id, 'name' => 'Trujillo']);
        City::create(['state_id' => $laLibertad->id, 'name' => 'Huanchaco']);

        // Piura
        $piura = State::create([
            'country_id' => $peru->id,
            'name' => 'Piura'
        ]);

        City::create(['state_id' => $piura->id, 'name' => 'Piura']);
        City::create(['state_id' => $piura->id, 'name' => 'Sullana']);
    }
}
