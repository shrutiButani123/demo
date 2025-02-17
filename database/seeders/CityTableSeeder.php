<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;
use App\Models\City;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gujarat = State::where('name', 'Gujarat')->first()->id;
        $maharastra = State::where('name', 'Maharastra')->first()->id;
        $rajasthan = State::where('name', 'Rajasthan')->first()->id;
        
        City::create(['state_id' => $gujarat, 'name' => 'Surat']);
        City::create(['state_id' => $gujarat, 'name' => 'Ahmedabad']);
        City::create(['state_id' => $gujarat, 'name' => 'Rajkot']);

        City::create(['state_id' => $maharastra, 'name' => 'Mumbai']);
        City::create(['state_id' => $maharastra, 'name' => 'Pune']);
        City::create(['state_id' => $maharastra, 'name' => 'Nagpur']);

        City::create(['state_id' => $rajasthan, 'name' => 'Jaipur']);
        City::create(['state_id' => $rajasthan, 'name' => 'Jodhpur']);
        City::create(['state_id' => $rajasthan, 'name' => 'Udaipur']);
    }
}
